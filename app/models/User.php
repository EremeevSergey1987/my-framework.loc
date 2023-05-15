<?php

namespace app\models;

use PHPMailer\PHPMailer\PHPMailer;
use RedBeanPHP\R;

class User extends AppModel
{
    public array $attributes = [
        'name' => '',
        'email' => '',
        'password' => '',
    ];

    public array $rules = [
        'required' => ['email', 'password', 'name', ],
        'email' => ['email'],
        'optional' => ['password', 'email',],
        'lengthMin' => [
            ['password', 6],
            ['name', 2],
        ],

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
            $this->errors['unique'][] = $text_error ?: 'Пользователь с таким e-mail уже существует. Если это Ваш e-mail попробуйте <a href="/user/updatepassword">восстановить пароль</a>';
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

    public function updatePass()
    {
        $email = post('email');
        $user = R::findOne('users', "email = ?", [$email]);
        if($user){
            $user->password = rand(45644, 85644);
            if (!error_get_last()) {
                $email = $_POST['email'];
                $title = "Восстановление пароля";
                $body = "<h2>Новый пароль</h2><b>Почта:</b> $email<br><br><b>Новый пароль:</b> - {$user->password}";
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->CharSet = "UTF-8";
                $mail->SMTPAuth   = true;
                $mail->Debugoutput = function($str, $level) {$GLOBALS['data']['debug'][] = $str;};
                $mail->Host       = 'smtp.yandex.ru';
                $mail->Username   = 'ya.colgon@yandex.ru';
                $mail->Password   = 'fwkqvbjaoksyidmr';
                $mail->SMTPSecure = 'ssl';
                $mail->Port       = 465;
                $mail->setFrom('ya.colgon@yandex.ru', 'Best file Starge'); // Адрес самой почты и имя отправителя
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = $title;
                $mail->Body = $body;
                if ($mail->send()) {
                    $data['result'] = "success";
                    $data['info'] = "Сообщение успешно отправлено!";
                } else {
                    $data['result'] = "error";
                    $data['info'] = "Сообщение не было отправлено. Ошибка при отправке письма";
                    $data['desc'] = "Причина ошибки: {$mail->ErrorInfo}";
                }
            } else {
                $data['result'] = "error";
                $data['info'] = "В коде присутствует ошибка";
                $data['desc'] = error_get_last();
            }
            $user->password = password_hash($user->password, PASSWORD_DEFAULT);
            R::store( $user );
            $_SESSION['success'] = 'Пароль отправлен на указанную электронную почту';
        } else {
            $_SESSION['errors'] = 'Пользователь с такой почтой не зарегистрирован';
        }
    }
}
