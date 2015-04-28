<?php

namespace GaleriaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GaleriaImagemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file',[
                'attr' => [
                    'class' => 'btn btn-default imagem_upload',
                    "multiple" => "multiple",
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
            'data_class' => 'GaleriaBundle\Entity\GaleriaImagens'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'galeria_imagens';
    }
}
