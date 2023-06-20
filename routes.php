<?php

$router->get('/home', 'PagesController@home', 'homepage');
//$router->get('/index', function () use ($router) {
//    header('Location:' . ROUTE . '/home');
//});

$router->get('/login', 'NoAuthController@login', 'login');
$router->post('/login', 'NoAuthController@login');
$router->get('/register', 'NoAuthController@register', 'register');
$router->post('/register', 'NoAuthController@register');
$router->post('/logout', 'AuthController@logout', 'logout');

$router->get('/users', 'AuthController@users', 'userspage');
$router->get('/users/new', 'AuthController@add_user', 'usersnewpage');
$router->post('/users/new', 'AuthController@usersadd', 'usersnewform');
$router->get('/users/:id', 'AuthController@show_user', 'usersshow');

$router->get('/account', 'AuthController@home', 'adminhome');

$router->get('/notes', 'PagesController@notes', 'notespage');

// COURSES

$router->get('/cours', 'CourseController@index', 'courspage');
$router->get('/cours/new', 'CourseController@store', 'coursnewpage');
$router->post('/cours/new', 'CourseController@store');
$router->get('/cours/edit/:id', 'CourseController@edit', 'courseditpage');
$router->put('/cours/edit/:id', 'CourseController@edit');
$router->get('/cours/:id', 'CourseController@show', 'coursshowpage');
$router->delete('/cours/:id', 'CourseController@delete');


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




