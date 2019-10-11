<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder
            ->add('password', RepeatedType::class, [
                'data' => null,
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passes ne sont pas identiques.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => false,
                'first_options'  => ['label' => 'Mot de passe', 'attr' => array('placeholder' => 'Mot de passe') ],
                'second_options' => ['label' => 'Confirmation', 'attr' => array('placeholder' => 'Mot de passe')],
            ])
            ->add('email', HiddenType::class, [
                'data' => 'email@email.fr'
            ])
            ->add('nameuser', HiddenType::class, [
                'data' => 'nameuser'
            ])
            ->add('lastnameuser', HiddenType::class, [
                'data' => 'lastnameuser'
            ])
            ->add('Modifier', SubmitType::class, [
                'label' => 'Modifier'
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
