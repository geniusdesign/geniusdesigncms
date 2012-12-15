<?php

namespace GeniusDesign\Desktop\PanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * The login type used to build login's form
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class LoginType extends AbstractType {

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
        $builder->add('email', null, array_merge(array('attr' => array('class' => 'text')), array('label' => 'Login:')));
        $builder->add('password', 'password', array_merge(array('attr' => array('class' => 'text')), array('label' => 'Hasło:')));
    }

    /**
     * Returns the name of this type
     * @return string
     */
    public function getName() {
        return 'loginForm';
    }

}
