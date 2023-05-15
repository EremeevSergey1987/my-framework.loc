<?php
namespace app\controllers\admin;
use app\models\Main;
use app\models\User;
use wfm\Controller;

/**
 * @property Main $model
 */
class MainController extends Controller
{
    public function indexAction()
    {
        if(User::checkAuthRole()){$this->redirect('/file');}

        $names = $this->model->get_names();
        $this->setMeta('Admin', 'Admin', 'Admin');
        $this->set(compact('names'));

    }
}