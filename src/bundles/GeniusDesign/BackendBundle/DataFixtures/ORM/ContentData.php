<?php

namespace GeniusDesign\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GeniusDesign\Components\ContentBundle\Entity\Content;

/**
 * Loads default data for content
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class ContentData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

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
        $maxContentCount = 3;

        $languages = $this->getContainer()
                ->get('session')
                ->get('languagesData');

        $languagesDefined = $this->getContainer()
                ->get('genius_design_language.helper')
                ->areLanguagesDefined();

        $titleTemplate = 'Content-%s';
        $contentTemplate = 'Treść - %s';

        for ($i = 1; $i <= $maxContentCount; $i++) {
            $title = sprintf($titleTemplate, $i);
            $titleLowered = mb_strtolower($title, 'UTF-8');
            $content = sprintf($contentTemplate, $titleLowered);

            $contentObject = new Content();
            $contentObject->setTitle($title)
                    ->setContent($content)
                    ->setAutor('nobody noname');

            $manager->persist($contentObject);
            $manager->flush();

            if (!empty($languages) && $languagesDefined) {
                foreach ($languages as $language) {
                    $languageLcid = $language->getLanguageLcid();
                    $languageCode = $language->getLanguageCode();

                    $contentObject->setTitle($title . ' - ' . $languageCode)
                            ->setContent($content . ' - ' . $languageCode)
                            ->setAutor($content . ' - ' . $languageCode)
                            ->setTranslatableLocale($languageLcid);

                    $manager->persist($contentObject);
                    $manager->flush();
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 15;
    }

}