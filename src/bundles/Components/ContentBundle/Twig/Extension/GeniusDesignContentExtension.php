<?php

namespace GeniusDesign\Components\ContentBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Twig extension for the contents
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class GeniusDesignContentExtension extends \Twig_Extension {

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
            'genius_design_content' => new \Twig_Function_Method($this, 'getContent', array('is_safe' => array('html')))
        );
    }

    /**
     * Returns the name of the extension
     * @return string
     */
    public function getName() {
        return 'genius_design_content';
    }

    /**
     * Renders the content for given title's slug
     * 
     * @param string $contentSlug Slug of content's title
     * @return string
     */
    public function getContent($contentSlug) {
        $manager = $this->getContainer()
                ->get('doctrine')
                ->getEntityManager();

        $language = 'pl';

        $content = $manager->getRepository('GeniusDesignComponentsContentBundle:Content')
                ->getContentBySlug($contentSlug, $language);

        if ($content !== null) {
            $parameters = array(
                'title' => $content->getTitle(),
                'content' => $content->getContent()
            );

            return $this->getContainer()
                            ->get('templating')
                            ->render('GeniusDesignComponentsContentBundle:Content:display.html.twig', $parameters);
        }

        return '';
    }
}