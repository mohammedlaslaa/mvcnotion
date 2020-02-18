<?php

namespace App\Controllers\Front;


use App\Controllers\Front\AppController;
use App\Models\User;

class IndexController extends AppController
{



    public function __construct()
    {


        parent::__construct();
    }

    public function indexdAction()
    {

        //Ici pour vous montrer je surcharge le title qui se trouve dans 
        // le constructeur parent
        $element['title'] = 'changement';
        $this->addContentToView($element);

        //Dans un tableau la variable "name" qui se trouve
        // dans la vue index de mon module "front"
        $tableauPourLaVue = ['name' => 'Mohammed', 'city' => "Noyelles-Godault"];

        $this->render('index.index', $tableauPourLaVue);
    }

    public function userAction($id)
    {
        $user = new User();
        $user->setId($id);
        $result = $user->select();
        $tableau = ['name' => $result[0]['name'], 'firstname' => $result[0]['firstname']];
        $this->render('index.index', $tableau);
    }

    public function alluserAction()
    {
        $user = new User();
        $result = $user->selectAll();
        $tableau = [];
        foreach ($result as $key => $value) {
            if ($key == 'name' || $key == 'firstname') {
                $tableau['name'] = $value;
            }
        }
        var_dump($tableau);
        $tableau = ['name' => $result[0]['name'], 'firstname' => $result[0]['firstname']];
        $this->render('index.index', $tableau);
    }

    /**
     * Juste une methode pour tester
     * d'afficher la liste des utilisateur sur l'accueil
     */
    public function userlistAction()
    {
        echo 'test';
    }
}
