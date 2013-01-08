<?php

namespace GeniusDesign\Components\SimpleUserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation\FormType;

/**
 * SimpleUser form
 * 
 * @author Pawel Cichon <pawel.cichon@meritoo.pl>
 * @copyright GeniusDesign
 */
class SimpleUserType extends AbstractType {

    /**
     * Information if the description field should be displayed
     * @var boolean 
     */
    private $showPassword = false;

    /**
     * Class constructor
     * 
     * @param [boolean $showPassword = false]
     * @return void
     */
    public function __construct($showPassword = fasle) {
        $this->showPassword = $showPassword;
    }

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
        $builder->add('first_name', null, array(
            'required' => false,
            'label' => 'Imię',
            'attr' => array(
                'placeholder' => 'Imię'
            )
        ));
        $builder->add('last_name', null, array(
            'required' => false,
            'label' => 'Nazwisko',
            'attr' => array(
                'placeholder' => 'Nazwisko'
            )
        ));
        $builder->add('email', 'email', array(
            'read_only' => !$this->showPassword,
            'label' => 'Email',
            'attr' => array(
                'placeholder' => 'E-mail'
            )
        ));
        if ($this->showPassword) {
            $builder->add('password', null, array(
                'label' => 'Hasło',
                'attr' => array(
                    'placeholder' => 'Hasło'
                )
            ));
        }
        $builder->add('note', null, array(
            'label' => 'Notatka',
            'attr' => array(
                'placeholder' => 'Notatka'
            )
        ));
        $builder->add('role', 'entity', array(
            'class' => 'GeniusDesignComponentsSimpleUserBundle:Role',
            'query_builder' => function($repository) {
                return $repository->createQueryBuilder('r')->orderBy('r.id', 'ASC');
            },
            'property' => 'name',
            'label' => 'Rola',
            'attr' => array(
                'class' => ''
            )
        ));
    }

    /*
      public function setDefaultOptions(OptionsResolverInterface $resolver) {
      $resolver->setDefaults(array(
      'data_class' => 'GeniusDesign\Components\SimpleUserBundle\Entity\SimpleUser',
      ));
      }
     */

    public function getName() {
        return 'genius_design_simple_user';
    }

}