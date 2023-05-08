<?php

namespace wfm;

use RedBeanPHP\R;
use Valitron\Validator;

abstract class Model
{
    public array $attributes = [];
    public array $errors = [];
    public array $rules = [];

    public function __construct()
    {
        Db::getInstance();
    }

    public function load($post = true)
    {
        $data = $post ? $_POST : $_GET;
        debug($data);
        foreach ($this->attributes as $name => $value){
            if(isset($data[$name])){
                $this->attributes[$name] = $data[$name];
            }
        }
    }
    public function validate($data): bool
    {
        Validator::lang('ru');
        $validator = new Validator($data);
        $validator->rules($this->rules);
        if ($validator->validate()){
            return true;
        } else {
            $this->errors = $validator->errors();
            return false;
        }
    }
    public function getErrors()
    {
        $errors = '<ul>';
        foreach ($this->errors as $error){
            foreach ($error as $item){
                $errors .= "<li>{$item}</li>";
            }
        }
        $errors .= '</ul>';
        $_SESSION['errors'] = $errors;
    }

    public function save($table): int|string
    {
        $tbl = R::dispense($table);
        foreach ($this->attributes as $name => $value){
            if ($value != ''){
                $tbl->$name = $value;
            }
        }
        return R::store($tbl);
    }

    public function  update($table, $id): int|string
    {
        $tbl = R::load($table, $id);
        foreach ($this->attributes as $name => $value){
            if ($value != ''){
                $tbl->$name = $value;
            }
        }
        return R::store($tbl);
    }

}