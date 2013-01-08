<?php

namespace GeniusDesign\Components\SimpleUserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation\FormType;

/**
 * SimpleUser Login form
 * 
 * @author Pawel Cichon <pawel.cichon@meritoo.pl>
 * @copyright GeniusDesign
 */
class SimpleUserLoginType extends AbstractType {

    /**
     * Builds the form
     * 
     * @param FormBuilder $builder The form builder
     * @param array $options The options
     * @return void
     * 
     * @see Symfony\Component\Form\AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('email', 'email', array(
            'label' => 'Email',
            'attr' => array(
                'placeholder' => 'E-mail'
            )
        ));
        $builder->add('password', 'password', array(
            'label' => 'Hasło',
            'attr' => array(
                'placeholder' => 'Hasło'
            )
        ));
    }

    public function getName() {
        return 'genius_design_simple_user_login';
    }

}