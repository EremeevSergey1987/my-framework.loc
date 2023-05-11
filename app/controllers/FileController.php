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
    public $user_id;
    public function indexAction()
    {
        $this->user_id = $_SESSION['user']['id'];
        $files_one_user = R::getAll( "SELECT * FROM files WHERE main_user = {$this->user_id}" );
        $this->setMeta('Files', 'Files', 'Files');
        $this->set(compact('files_one_user'));
    }

    public function dellAction()
    {
        $id = $_GET['id'];
        $this->user_id = $_SESSION['user']['id'];
        $files_name = R::load('files', $id);
        $this->model->dell_file($id, $this->user_id, $files_name->file_name);
        header("Location: http://my-framework.loc/file/");
        $this->setMeta('Регистрация!!!', 'Регистрация', 'Регистрация');
    }

}