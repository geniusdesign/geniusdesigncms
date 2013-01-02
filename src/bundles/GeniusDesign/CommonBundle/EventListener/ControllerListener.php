<?php

namespace GeniusDesign\CommonBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use GeniusDesign\CommonBundle\Interfaces\InitializableControllerInterface;
use GeniusDesign\CommonBundle\Interfaces\EventfulControllerInterface;

/**
 * Listener for controllers.
 * 
 * Provides methods that serves "kernel.controller" and "kernel.response" events, thus pre
 * and post given action of given controller special methods are executed.
 */
class ControllerListener {

    /**
     * The container
     * @var ContainerInterface
     */
    private $container = null;

    /**
     * The controller
     * @var 
     */
    private $controller;

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
     * Serves the "kernel.controller" event
     * 
     * @param FilterControllerEvent $event The event
     * @return void
     */
    public function onKernelController(FilterControllerEvent $event) {
        $controller = $event->getController();

        if (is_array($controller) && isset($controller[0])) {
            $controller = $controller[0];

            if (is_object($controller)) {
                $this->controller = $controller;

                $request = $event->getRequest();
                $container = $this->getContainer();

                if ($this->controller instanceof InitializableControllerInterface) {
                    $this->controller->initialize($container, $request);
                }

                if ($this->controller instanceof EventfulControllerInterface) {
                    $controller = $this->controller->preExecute($request);

                    if (!empty($controller) && is_array($controller) && count($controller) == 2) {
                        $event->setController($controller);
                    }
                }
            }
        }
    }

    /**
     * Serves the "kernel.response" event
     * 
     * @param FilterResponseEvent $event The event
     * @return void
     */
    public function onKernelResponse(FilterResponseEvent $event) {
        if (is_object($this->controller) && $this->controller instanceof EventfulControllerInterface) {
            $request = $event->getRequest();
            $response = $event->getResponse();

            $this->controller->postExecute($request, $response);
        }
    }

}