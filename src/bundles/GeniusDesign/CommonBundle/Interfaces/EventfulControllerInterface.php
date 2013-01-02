<?php

namespace GeniusDesign\CommonBundle\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface for controllers that may / should handle some events.
 * Provides methods executed while executing current action.
 */
interface EventfulControllerInterface {

    /**
     * Performs some kind of functionality pre execution of the current action
     * 
     * @param Request $request The request
     * @return void
     */
    public function preExecute(Request $request);

    /**
     * Performs some kind of functionality post execution of the current action
     * 
     * @param Request $request The request
     * @param Response $response The response
     * @return void
     */
    public function postExecute(Request $request, Response $response);
}