<?php 


namespace App\Controllers\Admin;

use App\Controllers\Admin\AppController;

class IndexController extends AppController{

    public function indexAction($name)
    {
        $tabPosts = ['name' => 'undeundeu'];
        
        $this->render('index.index', $tabPosts);
    }

    public function testparamsAction($name)
    {
         
       echo '<h1>' . $name . '<h1>';
         
    }
}