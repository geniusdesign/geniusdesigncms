<?php

namespace GeniusDesign\Components\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * The content type used to build content edit form
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class ContentType extends AbstractType {

    /**
     * Builds the form
     * 
     * @param FormBuilder $builder The form builder
     * @param array $options The options
     * @return void
     * 
     * @see Symfony\Component\Form\AbstractType::buildForm()
     */
    public function buildForm(FormBuilder $builder, array $options) {
        $fieldOptions = array('attr' => array('class' => 'text '));
        $builder->add('content', null, array_merge($fieldOptions, array('label' => 'Treść:', 'attr' => array('class' => 'tinymce'), 'required' => false)));
    }

    /**
     * Returns the name of this type
     * @return string
     */
    public function getName() {
        return 'content';
    }

}