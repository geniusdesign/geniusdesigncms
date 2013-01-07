<?php

namespace GeniusDesign\FrontendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use GeniusDesign\Components\SimpleUserBundle\Entity\Role;

/**
 * Loads default data for frontend roles
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class RoleData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

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


        $roles = array(
            array(
                'name' => 'Admin',
                'code' => 'ROLE_ADMIN',
                'parent' => ''
            ),
            array(
                'name' => 'Klient',
                'code' => 'ROLE_CLIENT',
                'parent' => 'ROLE_ADMIN'
            )
        );

        $translations = array(
            'Admin' => array(
                'pl' => 'Admin',
                'en' => 'Admin en',
                'de' => 'Admin de',
                'ru' => 'Admin ru'
            ),
            'Klient' => array(
                'pl' => 'Klient',
                'en' => 'Klient en',
                'de' => 'Klient de',
                'ru' => 'Klient ru'
            )
        );

        $rolesFlushes = array();

        foreach ($roles as $item) {
            $name = $item['name'];
            $code = $item['code'];
            $parent = $item['parent'];

            $role = new Role();
            $role->setName($name)
                    ->setOriginalName($name)
                    ->setCodeName($code);

            if (isset($rolesFlushes[$parent])) {
                $existParent = $rolesFlushes[$parent];
                $role->setParent($existParent);
            }

            $manager->persist($role);
            $manager->flush();

            $rolesFlushes[$code] = $role;
            $this->addReference($code, $role);

            if (!empty($languages) && $languagesDefined) {
                foreach ($languages as $language) {
                    $name = $item['name'];

                    $languageLcid = $language->getLanguageLcid();
                    $languageCode = $language->getLanguageCode();

                    if (isset($translations[$name][$languageCode])) {
                        $name = $translations[$name][$languageCode];
                    } else {
                        $name = $name . ' - ' . $languageCode;
                    }

                    $role->setTranslatableLocale($languageLcid)
                            ->setName($name);

                    $manager->persist($role);
                    $manager->flush();
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 25;
    }

}