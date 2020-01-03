<?php

session_start();

require __DIR__ . '/../init.php';

if (isset($_SERVER['PATH_INFO']))
{
    $pathInfo = $_SERVER['PATH_INFO'];
}else
{
    header('Location: index.php/index');
    die();
}

$routes = [
    '/index2018' => [
        'controller' => 'tmcController',
        'method' => 'index'
    ],
    '/index' => [
        'controller' => 'tmcController',
        'method' => 'tournament'
    ],
    '/tournament' => [
        'controller' => 'tmcController',
        'method' => 'tournament'        
    ],
    '/settournament' => [
        'controller' => 'tmcController',
        'method' => 'settournament'        
    ],
    '/group' => [
        'controller' => 'tmcController',
        'method' => 'group'
    ],
    '/grouphistory' => [
        'controller' => 'tmcController',
        'method' => 'group'
    ],
    '/setgrouphistory' => [
        'controller' => 'tmcController',
        'method' => 'setgroup'
    ],
    '/setgroup' => [
        'controller' => 'tmcController',
        'method' => 'setgroup'
    ],
    '/finalfour' => [
        'controller' => 'tmcController',
        'method' => 'finalfour'
    ],
    '/setfinalfour' => [
        'controller' => 'tmcController',
        'method' => 'setfinalfour'
    ],
    '/history' => [
        'controller' => 'tmcController',
        'method' => 'history'
    ],
    '/edithistory' => [
        'controller' => 'tmcController',
        'method' => 'edithistory'
    ],
    '/edithistoryfinal' => [
        'controller' => 'tmcController',
        'method' => 'edithistoryfinal'
    ],
    '/editteam' => [
        'controller' => 'tmcController',
        'method' => 'editteam'
    ],
    '/showteam' => [
        'controller' => 'tmcController',
        'method' => 'showteam'
    ],
    '/login' => [
        'controller' => 'loginController',
        'method' => 'login'
    ],
    '/dashboard' => [
        'controller' => 'loginController',
        'method' => 'dashboard'
    ],
    '/impressum' => [
        'controller' => 'tmcController',
        'method' => 'impressum'
    ],
    '/dgsvo' => [
        'controller' => 'tmcController',
        'method' => 'dgsvo'
    ],
    '/logout' => [
        'controller' => 'loginController',
        'method' => 'logout'
    ]
];

if (isset($routes[$pathInfo])){
    $route = $routes[$pathInfo];
    $controller = $container->make($route['controller']);
    $method = $route['method'];
    $controller->$method();
}
?>