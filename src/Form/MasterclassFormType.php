<?php

namespace App\Form;

use App\Entity\GameType;
use App\Entity\Masterclass;
use App\Entity\Tournament;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MasterclassFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('gametype', EntityType::class, [
                'class' => GameType::class,
                'choice_label' => 'name',
            ])
            ->add('minimumRating')
            ->add('maximumMembers')
            ->add('visitors', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('startTime', DateTimeType::class, [
                'data' => new \DateTime()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Masterclass::class,
        ]);
    }
}
