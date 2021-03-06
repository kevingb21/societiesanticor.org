<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

use App\Entity\Branch;

class CompanyRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom de la structure',
                'attr' => ['class' => 'form-control'],
                'row_attr' => [
                    'class' => 'form-group'
                ]
            ])
            ->add('email', RepeatedType::class, [
                'invalid_message' => 'Vous devez renseigner une adresse mail valide et la confirmer dans le champ suivant.',
                'first_options'  => [
                    'label' => 'Adresse mail de l\'entreprise',
                    'attr' => ['class' => 'form-control'],
                    'row_attr' => [
                        'class' => 'form-group'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation de l\'adresse mail ',
                    'attr' => ['class' => 'form-control'],
                    'row_attr' => [
                        'class' => 'form-group'
                    ]
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Vous devez renseigner un mot de passe valide et le confirmer dans le champ suivant.',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'attr' => ['class' => 'form-control'],
                    'row_attr' => [
                        'class' => 'form-group'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                    'attr' => ['class' => 'form-control'],
                    'row_attr' => [
                        'class' => 'form-group'
                    ]
                ],
                
            ])
            ->add('branch', EntityType::class, [
                'class' => Branch::class,
                'choice_label' => 'name',
                'label' => 'secteur d\'activité',
                'attr' => ['class' => 'form-control'],
                'row_attr' => [
                    'class' => 'form-group'
                ]
            ])
            ->add('add', SubmitType::class, [
                'label' => 'Créer le compte',
                'attr' => [
                    'class' => 'btn waves-effect btn-success waves-light'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
