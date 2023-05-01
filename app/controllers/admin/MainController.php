<?php
namespace app\controllers\admin;
use app\models\Main;
use RedBeanPHP\R;
use wfm\Controller;

/**
 * @property Main $model
 */
class MainController extends Controller
{
    public function indexAction()
    {
        $names = $this->model->get_names();
        $one_name = R::getRow( 'SELECT * FROM users WHERE id = 2');
        $this->setMeta('Admin', 'Admin', 'Admin');
        $this->set(compact('names'));
    }
}