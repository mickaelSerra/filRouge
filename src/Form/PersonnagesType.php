<?php

namespace App\Form;

use App\Entity\Jeux;
use App\Entity\Personnages;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PersonnagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photos', FileType::class,[
                'label' => 'photos',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k'
                    ])
                ]

            ])
            ->add('date_de_naissance', DateType::class,[

                'widget' => 'single_text'
            ])
            ->add('Biographie')
            ->add('Nom')
            ->add('Prenom')
            ->add('jeux', EntityType::class, [
                'class' => Jeux::class,
                'choice_label' => 'titre'
            ])
            ->add('Envoyer',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personnages::class,
        ]);
    }
}
