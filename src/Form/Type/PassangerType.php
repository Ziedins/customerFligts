<?php

namespace App\Form\Type;

use App\Entity\Passanger;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class PassangerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('passangers', EntityType::class, [
                'class' => Passanger::class,
                'choice_label' => function (Passanger $passanger) {
                    return $passanger->getTitle() . ' ' . $passanger->getName() . ' ' . $passanger->getSurname();
                },
                'required' => false,
                'multiple' => true,
                'expanded' => true
            ]);
    }
}