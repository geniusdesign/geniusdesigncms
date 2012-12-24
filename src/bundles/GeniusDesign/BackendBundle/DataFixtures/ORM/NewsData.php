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
        $languages = array(
            'pl', 'en'
        );
        
        $today = new \DateTime();

        $titleTemplate = 'Aktualność nr %d';
        $entranceTemplate = 'Wstęp - %s';
        $contentTemplate = 'Treść - %s';

        foreach ($languages as $language){
            for ($i = 1; $i <= $maxNewsCount; $i++) {
                $title = sprintf($titleTemplate, $i);
                $titleLowered = mb_strtolower($title, 'UTF-8');
                $entrance = sprintf($entranceTemplate, $titleLowered);
                $content = sprintf($contentTemplate, $titleLowered);
                $displayedDate = $today;

                $news = new News();
                $news->setTitle($title)
                        ->setEntrance($entrance)
                        ->setContent($content)
                        ->setImageFileName(null)
                        ->setDisplayedDate($displayedDate)
                        ->setLanguage($language);

                $manager->persist($news);
                $manager->flush();
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 1;
    }

}