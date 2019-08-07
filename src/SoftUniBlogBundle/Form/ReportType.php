<?php

namespace SoftUniBlogBundle\Form;

use SoftUniBlogBundle\Entity\Hero;
use SoftUniBlogBundle\Entity\Reports;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('report1', TextType::class)
            ->add('report2', TextType::class)
            ->add('report3', TextType::class)
            ->add('report4', TextType::class)
            ->add('report5', TextType::class)
            ->add('report6', TextType::class)
            ->add('report7', TextType::class)
            ->add('attackerId', Hero::class)
            ->add('defenderId', Hero::class);

    }

    /**
    * {@inheritdoc}
    */
    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(array(
            'data_class' => 'SoftUniBlogBundle\Entity\Reports'
        ));
    }



}
