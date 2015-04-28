<?php

namespace GaleriaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GaleriaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', 'text',[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nome: *'
            ])
            ->add('descricao', 'textarea',[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Descrição',
                'required' => false,
            ])
            ->add('imagens', 'collection', [
                'type' => new GaleriaImagemType(),
                'required' => false,
                'options' => array('data_class' => 'GaleriaBundle\Entity\GaleriaImagens'),
                'allow_add'    => true,
                'prototype' => true,
                'by_reference' => false,
                'attr' => [
                    "multiple" => "multiple",
                ],
                'label' => 'Fotos'
            ])
            ->add('isAtivo', 'choice', [
                'choices' => [true => 'Sim', false => 'Não'],
                'label' => 'Galeria visivel?*',
                'multiple' => false,
                'expanded' => true,
                'required' => true,
            ])
            ->add('save', 'submit', [
                'label' => 'Salvar',
                'attr' => [
                    'class' => 'btn btn-default'
                ]
            ])
            ->add('id', 'hidden')
            ->add('reset', 'reset', [
                'label' => 'Resetar',
                'attr' => [
                    'class' => 'btn btn-default'
                ]
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GaleriaBundle\Entity\Galeria'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'galeria';
    }
}
