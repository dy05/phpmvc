<?php

$router->get('/home', 'PagesController@home', 'homepage');
$router->get('/index', function () use ($router) {
    header('Location:' . ROUTE . '/home');
});

$router->get('/home', 'PagesController@home', 'homepage');

$router->get('/login', 'NoAuthController@login', 'login');
$router->post('/login', 'NoAuthController@login');
$router->get('/register', 'NoAuthController@register', 'register');
$router->post('/register', 'NoAuthController@register');
$router->post('/logout', 'AuthController@logout', 'logout');

$router->get('/users', 'AuthController@users', 'userspage');
$router->get('/users/new', 'AuthController@add_user', 'usersnewpage');
$router->post('/users/new', 'AuthController@usersadd', 'usersnewform');
$router->get('/users/:id', 'AuthController@show_user', 'usersshow');

$router->get('/blogs', 'PagesController@blogs', 'blogpage');
$router->get('/blogs/:id', 'PagesController@blogs', 'blogshowpage');
$router->post('/blogs/:id', 'PagesController@editblog', 'blogeditpage');

//$router->get('/blogs/new', 'PagesController@newblogs', 'blognewpage');

$router->post('/blogs/new', 'PagesController@newblog', 'blognewform');
$router->post('/blogs/delete/:id', 'PagesController@deleteblog', 'blogdeleteblog');
$router->get('/blogs/delete/:id', 'PagesController@deleteblog', 'blogdelete');

$router->get('/account', 'AuthController@home', 'adminhome');

$router->get('/notes', 'PagesController@notes', 'notespage');

$router->get('/cours', 'PagesController@cours', 'courspage');
$router->get('/formations', 'PagesController@formations', 'formationspage');
$router->get('/salles', 'PagesController@salles', 'sallespage');
$router->get('/horaires', 'PagesController@horaires', 'horairespage');
$router->get('/absences', 'PagesController@absences', 'absencespage');
$router->get('/etudiants', 'PagesController@etudiants', 'etudiantspage');
$router->get('/enseignants', 'PagesController@enseignants', 'enseignantspage');

$router->get('/admin/index', 'PagesController@adminhome', 'adminhomepage');
$router->get('/admin/absences', 'PagesController@adminabsences', 'adminabsencespage');
$router->get('/etudiant/index', 'PagesController@etudianthome', 'etudianthomepage');
$router->get('/enseignant/index', 'PagesController@enseignanthome', 'enseignanthomepage');
$router->get('/personnel_administratif/index', 'PagesController@personneladminhome', 'personneladminhomepage');




