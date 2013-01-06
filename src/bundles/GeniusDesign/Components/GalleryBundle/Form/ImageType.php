<?php

namespace GeniusDesign\Components\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation\FormType;
use GeniusDesign\Components\GalleryBundle\Form\GalleryType;

/**
 * The order type used to build image edit / displaying data
 * 
 * @author Pawel Cichon <pawel.cichon@meritoo.pl>
 * @copyright GeniusDesign
 */
class ImageType extends AbstractType {

    /**
     * Information if the image field should be displayed
     * @var boolean 
     */
    private $imageVisible = true;

    /**
     * Information if the autor field should be displayed
     * @var boolean 
     */
    private $isImageAutorEnabled = true;

    /**
     * Class constructor
     * 
     * @param [boolean $imageVisible = true] If is set to true, the image field is visible / displayed. Otherwise - not.
     * @return void
     */
    public function __construct($isImageAutorEnabled = true, $imageVisible = true) {
        $this->imageVisible = $imageVisible;
        $this->isImageAutorEnabled = $isImageAutorEnabled;
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
                'placeholder' => 'Tytuł zdjęcia'
            ),
            'read_only' => false
        ));
        if ($this->isImageAutorEnabled) {
            $builder->add('autor', null, array(
                'required' => false,
                'label' => 'Autor',
                'attr' => array(
                    'placeholder' => 'Autor zdjęcia'
                ),
                'read_only' => false
            ));
        }
        if ($this->imageVisible) {
            $builder->add('image', null, array(
                'required' => true,
                'label' => 'Zdjęcie',
                'attr' => array(),
                'read_only' => false
            ));
        }
    }

    public function getName() {
        return 'genius_design_gallery_image';
    }

}