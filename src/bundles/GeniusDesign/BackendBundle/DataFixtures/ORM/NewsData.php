<?php

namespace GeniusDesign\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GeniusDesign\Components\NewsBundle\Entity\News;

/**
 * Loads default data for news
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class NewsData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

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
        $maxNewsCount = 4;

        $languages = $this->getContainer()
                ->get('session')
                ->get('languagesData');

        $languagesDefined = $this->getContainer()
                ->get('genius_design_language.helper')
                ->areLanguagesDefined();

        $today = new \DateTime();

        $titleTemplate = 'Aktualność nr %d';
        $autor = 'Jan Kowalski';
        $entranceTemplate = 'Wstęp - %s';
        $contentTemplate = 'Treść - %s';

        for ($i = 1; $i <= $maxNewsCount; $i++) {
            $title = sprintf($titleTemplate, $i);
            $titleLowered = mb_strtolower($title, 'UTF-8');
            $entrance = sprintf($entranceTemplate, $titleLowered);
            $content = sprintf($contentTemplate, $titleLowered);
            $displayedDate = $today;

            $news = new News();
            $news->setTitle($title)
                    ->setOriginalTitle($title)
                    ->setEntrance($entrance)
                    ->setContent($content)
                    ->setImageFileName(null)
                    ->setAutor($autor)
                    ->setDisplayedDate($displayedDate)
                    ->setPublished(true);

            $manager->persist($news);
            $manager->flush();

            if (!empty($languages) && $languagesDefined) {
                foreach ($languages as $language) {
                    $languageLcid = $language->getLanguageLcid();
                    $languageTitle = $language->getTitle();

                    $news->setTranslatableLocale($languageLcid)
                            ->setTitle($title . ' - ' . $languageTitle)
                            ->setEntrance($entrance . ' - ' . $languageTitle)
                            ->setContent($content . ' - ' . $languageTitle);

                    $manager->persist($news);
                    $manager->flush();
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 10;
    }

}