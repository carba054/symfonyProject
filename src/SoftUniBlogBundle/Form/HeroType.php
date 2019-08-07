<?php

namespace SoftUniBlogBundle\Form;

use SoftUniBlogBundle\Entity\Magics;
use SoftUniBlogBundle\Entity\Types;
use SoftUniBlogBundle\Repository\MagicsRepository;
use SoftUniBlogBundle\Repository\TypesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use SoftUniBlogBundle\Form\StringToArrayTransformer;


class HeroType extends AbstractType
{

    private $magicRepository;
    private $typeRepository;

    public function __construct(MagicsRepository $magicRepository, TypesRepository $typeRepository)
    {
        $this->typeRepository= $typeRepository;
        $this->magicRepository=$magicRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('name');
//            ->add('typeId', ChoiceType::class, array(
//                'multiple' => false,
//                'expanded' => true,
//                'choices' => [
//                    'type1' => 1,
//                    'type2' => 2,
//                    'type3' => 3,
//                ]
//            ))
//            ->add('magics', ChoiceType::class, array(
//                'multiple' => false,
//                'expanded' => true,
//                'choices' => [
//                    'magic1' => 1,
//                    'magic2' => 2,
//                    'magic3' => 3,
//                    'magic4' => 4,
//                    'magic5' => 5,
//                    'magic6' => 6,
//                ]
//            ));



    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => 'SoftUniBlogBundle\Entity\Hero'
        ]);
    }




}
