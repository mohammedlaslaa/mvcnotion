<?php

namespace Core;


class App
{

    protected $controller = DEFAULT_CONTROLLER;
    protected $action = DEFAULT_METHOD;
    protected $params = [];

    protected $moduleName = DEFAULT_MODULE;

    protected $namespace;

    public function __construct()
    {
        //On traite l'url
        $this->parseUrl();
   
        $this->pushNamespace();

    }
 

    public function parseUrl()
    {
        $request_uri = str_replace(BASE_DIR, '', $_SERVER['REQUEST_URI']);

        return $this->url = explode('/', filter_var(rtrim($request_uri), FILTER_SANITIZE_STRING));
    }

    public function run()
    {

        $this->url[0] = !empty($this->url[0]) ? $this->url[0] : $this->controller;
         
  
        if (file_exists('../app/controllers/' . $this->moduleName . '/' . ucfirst($this->url[0]) . 'Controller.php')) {

            $this->controller = $this->namespace . ucfirst($this->url[0]) . 'Controller';
              
            array_shift($this->url);
        }else{
            $this->redirect404();
        }
      
        $this->action = !empty($this->url[0]) ? $this->url[0] . 'Action' : $this->action . 'Action';
            
        
        if (method_exists($this->controller, $this->action)) {


            array_shift($this->url);
            $this->params = $this->url ? array_values($this->url) : [];
            
            $dispatch = new $this->controller();

            call_user_func_array([$dispatch, $this->action], $this->params);


        } else {
            $this->redirect404();
        }
         
    }

    public function redirect404()
    {
        header('Location: ' . BASE_DIR . 'error/index');
    }

    private function pushNamespace()
    {

        if (in_array($this->url[0], TAB_MODULES)) {
            $this->namespace = 'App\Controllers\\' . ucfirst($this->url[0]) . '\\';
            $this->moduleName = $this->url[0];
            array_shift($this->url);
        } else {
            //Front car module par defaut
            $this->namespace = 'App\Controllers\Front\\';
        }
    }

}