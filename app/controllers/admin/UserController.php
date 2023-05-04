<?php

namespace app\controllers\admin;

use app\models\User;
use RedBeanPHP\R;
use wfm\Controller;
use wfm\App;

class UserController extends Controller
{
    public function indexAction()
    {
        if(User::checkAuthRole()){header("Location: http://my-framework.loc/");}

        $names = $this->model->get_names();
        $one_name = R::getRow( 'SELECT * FROM users WHERE id = 2');
        $this->setMeta('Admin', 'Admin', 'Admin');
        $this->set(compact('names'));
    }

    public function credentialsAction()
    {
        //if(User::checkAuth()){header("Location: http://my-framework.loc/");}
        debug($_SESSION);
        debug($_POST);
        debug($_GET);
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
                    $_SESSION['success_signup_login'] = 'Пользователь добавлен! И авторизован!';
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
}