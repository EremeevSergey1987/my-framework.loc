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

    public function dell_file($id, $user_id, $files_name)
    {
        $file = R::load('files', $id);
        R::trash($file);



        unlink("/assets/files/upload/{$user_id}/{$files_name}");
    }
}