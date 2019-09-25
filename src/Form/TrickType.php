<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => false
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            //->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onEdit'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }

    public function onEdit(FormEvent $event)
    {
        dump($event);
        dump($event->getData());
        $data = $event->getData();
        dump($data);
        dump($data['images']);
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer([$normalizer]);
        /** @var Trick $trick */
        $trick = $event->getForm()->getData();
        dump($trick);
        foreach ($data['images'] as $img) {
            $image = $serializer->denormalize(
                $img,
                Image::class
            );
            $trick->addImage($image);
        }
        dump($trick);
    }
}
