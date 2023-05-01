<?php

namespace app\models\admin;

use RedBeanPHP\R;
use wfm\Model;

class Main extends Model
{
    public function get_names(): array
    {
        return R::findAll('users');
    }
}