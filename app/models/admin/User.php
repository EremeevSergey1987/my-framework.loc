<?php

namespace app\models\admin;

use RedBeanPHP\R;
use wfm\App;
use wfm\Model;

class User extends \app\models\User
{
    //public function get_users($start, $perpage): array
    public function get_users(): array
    {
        return R::findAll('users');
    }
    public function get_user($id): array
    {
        return R::getRow("SELECT * FROM users WHERE id =?", [$id]);
    }
    public function dell_user($id)
    {
        $find = R::getRow("SELECT * FROM users WHERE id =?", [$id]);

        $delete = R::load('users', $find->id);
        R::trash($delete);
    }

}

