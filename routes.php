<?php

$router->get('/home', 'PagesController@home', 'homepage');


// ACCOUNT

$router->get('/account', 'AuthController@user', 'account');
$router->get('/account/edit', 'AuthController@updateUser', 'account.edit');
$router->put('/account/edit', 'AuthController@updateUser');

$router->get('/login', 'NoAuthController@login', 'login');
$router->post('/login', 'NoAuthController@login');
$router->get('/register', 'NoAuthController@register', 'register');
$router->post('/register', 'NoAuthController@register');
$router->post('/logout', 'AuthController@logout', 'logout');


// USERS

$router->get('/users', 'UserController@index', 'userspage');
$router->get('/users/new', 'UserController@store', 'usersnewpage');
$router->post('/users/new', 'UserController@store');
$router->get('/users/edit/:id', 'UserController@edit', 'userseditpage');
$router->put('/users/edit/:id', 'UserController@edit');
$router->get('/users/user/:id', 'UserController@show', 'usersshow');
$router->delete('/users/user/:id', 'UserController@delete');


// COURSES

$router->get('/cours', 'CourseController@index', 'courspage');
$router->get('/cours/new', 'CourseController@store', 'coursnewpage');
$router->post('/cours/new', 'CourseController@store');
$router->get('/cours/edit/:id', 'CourseController@edit', 'courseditpage');
$router->put('/cours/edit/:id', 'CourseController@edit');
$router->get('/cours/course/:id', 'CourseController@show', 'coursshowpage');
$router->delete('/cours/course/:id', 'CourseController@delete');


// FORMATIONS

$router->get('/formations', 'FormationController@index', 'formationspage');
$router->get('/formations/new', 'FormationController@store', 'formationsnewpage');
$router->post('/formations/new', 'FormationController@store');
$router->get('/formations/edit/:id', 'FormationController@edit', 'formationseditpage');
$router->put('/formations/edit/:id', 'FormationController@edit');
$router->get('/formations/formation/:id', 'FormationController@show', 'formationsshowpage');
$router->delete('/formations/formation/:id', 'FormationController@delete');


// SALLES

$router->get('/salles', 'SalleController@index', 'sallespage');
$router->get('/salles/new', 'SalleController@store', 'sallesnewpage');
$router->post('/salles/new', 'SalleController@store');
$router->get('/salles/edit/:id', 'SalleController@edit', 'salleseditpage');
$router->put('/salles/edit/:id', 'SalleController@edit');
$router->get('/salles/salle/:id', 'SalleController@show', 'sallesshowpage');
$router->delete('/salles/salle/:id', 'SalleController@delete');


$router->get('/notes', 'PagesController@notes', 'notespage');

$router->get('/horaires', 'PagesController@horaires', 'horairespage');
$router->get('/absences', 'PagesController@absences', 'absencespage');
$router->get('/etudiants', 'PagesController@etudiants', 'etudiantspage');
$router->get('/enseignants', 'PagesController@enseignants', 'enseignantspage');

$router->get('/admin/index', 'PagesController@adminhome', 'adminhomepage');
$router->get('/admin/absences', 'PagesController@adminabsences', 'adminabsencespage');
$router->get('/personnel_administratif/index', 'PagesController@personneladminhome', 'personneladminhomepage');




