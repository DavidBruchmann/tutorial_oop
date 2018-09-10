<?php

namespace Bruchmann\Examples\Cars1\Controller;

class CarController
{
    /**
     * @var object
     */
    protected $carRepository = null;

    /**
     * @var \Bruchmann\Examples\Cars1\View\View
     */
    protected $view = null;

    /**
     * @var string
     */
    protected $basePath = '';

    /**
     * @var string
     */
    protected $baseUrl = '';

    /**
     * @var string
     */
    protected $templateEngine = '';

    /**
     * constructor
     * - to initialize repository and view
     * - to dispatch the required action
     *
     * @param string   [list | show]
     * @param string   basePath to this framework
     * @param array    configuration for repository
     * @param string   [arrayBased | objectBased]
     *
     * @return void
     */
    public function __construct($basePath, $baseUrl, $repositoryConfiguration, $templateEngine)
    {
        $this->basePath = $basePath;
        $this->baseUrl = $baseUrl;
        $this->initRepository($repositoryConfiguration);
        $this->templateEngine = $templateEngine;
        $this->initView();
        $this->dispatch();
    }

    /**
     * @param array    configuration for repository
     *
     * @return void
     */
    protected function initRepository($repositoryConfiguration)
    {
        switch ($repositoryConfiguration['type']) {
            case 'csv':
                $this->carRepository = new \Bruchmann\Examples\Cars1\Domain\Repository\CSV\CarRepository($repositoryConfiguration['file']);
                $this->carRepository->setBasePath($this->basePath);
            break;
        }
    }

    /**
     * @return void
     */
    protected function initView()
    {
        $this->view = new \Bruchmann\Examples\Cars1\View\View($this->basePath.'/Resources/Private/Templates/');
        $this->view->setBasePath($this->basePath);
    }

    /**
     * @return void
     */
    protected function dispatch()
    {
        $arguments = $_GET;
        $action = isset($arguments['action']) ? $arguments['action'] : 'list';
        if ($action == 'show' && isset($_GET['car'])) {
            $this->{$action . 'Action'}(intval($_GET['car']));
        } else {
            $this->{$action . 'Action'}();
        }
    }

    /**
     * @return void
     */
    protected function listAction()
    {
        $carObjects = $this->carRepository->findAll();
        if ($this->templateEngine=='arrayBased') {
            $cars = array();
            foreach ($carObjects as $count => $carObject) {
                $cars[$count] = $carObject->toArray();
            }
            $this->view->assign('cars', $cars);
        } else {
            $this->view->assign('cars', $carObjects);
        }
        $this->view->assign('baseUrl', $this->baseUrl);
        $this->view->render('List.html');
    }

    /**
     * @param int   carUid
     *
     * @return void
     */
    protected function showAction(int $carUid)
    {
        $carObj = $this->carRepository->findByUid($carUid);
        if(is_object($carObj)) {
            $car = $this->templateEngine=='arrayBased' ? $carObj->toArray() : $carObj;
            $prev = $this->templateEngine=='arrayBased' ? (is_object($this->carRepository->prev()) ? $this->carRepository->prev()->toArray() : null) : $this->carRepository->prev();
            $next = $this->templateEngine=='arrayBased' ? (is_object($this->carRepository->next()) ? $this->carRepository->next()->toArray() : null) : $this->carRepository->next();
        } else {
            $car = null;
            $prev = null;
            $next = null;
            $this->view->assign('requestUid', $carUid);
        }
        $this->view->assign('car', $car);
        $this->view->assign('prev', $prev);
        $this->view->assign('next', $next);
        $this->view->assign('baseUrl', $this->baseUrl);
        $this->view->render('Show.html');
    }
}
