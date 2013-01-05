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
        $contents = array(
            array(
                'title' => 'Strona główna',
                'content' => 'Suspendisse ut leo vel nunc ullamcorper aliquet quis sit amet orci. Phasellus nulla dolor, tristique ac elementum blandit, aliquam a nunc. In dignissim vulputate mauris accumsan rhoncus.'
            ),
            array(
                'title' => 'O firmie',
                'content' => 'Integer pellentesque ante ac libero condimentum condimentum. Fusce pellentesque pellentesque tellus, vel congue dolor fermentum vel. Vivamus facilisis egestas libero sed sollicitudin. In eleifend felis quis nulla ornare condimentum. Suspendisse in magna et metus ultrices eleifend. Nam accumsan viverra tortor, et ornare ligula consectetur sed. Phasellus rutrum placerat ipsum, id tincidunt nibh tincidunt sed. Nullam aliquet nibh id orci convallis tempus molestie lectus euismod. Nullam placerat ante nec ante convallis dapibus.'
            ),
            array(
                'title' => 'Oferta',
                'content' => 'Sed tincidunt arcu non lorem dapibus nec ornare enim posuere. Vivamus lectus odio, sodales eu gravida et, lobortis porttitor augue. Sed aliquam venenatis turpis at porta. In elementum neque et dolor malesuada placerat. '
            ),
            array(
                'title' => 'Kontakt',
                'content' => 'Donec ac nunc mauris, nec bibendum turpis. Mauris pharetra dictum tellus, at lacinia sapien rhoncus tincidunt.'
            ),
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

        $languages = $this->getContainer()
                ->get('session')
                ->get('languagesData');

        $languagesDefined = $this->getContainer()
                ->get('genius_design_language.helper')
                ->areLanguagesDefined();

        foreach ($contents as $item) {
            $title = $item['title'];
            $content = $item['content'];

            $contentObject = new Content();
            $contentObject->setTitle($title)
                    ->setOriginalTitle($title)
                    ->setContent($content)
                    ->setAutor('Jan Kowalski');

            $manager->persist($contentObject);
            $manager->flush();

            if (!empty($languages) && $languagesDefined) {
                foreach ($languages as $language) {
                    $title = $item['title'];
                    $content = $item['content'];
                    
                    $languageLcid = $language->getLanguageLcid();
                    $languageCode = $language->getLanguageCode();

                    if (isset($translations[$title][$languageCode])) {
                        $title = $translations[$title][$languageCode];
                    } else {
                        $title = sprintf('%s - %s', $title, $languageCode);
                    }

                    $contentObject->setTranslatableLocale($languageLcid)
                            ->setTitle($title)
                            ->setContent(sprintf('%s - %s', $content, $languageCode));

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