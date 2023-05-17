<?php

namespace app\controllers\admin;

use app\controllers\AppController;
use app\models\admin\User;


/** @property User $model */
class UserController extends AppController
{
    public function indexAction()
    {
        if(User::checkAuthRole()){$this->redirect('/file');}
        $users = $this->model->get_users();
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
        //if(User::checkAuth()){$this->redirect('/file');}
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $user = $this->model->get_user($id);
        }


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

                if($_SESSION['user']['role'] == 'admin'){
                    $user_id = $_GET['id'];
                } else {
                    $user_id = $_SESSION['user']['id'];
                }

                if ($this->model->update('users', $user_id)) {

                    foreach ($this->model->attributes as $k => $v) {
                        if (!empty($v) && $k != 'password') {
                            $_SESSION['user'][$k] = $v;
                        }
                    }
                    //header("Location: http://my-framework.loc/admin/user/edit?id={$id}");
                    $_SESSION['success_signup_login'] = 'Пользователь обновлен!';
                } else {
                    $_SESSION['errors'] = 'Ошибка добавления пользователя!';
                }
            }

        }
        if(isset($_GET['id'])) {
            $this->set(compact('user'));
        }
        $this->setMeta('Регистрация!!!', 'Регистрация', 'Регистрация');
    }

    public function dellAction()
    {
        $id = $_GET['id'];
        $this->model->dell_user($id);
        $this->redirect('/admin/');
        $this->setMeta('Регистрация!!!', 'Регистрация', 'Регистрация');
    }
}