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
    protected $router;

    /**
     *
     * @var MyTeamTree\Validation\Validator
     */
    protected $validator;
    protected $csrf;

    /**
     *
     * @var \MyTeamTree\Auth\Authentication
     */
    protected $auth;

    /**
     *
     * @var \Illuminate\Database\Capsule\Manager
     */
    protected $db;

    /**
     *
     * @var \Slim\Flash\Messages
     */
    protected $flash;
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
        $this->db        = $container->get('db');
        $this->router    = $container->get('router');
        $this->validator = $container->get('validator');
//        $this->csrf      = $container->get('csrf');
        $this->auth      = $container->get('auth');
        $this->flash     = $container->get('flash');
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
    public function renderPage($response, $templatePath, $args)
    {
        $this->render($response, $this->headerTemplate, $args);
        $this->render($response, $templatePath, $args);
        $this->render($response, $this->footerTemplate, $args);

        //return $header . $page . $footer;
    }

    protected function makeCsrfAvailable($request)
    {

        $csrf = $this->container->csrf;

        $csrfFields = '<input type="hidden" name="%s" value="%s">'
            .'<input type="hidden" name="%s" value="%s">';

        $environment = $this->container->view->getEnvironment();
        $environment->addGlobal('csrf',
            [
            'fields' => sprintf($csrfFields, $csrf->getTokenNameKey(),
                $request->getAttribute($csrf->getTokenNameKey()),
                $csrf->getTokenValueKey(),
                $request->getAttribute($csrf->getTokenValueKey()))
            ]
        );
    }

    /**
     * Checks if user is authenticated. If not, returns the redirect. Otherwise returns false;
     * 
     * @param type $response
     * @return boolean/Response
     */
    protected function forceAuthenticationRedirect($response)
    {
        if (!$this->auth->isAuthenticated()) {
            $this->flash->addMessage('error',
                "You must be authenticated to see this page, please do login.");
            return $response->withRedirect($this->router->pathFor('login'));
        } else {
            return false;
        }
    }
}