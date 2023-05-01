<?php

namespace app\controllers;

use wfm\Controller;

class FileController extends Controller
{
    public function indexAction()
    {
        $this->setMeta('Files', 'Files', 'Files');
    }

}