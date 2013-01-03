<?php

namespace GeniusDesign\Components\LanguageBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Helper for the language
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class LanguageHelper {

    /**
     * The container
     * @var ContainerInterface
     */
    private $container = null;

    /**
     * Class constructor
     * 
     * @param ContainerInterface $container The container
     * @return void
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    /**
     * Returns container
     * @return ContainerInterface
     */
    public function getContainer() {
        return $this->container;
    }

    /**
     * Returns name of the language parameter for request
     * @return string
     */
    public function getLanguageRequestParameterName() {
        return $this->getContainer()->getParameter('genius_design_language.language_request_parameter_name');
    }

    /**
     * Returns name of the language parameter for request
     * @return string
     */
    public function getDefaultLanguageCodeFromConfig() {
        return $this->getContainer()->getParameter('genius_design_language.default_language_code');
    }

    /**
     * Returns informations if languages are defined
     * @return boolean 
     */
    public function areLanguagesDefined() {
        $result = false;

        $languages = $this->getContainer()
                ->get('doctrine')
                ->getRepository('GeniusDesignComponentsLanguageBundle:Language')
                ->getRows();

        if (!empty($languages)) {
            $result = true;
        }

        return $result;
    }

    /**
     * Returns informations if languages exists by given language code
     * 
     * @param string $languageCode
     * @return boolean 
     */
    public function isLanguageExists($languageCode) {
        $result = false;

        if (!empty($languageCode)) {
            $languages = $this->getContainer()
                    ->get('doctrine')
                    ->getRepository('GeniusDesignComponentsLanguageBundle:Language')
                    ->getLanguageByCode($languageCode);

            if (!empty($languages)) {
                $result = true;
            }
        }

        return $result;
    }

    /**
     * Sets the locale in translatable listener.
     * 
     * This operation is required, because the translatable listener tries to load
     * default locale, currently en_US, defined inside the translatable listener's class.
     * 
     * @return \GeniusDesign\Components\LanguageBundle\Helper\LanguagesHelper
     */
    public function setTranslatableLocale() {
        $locale = $this->getContainer()
                ->get('request')
                ->getLocale();

        $this->getContainer()
                ->get('gedmo.listener.translatable')
                ->setTranslatableLocale($locale);

        return $this;
    }

    /**
     * Returns LCID code of language from request (e.g. pl_PL)
     * 
     * @param [boolean $force = true] If is set to true and short name of language was not found in request, short name of default language is returned. Otherwise - not.
     * @return boolean
     */
    public function getLanguageLcid($force = true) {
        $languageLcid = '';
        $container = $this->getContainer();
        $languageCode = $this->getLanguageCode($force);

        $language = $container->get('doctrine')
                ->getRepository('GeniusDesignComponentsLanguageBundle:Language')
                ->getLanguageByCode($languageCode);

        if (!empty($language)) {
            $languageLcid = $language->getLanguageLcid();
        }

        return $languageLcid;
    }

    /**
     * Returns code of language from request
     * 
     * @param [boolean $force = true] If is set to true and short name of language was not found in request, short name of default language is returned. Otherwise - not.
     * @return boolean
     */
    public function getLanguageCode($force = true) {
        $languageCode = $this->getContainer()
                ->get('request')
                ->get($this->getLanguageRequestParameterName());

        $checkLanguage = $this->isLanguageExists($languageCode);

        if (!empty($languageCode) && empty($checkLanguage)) {
            $languageCode = $this->getDefaultLanguageCode();
        }

        if ($force && empty($languageCode)) {
            $languageCode = $this->getDefaultLanguageCode();
        }

        return $languageCode;
    }

    /**
     * Returns code of the default language
     * @return string
     */
    public function getDefaultLanguageCode() {
        $titleShort = null;
        $language = $this->getDefaultLanguage();

        if (!empty($language)) {
            $languageCode = $language->getLanguageCode();
        } else {
            $languageCode = $this->getDefaultLanguageCodeFromConfig();
        }

        return $languageCode;
    }

    /**
     * Returns the default langugage
     * @return \GeniusDesign\Components\LanguageBundle\Entity\Language
     */
    public function getDefaultLanguage() {
        $container = $this->getContainer();

        return $container->get('doctrine')
                        ->getRepository('GeniusDesignComponentsLanguageBundle:Language')
                        ->getDefaultLanguage();
    }

}
