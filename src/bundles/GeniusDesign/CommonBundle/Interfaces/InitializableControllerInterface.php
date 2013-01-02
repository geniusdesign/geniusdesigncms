<?php

namespace GeniusDesign\CommonBundle\Interfaces;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface for controllers that may / should be initialized.
 * Provides methods for initialization.
 */
interface InitializableControllerInterface {

    /**
     * Initializes the object / controller
     * 
     * @param ContainerInterface $container The container
     * @param Request $request The request
     * @return void
     */
    public function initialize(ContainerInterface $container, Request $request);
}