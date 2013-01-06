<?php

namespace GeniusDesign\Components\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation\FormType;

/**
 * Gallery form
 * 
 * @author Pawel Cichon <pawel.cichon@meritoo.pl>
 * @copyright GeniusDesign
 */
class GalleryType extends AbstractType {

    /**
     * Information if the description field should be displayed
     * @var boolean 
     */
    private $isGalleryDescriptionEnabled = true;

    /**
     * Class constructor
     * 
     * @param [boolean $isGalleryDescriptionEnabled = true]
     * @return void
     */
    public function __construct($isGalleryDescriptionEnabled = true) {
        $this->isGalleryDescriptionEnabled = $isGalleryDescriptionEnabled;
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
        $builder->add('title', null, array(
            'required' => true,
            'label' => 'Tytuł',
            'attr' => array(
                'placeholder' => 'Tytuł'
            )
        ));
        if ($this->isGalleryDescriptionEnabled) {
            $builder->add('description', null, array(
                'required' => false,
                'label' => 'Opis',
                'attr' => array(
                    'placeholder' => 'Opis'
                )
            ));
        }
    }

    /*
      public function setDefaultOptions(OptionsResolverInterface $resolver) {
      $resolver->setDefaults(array(
      'data_class' => 'GeniusDesign\Components\GalleryBundle\Entity\Gallery',
      ));
      }
     */

    public function getName() {
        return 'genius_design_gallery';
    }

}