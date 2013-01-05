<?php

namespace GeniusDesign\FrontendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GeniusDesign\FrontendBundle\Entity\MenuItem;

/**
 * Loads default data for frontend menu item
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class MenuItemData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

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
        $languages = $this->getContainer()
                ->get('session')
                ->get('languagesData');

        $languagesDefined = $this->getContainer()
                ->get('genius_design_language.helper')
                ->areLanguagesDefined();

        $menuItems = array(
            array('name' => 'Strona główna', 'viewname' => 'homepage', 'default' => true),
            array('name' => 'O firmie', 'viewname' => 'aboutus'),
            array('name' => 'Aktualności', 'viewname' => ''),
            array('name' => 'Galeria', 'viewname' => ''),
            array('name' => 'Oferta', 'viewname' => 'offer'),
            array('name' => 'Kontakt', 'viewname' => 'contact')
        );

        $translations = array(
            'Strona główna' => array(
                'pl' => 'Strona główna',
                'en' => 'Homepage en',
                'de' => 'Homepage de',
                'ru' => 'Homepage ru'
            ),
            'O firmie' => array(
                'pl' => 'O firmie',
                'en' => 'About us en',
                'de' => 'About us de',
                'ru' => 'About us ru'
            ),
            'Aktualności' => array(
                'pl' => 'Aktualności',
                'en' => 'News en',
                'de' => 'News de',
                'ru' => 'News ru'
            ),
            'Galeria' => array(
                'pl' => 'Galeria',
                'en' => 'Gallery en',
                'de' => 'Gallery de',
                'ru' => 'Gallery ru'
            ),
            'Oferta' => array(
                'pl' => 'Oferta',
                'en' => 'Offer en',
                'de' => 'Offer de',
                'ru' => 'Offer ru'
            ),
            'Kontakt' => array(
                'pl' => 'Kontakt',
                'en' => 'Contact en',
                'de' => 'Contact de',
                'ru' => 'Contact ru'
            )
        );

        foreach ($menuItems as $item) {
            $titleName = $item['name'];
            $isDefault = false;
            
            if(isset($item['default']) && $item['default'] == true){
                $isDefault = true;
            }

            $menuItem = new MenuItem();
            $menuItem->setTitle($titleName)
                    ->setOriginalTitle($titleName)
                    ->setViewname($item['viewname'])
                    ->setIsDefault($isDefault);

            $manager->persist($menuItem);
            $manager->flush();

            if (!empty($languages) && $languagesDefined) {
                foreach ($languages as $language) {
                    $titleName = $item['name'];
                    
                    $languageLcid = $language->getLanguageLcid();
                    $languageCode = $language->getLanguageCode();

                    if (isset($translations[$titleName][$languageCode])) {
                        $titleName = $translations[$titleName][$languageCode];
                    } else {
                        $titleName = $titleName . ' - ' . $languageCode;
                    }

                    $menuItem->setTranslatableLocale($languageLcid)
                            ->setTitle($titleName);

                    $manager->persist($menuItem);
                    $manager->flush();
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 2;
    }

}