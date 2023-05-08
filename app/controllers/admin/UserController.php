<?php

namespace app\controllers\admin;

use app\controllers\AppController;
use app\models\admin\User;
use RedBeanPHP\R;
//use wfm\Pagination;
use wfm\Controller;
use wfm\App;


/** @property User $model */
class UserController extends AppController
{
    public function indexAction()
    {
//        $page = get('page');
//        $perpage = 1;
//        $total = R::count('users');
//        $pagination = new Pagination($page, $perpage, $total);
//        $start = $pagination->getStart();

        if(User::checkAuthRole()){header("Location: http://my-framework.loc/");}

        $users = $this->model->get_users();
        //$one_name = R::getRow( 'SELECT * FROM users WHERE id = 2');
        $this->setMeta('Список пользователей', 'Admin', 'Admin');
        $this->set(compact('users'));

    }

    public function viewAction()
    {
        $id = $_GET['id'];
        $user = $this->model->get_user($id);
        if (!$user){
            throw new \Exception('Нет пользователя с таким ID', 404);
        }
        $this->setMeta('Просмотр пользователя', 'Admin', 'Admin');
        $this->set(compact('user'));
    }

    public function editAction()
    {
        //if(User::checkAuth()){header("Location: http://my-framework.loc/");}


        if (!empty($_POST)) {
            $this->model->load();
            if (empty($this->model->attributes['password'])) {
                unset($this->model->attributes['password']);
            }
            unset($this->model->attributes['email']);

            if (!$this->model->validate($this->model->attributes)) {
                $this->model->getErrors();
            } else {
                if (!empty($this->model->attributes['password'])) {
                    $this->model->attributes['password'] = password_hash($this->model->attributes['password'], PASSWORD_DEFAULT);
                }

                if ($this->model->update('users', $_SESSION['user']['id'])) {
                    $_SESSION['success_signup_login'] = 'Пользователь обновлен!';
                    foreach ($this->model->attributes as $k => $v) {
                        if (!empty($v) && $k != 'password') {
                            $_SESSION['user'][$k] = $v;
                        }
                    }
                } else {
                    $_SESSION['errors'] = 'Ошибка добавления пользователя!';
                }
            }
            //header("Location: http://my-framework.loc/file");
        }

        $this->setMeta('Регистрация!!!', 'Регистрация', 'Регистрация');
    }

    public function dellAction()
    {
        $id = $_GET['id'];
        $this->model->dell_user($id);
        header("Location: http://my-framework.loc/admin/");
    }
}