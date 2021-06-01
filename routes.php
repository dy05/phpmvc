<?php

$router->get('/home', 'PagesController@home', 'homepage');
$router->get('/index', function () use ($router) {
    header('Location:' . ROUTE . '/home');
});
$router->get('/login', 'NoAuthController@login', 'loginpage');
$router->post('/login', 'NoAuthController@login', 'loginform');
$router->get('/register', 'NoAuthController@register', 'registerpage');
$router->post('/register', 'NoAuthController@register', 'registerform');
//$router->get('/logout', 'AuthController@logout', 'logout');
$router->get('/users', 'AuthController@users', 'userspage');
$router->get('/users/:id', 'AuthController@show_user', 'usersshow');
$router->get('/users/new', 'AuthController@add_user', 'usersnewpage');
$router->post('/users/new', 'AuthController@usersadd', 'usersnewform');
$router->get('/blogs', 'PagesController@blogs', 'blogpage');
$router->get('/blogs/:id', 'PagesController@blogs', 'blogshowpage');
$router->post('/blogs/:id', 'PagesController@editblog', 'blogeditpage');
//$router->get('/blogs/new', 'PagesController@newblogs', 'blognewpage');
$router->post('/blogs/new', 'PagesController@newblog', 'blognewform');
$router->post('/blogs/delete/:id', 'PagesController@deleteblog', 'blogdeleteblog');
$router->get('/blogs/delete/:id', 'PagesController@deleteblog', 'blogdelete');
$router->get('/account', 'AuthController@home', 'adminhome');
