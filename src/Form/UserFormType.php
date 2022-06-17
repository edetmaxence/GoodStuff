<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'constraints' => [
                    new Email([
                        'message' => 'Cet email est invalide'
                    ]),
                    new NotBlank([
                        'message' => 'Ce champs est obligatoire'
                    ])
                ]
            ])
           /*  ->add('password', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer le mot de passe',
                    ]),
                    new Length([
                        'min' => 12,
                        'minMessage' => 'Mot de passe doit être au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ]
            ]) */
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'required' => true
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => true
            ])
            ->add('postcode', TextType::class, [
                'label' => 'Code Postale'
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'required' => true
            ])
            ->add('phonenumber', TextType::class, [
                'label' => 'Téléphone',
                'required' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
