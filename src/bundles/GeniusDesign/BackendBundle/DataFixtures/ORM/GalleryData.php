<?php

namespace GeniusDesign\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GeniusDesign\Components\GalleryBundle\Entity\Gallery;
use GeniusDesign\Components\GalleryBundle\Entity\Image;

/**
 * Loads default data for gallery
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class GalleryData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

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
        $refererGallery = null;
        
        $galleries = array(
            array(
                'title' => 'Galeria 1',
                'description' => 'Suspendisse ut leo vel nunc ullamcorper aliquet quis sit amet orci. Phasellus nulla dolor, tristique ac elementum blandit, aliquam a nunc. In dignissim vulputate mauris accumsan rhoncus.'
            ),
            array(
                'title' => 'Galeria 2',
                'description' => 'Integer pellentesque ante ac libero condimentum condimentum. Fusce pellentesque pellentesque tellus, vel congue dolor fermentum vel. Vivamus facilisis egestas libero sed sollicitudin. In eleifend felis quis nulla ornare condimentum. Suspendisse in magna et metus ultrices eleifend. Nam accumsan viverra tortor, et ornare ligula consectetur sed. Phasellus rutrum placerat ipsum, id tincidunt nibh tincidunt sed. Nullam aliquet nibh id orci convallis tempus molestie lectus euismod. Nullam placerat ante nec ante convallis dapibus.'
            )
        );
        
        $images = array(
            array(
                'title' => 'Obrazek 1',
                'autor' => 'Jan Kowalski',
                'imageName' => 'example1.jpg'
            ),
            array(
                'title' => 'Obrazek 2',
                'autor' => 'Jan Nowak',
                'imageName' => 'example2.jpg'
            )
        );

        $translations = array(
            'Galeria 1' => array(
                'pl' => 'Galeria 1',
                'en' => 'Galeria 1 en',
                'de' => 'Galeria 1 de',
                'ru' => 'Galeria 1 ru'
            ),
            'Galeria 2' => array(
                'pl' => 'Galeria 2',
                'en' => 'Galeria 2 en',
                'de' => 'Galeria 2 de',
                'ru' => 'Galeria 2 ru'
            ),
            'Obrazek 1' => array(
                'pl' => 'Obrazek 1',
                'en' => 'Obrazek 1 en',
                'de' => 'Obrazek 1 de',
                'ru' => 'Obrazek 1 ru'
            ),
            'Obrazek 2' => array(
                'pl' => 'Obrazek 2',
                'en' => 'Obrazek 2 en',
                'de' => 'Obrazek 2 de',
                'ru' => 'Obrazek 2 ru'
            )
        );

        $languages = $this->getContainer()
                ->get('session')
                ->get('languagesData');

        $languagesDefined = $this->getContainer()
                ->get('genius_design_language.helper')
                ->areLanguagesDefined();

        foreach ($galleries as $item) {
            $title = $item['title'];
            $description = $item['description'];

            $gallery = new Gallery();
            $gallery->setTitle($title)
                    ->setOriginalTitle($title)
                    ->setDescription($description);

            $manager->persist($gallery);
            $manager->flush();

            if (empty($refererGallery)) {
                $refererGallery = $gallery;
            }

            if (!empty($languages) && $languagesDefined) {
                foreach ($languages as $language) {
                    $title = $item['title'];
                    $description = $item['description'];

                    $languageLcid = $language->getLanguageLcid();
                    $languageCode = $language->getLanguageCode();

                    if (isset($translations[$title][$languageCode])) {
                        $title = $translations[$title][$languageCode];
                    } else {
                        $title = sprintf('%s - %s', $title, $languageCode);
                    }

                    $gallery->setTranslatableLocale($languageLcid)
                            ->setTitle($title)
                            ->setDescription(sprintf('%s - %s', $description, $languageCode));

                    $manager->persist($gallery);
                    $manager->flush();
                }
            }
        }
        
        foreach ($images as $item) {
            $title = $item['title'];
            $autor = $item['autor'];
            $imageName = $item['imageName'];

            $image = new Image();
            $image->setTitle($title)
                    ->setAutor($autor)
                    ->setImageFileName($imageName)
                    ->setGallery($refererGallery);

            $manager->persist($image);
            $manager->flush();

            if (!empty($languages) && $languagesDefined) {
                foreach ($languages as $language) {
                    $title = $item['title'];
                    $languageLcid = $language->getLanguageLcid();
                    $languageCode = $language->getLanguageCode();

                    if (isset($translations[$title][$languageCode])) {
                        $title = $translations[$title][$languageCode];
                    } else {
                        $title = sprintf('%s - %s', $title, $languageCode);
                    }

                    $image->setTranslatableLocale($languageLcid)
                            ->setTitle($title);

                    $manager->persist($image);
                    $manager->flush();
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 20;
    }

}