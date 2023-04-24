<?php

if (PHP_MAJOR_VERSION < 8) {
    die('Необходима версия PHP >= 8');
}

require_once dirname(__DIR__) . '/config/init.php';

new \wfm\App();

echo 'Hellow';
//throw new Exception('Возникла ошибка');
//echo $erwew;
