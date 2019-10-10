<?php

namespace App\Form;

use App\Entity\PlatformVideo;
use App\Entity\Video;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder
            ->add('url',UrlType::class, [
                'attr' => [
                    'placeholder' => 'Url de la vidéo',
                    'class' => 'form-control-file border'
                ]
            ])
            ->add('platformVideo', EntityType::class, array(
                'class' => PlatformVideo::class,
                'expanded'     => false,
                'multiple'     => false,
                'choice_label' => function(PlatformVideo $platformVideo) {
                    return $platformVideo->getNamePlatform(); }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
