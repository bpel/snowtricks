<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\TypeTrick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nametrick', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nom de la figure'
                ],
                'label' => 'Nom',
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Description'
                ],
                'label' => 'Description',
            ])
            ->add('typetrick', EntityType::class, [
                'required' => false,
                'class' => TypeTrick::class,
                'choice_label' => function(TypeTrick $typeTrick) {
                    return $typeTrick->getNameTypetrick(); },
                'label' => 'Type',
            ])
            ->add('illustrations', CollectionType::class, [
                'required' => false,
                'entry_type' => IllustrationType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('videos', CollectionType::class, [
                'required' => false,
                'entry_type' => VideoType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
