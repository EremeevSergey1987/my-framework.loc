<?php
use wfm\Router;

//Router::add('^admin/credentials/?$', ['controller' => 'User', 'action' => 'credentials', 'admin_prefix' => 'admin']);
Router::add('^admin/?$', ['controller' => 'User', 'action' => 'index', 'admin_prefix' => 'admin']);
Router::add('^admin/(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['admin_prefix' => 'admin']);



Router::add('^(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)/?$');

Router::add('^$', ['controller' => 'Main', 'action' => 'index']);

Router::add('file', ['controller' => 'File', 'action' => 'index']);


//Router::add('^admin/user/?$', ['controller' => 'User', 'action' => 'index', 'admin_prefix' => 'admin']);


