<?php

namespace GeniusDesign\Components\SimpleUserBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;
use GeniusDesign\Components\SimpleUserBundle\Entity\SimpleUser;

/**
 * Helper for the simple user
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class SimpleUserHelper {

    /**
     * The container
     * @var ContainerInterface
     */
    private $container = null;

    /**
     * Class constructor
     * 
     * @param ContainerInterface $container The container
     * @return void
     */
    public function __construct(ContainerInterface $container) {
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
     * Returns information if given hashed password is the hash of given password
     * 
     * @param string $password The password
     * @param string $hashedPassword The hashed of password
     * @return boolean
     */
    public function arePasswordsIdentical($password, $hashedPassword, $secretToken = '') {
        $hashed = md5(sprintf('%s(%s)', $password, $secretToken));
        return $hashed === $hashedPassword;
    }

    /**
     * Checks whether the logged user has a given role
     * 
     * @param string $roleCode
     * @param boolean $returnedIfUserEmpty
     * @return boolean 
     */
    public function isGranted($roleCode, $returnedIfUserEmpty = false) {
        $result = true;
        $session = $this->getContainer()->get('session');
        $user = null;

        if ($session->has('simple_user')) {
            if ($session->get('simple_user') instanceof SimpleUser) {
                $user = $session->get('simple_user');
            }
        }

        if (!($user instanceof SimpleUser)) {
            return (boolean) $returnedIfUserEmpty;
        }

        $userByRole = $this->getContainer()
                ->get('doctrine')
                ->getRepository('GeniusDesignComponentsSimpleUserBundle:SimpleUser')
                ->getUserByIdAndRole($user->getId(), $roleCode);

        if (empty($userByRole)) {
            $result = false;
        }

        return $result;
    }

}
