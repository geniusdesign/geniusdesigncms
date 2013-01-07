<?php

namespace GeniusDesign\FrontendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use GeniusDesign\Components\SimpleUserBundle\Entity\SimpleUser;

/**
 * Loads default data for frontend simple users
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class SimpleUserData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

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
        $users = array(
            array(
                'first_name' => 'Jan',
                'last_name' => 'Kowalski',
                'email' => 'jan@genius.pl',
                'password' => 'jan',
                'note' => 'Notatka',
                'avatar' => '',
                'role' => 'ROLE_ADMIN',
            ),
            array(
                'first_name' => 'Adam',
                'last_name' => 'Tarkowski',
                'email' => 'adam@genius.pl',
                'password' => 'adam',
                'note' => 'Tekst',
                'avatar' => '',
                'role' => 'ROLE_CLIENT',
            )
        );

        $password_template = '%s(%s)';

        foreach ($users as $item) {
            $first_name = $item['first_name'];
            $last_name = $item['last_name'];
            $email = $item['email'];
            $password = $item['password'];
            $note = $item['note'];
            $avatar = $item['avatar'];
            $role = $item['role'];

            $user = new SimpleUser();
            $salt = $user->getSalt();

            $user->setFirstName($first_name)
                    ->setLastName($last_name)
                    ->setEmail($email)
                    ->setPassword(md5(sprintf($password_template, $password, $salt)))
                    ->setNote($note)
                    ->setAvatar($avatar);

            if ($this->hasReference($role)) {
                $roleObject = $this->getReference($role);
                $user->setRole($roleObject);
            }

            $manager->persist($user);
        }
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 30;
    }

}