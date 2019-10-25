<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder
            ->add('email', TextType::class, [
                'required' => false,
                'label' => 'Adresse email',
                'label_attr' => array('class' => 'form-label'),
                'attr' => [
                    'placeholder' => 'Adresse email'
                ],
            ])
            ->add('lastnameUser', TextType::class, [
                'required' => false,
                'label' => 'Nom',
                'label_attr' => array('class' => 'form-label'),
                'attr' => [
                    'placeholder' => 'Nom',
                ],
            ])
            ->add('nameUser', TextType::class, [
                'required' => false,
                'label' => 'Prenom',
                'label_attr' => array('class' => 'form-label'),
                'attr' => [
                    'placeholder' => 'Prenom'
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passes ne sont pas identiques.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => false,
                'first_options'  => ['label' => 'Mot de passe', 'label_attr' => array('class' => 'form-label'), 'attr' => array('placeholder' => 'Mot de passe') ],
                'second_options' => ['label' => 'Confirmation', 'label_attr' => array('class' => 'form-label'), 'attr' => array('placeholder' => 'Mot de passe')],
            ])
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
