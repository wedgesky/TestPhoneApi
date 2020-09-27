<?php

namespace App\Form;

use App\Controller\TestRecordsController;
use App\Entity\TestPhone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestPhoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sms_phone')
            ->add('result',TextareaType::class, array(
                'attr' => array(
                    'readonly' => true,
                )))
            ->add('reason',TextareaType::class, array(
                'attr' => array(
                    'readonly' => true,
                )))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TestPhone::class,
        ]);
    }
}
