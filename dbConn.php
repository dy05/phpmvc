<?php
//step1: create a database connection
$host = 'localhost';//127.0.0.1
$user = 'root';
$password = '';
$database = 'solution_factory';
$connection = mysqli_connect($host,$user,$password,$database);
//test if connection succeeded
if($connection === false){
    die('Connection failed' . mysqli_connect_error());
}


