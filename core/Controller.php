<?php

namespace Core;

class Controller
{

    protected $viewPath;

    protected $template = 'default';

    protected $varsView = [];

    public function __construct()
    {

    }


    /**
     * Envoi de la vue
     * @param $view
     * @param array $tab
     */
    protected function render($view, $tab = [])
    {

        extract($this->varsView);
        extract($tab);

        ob_start();

        require_once $this->viewPath . '/' . str_replace('.', '/', $view) . '.php';
        $content = ob_get_clean();

        require_once $this->viewPath . '/' . $this->template . '.php';
    }

    public function renderView($view, $tab = [])
    {
        extract($tab);
        ob_start();
        require_once $this->viewPath . '/' . str_replace('.', '/', $view) . '.php';
        return ob_get_clean();
    }

    protected function notFound()
    {
        header('HTTP/1.0 404 Not Found');
        die('page introuvable');
    }

    protected function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');
        die('Acces interdit');
    }

    function redirect($url, $code = null)
    {
        if ($code == 301) {
            header("HTTP/1.1 301 Moved Permanently");
        }
        header("Location: " . $url);
    }

    public function addContentToView($element)
    {
        $this->varsView = array_merge($this->varsView, $element);
    }

}