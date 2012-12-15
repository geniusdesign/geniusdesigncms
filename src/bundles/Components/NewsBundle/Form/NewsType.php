<?php

namespace GeniusDesign\Components\NewsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * The news type used to build news edit form
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class NewsType extends AbstractType {

    /**
     * Information if the date field should be displayed
     * @var boolean 
     */
    private $dateVisible = true;

    /**
     * Information if the image field should be displayed
     * @var boolean 
     */
    private $imageVisible = true;

    /**
     * Format date
     * @var string
     */
    private $formatDate;

    /**
     * Class constructor
     * 
     * @param [boolean $dateVisible = true] If is set to true, the date field is visible / displayed. Otherwise - not.
     * @param [boolean $imageVisible = true] If is set to true, the image field is visible / displayed. Otherwise - not.
     * @param [string $formatDate = 'dd.MM.yyyy'] Date format
     * @return void
     */
    public function __construct($dateVisible = true, $imageVisible = true, $formatDate = 'dd.MM.yyyy') {
        $this->dateVisible = $dateVisible;
        $this->imageVisible = $imageVisible;
        $this->formatDate = $formatDate;
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
    public function buildForm(FormBuilder $builder, array $options) {
        $fieldOptions = array('attr' => array('class' => 'text '));

        $builder->add('title', null, array_merge($fieldOptions, array('label' => 'Tytuł:')));

        if ($this->imageVisible) {
            $builder->add('image_file_name', null, array_merge($fieldOptions, array('label' => 'Zdjęcie:', 'required' => false)));
        }

        if ($this->dateVisible) {
            $builder->add('displayed_date', 'date', array_merge(array('attr' => array('class' => 'text datepicker')), array('label' => 'Wyświetlana data:', 'format' => $this->formatDate, 'widget' => 'single_text')));
        }

        $builder->add('entrance', null, array_merge($fieldOptions, array('label' => 'Wstęp:', 'attr' => array('class' => 'tinymce'), 'required' => false)));
        $builder->add('content', null, array_merge($fieldOptions, array('label' => 'Treść:', 'attr' => array('class' => 'tinymce'), 'required' => false)));
    }

    /**
     * Returns the name of this type
     * @return string
     */
    public function getName() {
        return 'news';
    }

}