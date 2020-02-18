<?php 

namespace App\Controllers\Front;

use App\Controllers\Front\AppController;

class PostController extends AppController{


    public function indexAction()
    {
        
            $tabPosts = ['name' => 'Mohammed', 'city' => "Noyelles-Godault"];
            $this->render('posts.index', $tabPosts);
    }

    public function categoriesAction()
    {
        
    }

}