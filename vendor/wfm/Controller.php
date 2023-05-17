<?php

namespace wfm;

abstract class Controller
{
    public array $data = [];
    public array $meta = [];
    public $layout;
    public $view;
    public object $model;

    public function __construct(public $route = [])
    {

    }

    public function formatSize($size)
    {
        $i = 0;
        while (floor($size / 1024) > 0) {
            ++$i;
            $size /= 1024;
        }
        $size = str_replace('.', ',', round($size, 1));
        switch ($i) {
            case 0: return $size .= ' байт';
            case 1: return $size .= ' КБ';
            case 2: return $size .= ' МБ';
        }
    }

    public function redirect($action = null)
    {
        $main_url = PATH;
        if($action){
            header("Location: {$main_url}{$action}");
        } else {
            header("Location: {$main_url}");
        }
    }

    public function getModel()
    {
        $model = 'app\models\\' . $this->route['admin_prefix'] . $this->route['controller'];
        if (class_exists($model)){
            $this->model = new $model();
        }
    }

    public function getView()
    {
        $this->view = $this->view ?: $this->route['action'];
        (new View($this->route, $this->layout, $this->view, $this->meta))->render($this->data);
    }

    public function set($data)
    {
        $this->data = $data;
    }

    public function setMeta($title = '', $description = '', $keywords = '')
    {
        $this->meta = [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
        ];
    }
}