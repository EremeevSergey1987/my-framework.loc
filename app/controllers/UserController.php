<?php
namespace app\controllers;
use app\models\User;
use wfm\App;

/**
 * @property User $model
 */
class UserController extends AppController
{
    public function signupAction()
    {
        if(User::checkAuth()){header("Location: http://my-framework.loc/");}
        if(!empty($_POST)){
            $data = $_POST;
            $this->model->load($data);
            if(!$this->model->validate($data) || !$this->model->checkUnique()){
                $this->model->getErrors();
                $_SESSION['form_data'] = $data;
            } else {
                $this->model->attributes['password'] = password_hash($this->model->attributes['password'], PASSWORD_DEFAULT);
                if ($this->model->save('users')){
                    $_SESSION['success'] = 'Пользователь добавлен!';
                } else {
                    $_SESSION['errors'] = 'Ошибка добавления пользователя!';
                }

            }
            //header("Location: http://my-framework.loc/file");
        }
        $this->setMeta('Регистрация', 'Регистрация', 'Регистрация');
    }

    public function loginAction ()
    {
        //if(User::checkAuth()){header("Location: http://my-framework.loc/");}

        if (!empty($_POST)){
            if($this->model->login()){
                $_SESSION['success'] = 'Вы успешно авторизованы';
                header("Location: http://my-framework.loc/file");
            } else {
                $_SESSION['errors'] = 'Ошибка авторизации';
                header("Location: http://my-framework.loc/");
            }
        }

        $this->setMeta('Авторизация', 'Авторизация', 'Авторизация');
    }

    public function logoutAction()
    {
        if(User::checkAuth()){
            unset($_SESSION['user']);
        }
        header("Location: http://my-framework.loc/");
    }

}