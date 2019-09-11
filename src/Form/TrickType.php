<?php

namespace App\Form;

use App\Entity\Illustration;
use App\Entity\Trick;
use App\Entity\TypeTrick;
use App\Entity\Video;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nametrick')
            ->add('description', TextareaType::class)
            ->add('typetrick', EntityType::class, array(
                'class' => TypeTrick::class,
                'expanded'     => false,
                'multiple'     => false,
                'choice_label' => function(TypeTrick $typeTrick) {
                    return $typeTrick->getId() . ' ' . $typeTrick->getNameTypetrick(); }
            ))
            ->add('illustrations',
                CollectionType::class, [
                'entry_type' => IllustrationType::class,
                'entry_options' => ['label' => false],
                    'allow_add' => true
            ])
            ->add('videos',
                CollectionType::class, [
                    'entry_type' => VideoType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true
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
