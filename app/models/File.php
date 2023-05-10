<?php

namespace app\models;

use RedBeanPHP\R;
use wfm\Model;


class File extends Model
{
    public function get_files(): array
    {
        return R::findAll('files');
    }
}