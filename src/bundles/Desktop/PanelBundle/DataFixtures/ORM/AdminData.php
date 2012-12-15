<?php

namespace GeniusDesign\Desktop\PanelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use GeniusDesign\Desktop\PanelBundle\Entity\Admin;

/**
 * Loads default data for configuration
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class AdminData implements FixtureInterface, OrderedFixtureInterface {

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param Doctrine\Common\Persistence\ObjectManager $manager
     * @return void
     */
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager) {
        $admin = new Admin();
        $admin->setFirstName('Administrator')
                ->setLastName('Serwisu')
                ->setEmail('pawel@genius.design.pl')
                ->setPassword(md5('genius@design!'))
                ->setEnabled(true);

        $manager->persist($admin);
        $manager->flush();
    }

    /**
     * Order
     */
    public function getOrder() {
        return 1;
    }
}