<?php

namespace MyTeamTree\Controller;

/**
 * Abstract Class that every controller must inherit
 *
 * @author vinicius
 */
abstract class DefaultController
{
    protected $container;
    protected $view;
    /**
     *
     * @var type \Illuminate\Database\Capsule\Manager
     */
    protected $db;
    private $headerTemplate = 'app/header.twig';
    private $footerTemplate = 'app/footer.twig';

    /**
     * Constructor
     * @param \Slim\Container $container
     */
    public function __construct(\Slim\Container $container)
    {
        $this->container = $container;
        $this->view      = $this->container->get("view");
        $this->db = $container->get('db');
    }

    /**
     * Returns a rendered template
     * 
     * @param type $response
     * @param type $templatePath
     * @param type $args
     * @return type
     */
    public function render($response, $templatePath, $args)
    {
        $this->view->render($response, $templatePath, $args);
    }

    /**
     * Renders a template with header and footer
     * 
     * @param type $response
     * @param type $templatePath
     * @param type $args
     * @return type
     */
    public function renderPage($response, $templatePath, $args){
        $this->render($response, $this->headerTemplate, $args);
        $this->render($response, $templatePath, $args);
        $this->render($response, $this->footerTemplate, $args);

        //return $header . $page . $footer;
    }
}