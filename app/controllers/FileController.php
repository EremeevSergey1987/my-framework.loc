<?php

namespace app\controllers;

use RedBeanPHP\R;
use wfm\Controller;
use app\models\File;

/**
 * @property File $model
 */
class FileController extends Controller
{
    public function indexAction()
    {
        $user_id = $_SESSION['user']['id'];
        $files_one_user = R::getAll( "SELECT * FROM files WHERE main_user = {$user_id}" );
        $this->setMeta('Files', 'Files', 'Files');
        $this->set(compact('files_one_user'));
    }

    public function addAction()
    {
        $this->model->save('files');
    }


    public function loginAction()
    {
        $this->setMeta('Files', 'Files', 'Files');
    }

}