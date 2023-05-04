<?php

namespace app\models;

use RedBeanPHP\R;

class User extends AppModel
{
    public array $attributes = [
        'name' => '',
        'email' => '',
        'password' => '',
    ];

    public array $rules = [
        //'optional' => ['email', 'password'],
        'required' => [
            ['email', true],
            ['password', true],
            ['name'],

        ],


        //'required' => ['email', 'password', 'name', ],
        'email' => ['email'],
        'lengthMin' => [
            ['password', 6],
            ['name', 2],
        ],

        'optional' => [
            ['email', true]
        ]



    ];

    public static function checkAuth(): bool
    {
        return isset($_SESSION['user']);
    }
    public static function checkAuthRole(): bool
    {
        if($_SESSION['user']['role'] == 'admin'){
            return false;
        }
        return true;
    }

    public function checkUnique($text_error = ''): bool
    {
        $user = R::findOne('users', 'email = ?', [$this->attributes['email']]);
        if ($user) {
            $this->errors['unique'][] = $text_error ?: 'Пользователь с таким e-mail уже существует. Если это Ваш e-mail попробуйте <a href="#">восстановить пароль</a>';
            return false;
        }
        return true;
    }

    public function login($is_admin = false): bool
    {
        $email = post('email');
        $password = post('password');
        if ($email && $password) {
            if ($is_admin) {
                $user = R::findOne('users', "email = ? AND role = 'admin'", [$email]);
            } else {
                $user = R::findOne('users', "email = ?", [$email]);
            }

            if ($user) {
                if (password_verify($password, $user->password)) {
                    foreach ($user as $k => $v) {
                        if (!$k != 'password') {
                            $_SESSION['user'][$k] = $v;
                        }
                    }
                    return true;
                }
            }
        }
        return false;
    }



}