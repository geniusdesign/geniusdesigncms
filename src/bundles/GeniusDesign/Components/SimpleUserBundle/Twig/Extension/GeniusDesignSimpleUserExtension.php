<?php

namespace GeniusDesign\Components\SimpleUserBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use GeniusDesign\Components\SimpleUserBundle\Form\SimpleUserLoginType;
use GeniusDesign\Components\SimpleUserBundle\Entity\SimpleUser;

/**
 * Twig extension for the simple user
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class GeniusDesignSimpleUserExtension extends \Twig_Extension {

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
     * Returns a list of functions to add to the existing list
     * @return array
     */
    public function getFunctions() {
        return array(
            'genius_design_simple_user_login' => new \Twig_Function_Method($this, 'getSimpleUserLogin', array('is_safe' => array('html'))),
            'genius_design_user_is_granted' => new \Twig_Function_Method($this, 'isSimpleUserGranted')
        );
    }

    /**
     * Returns the name of the extension
     * @return string
     */
    public function getName() {
        return 'genius_design_simple_user';
    }

    /**
     * Renders the login form for simple user
     * 
     * @return string
     */
    public function getSimpleUserLogin() {
        $user = null;
        $request = $this->getContainer()->get('request');
        $session = $this->getContainer()->get('session');

        $formFactory = $this->getContainer()->get('form.factory');
        $form = $formFactory->create(new SimpleUserLoginType());

        $logged = false;

        if ($session->get('simple_user') != null) {
            $logged = true;
            $user = $session->get('simple_user');
        }

        if (strtolower($request->getMethod()) == 'post') {
            $form->bindRequest($request);
        }

        $parameters = array(
            'form' => $form->createView(),
            'logged' => $logged,
            'user' => $user
        );

        return $this->getContainer()
                        ->get('templating')
                        ->render('GeniusDesignComponentsSimpleUserBundle:Form:login-form.html.twig', $parameters);
    }
    
    /**
     * Return information if user is granted by role
     * 
     * @param string $roleCode
     * @param boolean $returnedIfUserEmpty
     * @return boolean 
     */
    public function isSimpleUserGranted($roleCode, $returnedIfUserEmpty = false){
        $userHelper = $this->getContainer()->get('genius_design_simple_user.helper');
        return $userHelper->isGranted($roleCode, $returnedIfUserEmpty);
    }

}