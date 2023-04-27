<?php

namespace wfm;

class View
{
    public string $content = '';
    public function __construct(
        public $route,
        public $layout = '',
        public $view,
        public $meta = [],
    )
    {
        if(false !== $this->layout){
            $this->layout = $this->layout ?: LAYOUT;

        }
    }

    public function render($data)
    {

    }

}