<?php

namespace app\controllers;

use RedBeanPHP\R;
use wfm\Controller;

class FileController extends Controller
{
    public function indexAction()
    {
        $names = $this->model->get_names();
        $one_name = R::getRow( 'SELECT * FROM users WHERE id = 2');
        $this->setMeta('Files', 'Files', 'Files');
        $this->set(compact('names'));
    }

}