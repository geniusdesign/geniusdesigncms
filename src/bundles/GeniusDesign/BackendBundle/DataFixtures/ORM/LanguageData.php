<?php

namespace GeniusDesign\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GeniusDesign\Components\LanguageBundle\Entity\Language;

/**
 * Loads default data for language
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class LanguageData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

    /**
     * The container
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null) {
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
     * Load data fixtures with the passed EntityManager
     *
     * @param Doctrine\Common\Persistence\ObjectManager $manager
     * @return void
     */
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager) {
        $defaultLanguage = 'de_DE';

        $languagesData = array(
            'pl_PL' => 'Polski',
            'en_GB' => 'Angielski',
            'de_DE' => 'Niemiecki',
            'ru_RU' => 'Rosyjski'
        );

        $languages = array();

        foreach ($languagesData as $code => $languageName) {
            $languageCode = strtolower(substr($code, 0, 2));
            $flagPath = '/bundles/geniusdesigncommon/img/flags/' . $languageCode . '.png';

            $language = new Language();
            $language->setTitle($languageName)
                    ->setLanguageCode($languageCode)
                    ->setLanguageLcid($code)
                    ->setFlagPath($flagPath);

            if ($code == $defaultLanguage) {
                $language->setIsDefault(true);
            }

            $manager->persist($language);
            $manager->flush();

            $languages[] = $language;
        }

        /*
         * Storing the languages in session
         */
        $this->getContainer()
                ->get('session')
                ->set('languagesData', $languages);

        /*
         * Setting the default language / locale, because without this translations
         * in the default locale set in translatable listener will be also added to database.
         */
        $this->getContainer()
                ->get('gedmo.listener.translatable')
                ->setDefaultLocale($defaultLanguage);

        /*
         * For the default language / locale translation should be also added.
         * Otherwise lately edited item will be returned for the default language / locale.
         */
        $this->getContainer()
                ->get('gedmo.listener.translatable')
                ->setPersistDefaultLocaleTranslation(true);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 1;
    }

}