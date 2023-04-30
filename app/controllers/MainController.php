<?php

namespace app\controllers;

use wfm\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $names = ['qweqwe', 'qweqwe', 'qweqwe',];
        $this->setMeta('Main page', 'Description', 'keywords');
        //$this->set(['test' => 'Cat', 'name' => 'Sergey']);
        //$this->set(['names'=> $name]);
        $this->set(compact('names'));

    }

}