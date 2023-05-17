<?php
define("DEBUG", 1);
define("ROOT", dirname(__DIR__));
define("WWW", ROOT . '/public');
define("APP", ROOT . '/app');
define("CORE", ROOT . '/vendor/wfm');
define("HELPERS", ROOT . '/vendor/wfm/helpers');
define("CACHE", ROOT . '/tmp/cache');
define("LOGS", ROOT . '/tmp/logs');
define("CONFIG", ROOT . '/config');
define("LAYOUT", 'ishop');
define("PATH", 'http://my-framework.loc');
define("PATH_IMG", 'http://my-framework.loc/assets/files/upload/');
define("ADMIN", 'http://my-framework.loc/admin');
define("NO_IMAGE", 'uploads/no_image.jpg');
// Директория куда будут загружаться файлы.
define("FILE_DIRECTORY", "/var/www/html/my-framework.loc/public/assets/files/upload/");

require_once ROOT . '/vendor/autoload.php';
