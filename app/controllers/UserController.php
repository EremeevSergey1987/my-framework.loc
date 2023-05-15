<?php
namespace app\controllers;
use app\models\User;
use wfm\App;


/**
 * @property User $model
 */
class UserController extends AppController
{
    public function editAction()
    {
        if(User::checkAuth()){$this->redirect();}

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
        }

        $this->setMeta('Регистрация!', 'Регистрация', 'Регистрация');
    }


    public function signupAction()
    {
        if(User::checkAuth()){$this->redirect();}
        if(!empty($_POST)){
            $this->model->load();
            if(!$this->model->validate($this->model->attributes) || !$this->model->checkUnique()){
                $this->model->getErrors();
                $_SESSION['form_data'] = $this->model->attributes;
            } else {
                $this->model->attributes['password'] = password_hash($this->model->attributes['password'], PASSWORD_DEFAULT);
                if ($this->model->save('users')){
                    $_SESSION['success_signup_login'] = 'Пользователь добавлен! И авторизован!';
                    $this->redirect('/file');
                    $this->loginAction();
                    mkdir("/var/www/html/my-framework.loc/public/assets/files/upload/{$_SESSION['user']['id']}", 0777);
                } else {
                    $_SESSION['errors'] = 'Ошибка добавления пользователя!';
                }
            }
        }
        $this->setMeta('Регистрация!', 'Регистрация', 'Регистрация');
    }

    public function loginAction ()
    {
        if(User::checkAuth()){header("Location: http://my-framework.loc/file");}
        if (!empty($_POST)){
            if($this->model->login()){
                //$_SESSION['success'] = 'Вы успешно авторизованы';
                $this->redirect('/file');
            } else {
                $_SESSION['errors'] = 'Ошибка авторизации';
            }
        }
        $this->setMeta('Авторизация', 'Авторизация', 'Авторизация');
    }

    public function logoutAction()
    {
        if(User::checkAuth()){
            unset($_SESSION['user']);
        }
        $this->setMeta('Выход', 'Выход', 'Выход');
        $this->redirect();
    }

    public function updatepasswordAction()
    {
        if (!empty($_POST)) {
            $this->model->updatePass();
        }
        $this->setMeta('Восстановление пароля', 'Восстановление пароля', 'Восстановление пароля');
    }

}