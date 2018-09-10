<?php

namespace Bruchmann\Examples\Cars1\View;

/**
 * Very simple wrapper class for external template engine as programming-example.
 * Template engine is only used for content area.
 * Any usage is not intended serving practical intentions.
 *
 * @author         David Bruchmann <david.bruchmann@gmail.com>
 * @copyright 2018 David Bruchmann <david.bruchmann@gmail.com>
 */
class View
{
    /**
     * @var string
     */
    protected $templatePath = '';

    /**
     * @var array
     */
    protected $variables = array();

    /**
     * @var string
     */
    protected $pageTitle = 'Cars';

    /**
     * @var string
     */
    protected $pageTemplate = 'PageTemplate.html';

    /**
     * @var string
     */
    protected $basePath = '';

    /**
     * @var object
     */
    protected $templateEngine = null;

    /**
     * @param string  path to templates
     * @param string  class-name of templateEngine
     */
    public function __construct(
        $templatePath,
        $templateEngineObjet='Smarty'
    ){
        if ($templatePath && is_dir($templatePath)) {
            $this->templatePath = $templatePath;
        } else {
            throw new \InvalidArgumentException('templatePath must be a valid path.');
        }
        $this->templateEngine = new $templateEngineObjet;
        $this->templateEngine->debugging = true;
    }

    /**
     * @param string   variable for array-key
     * @param mixed    variable-value can be of any type
     */
    public function assign($variable, $mixedValue)
    {
        $this->variables[$variable] = $mixedValue;
    }

    /**
     * @param string   filename of $template
     */
    public function render($template)
    {
        $page = $this->renderPage();
        $content = $this->renderContent($template);
        $page = str_replace('###CONTENT###', $content, $page);
        echo $page;
    }

    /**
     * Renders HTML skeleton for whole page.
     * Has to include content-marker "###CONTENT###".
     * @see View::render($template) above
     *
     * @TODO: options for header (CSS, JS, meta)
     *
     * @return string  HTML skeleton for whole page
     */
    public function renderPage()
    {
        $pageTemplate = $this->pageTemplate;
        $page = file_get_contents($this->templatePath.$pageTemplate);
        $page = str_replace('###TITLE###', $this->pageTitle, $page);
        return $page;
    }

    /**
     * @param string   filename of $template
     *
     * @return string  page content as HTML
     */
    public function renderContent($template)
    {
        foreach($this->variables as $key => $variable) {
            $this->templateEngine->assign($key, $variable);
        }
        return $this->templateEngine->fetch($this->templatePath.$template);
    }

    /**
     * @param string   $basePath to this framework
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }
}
