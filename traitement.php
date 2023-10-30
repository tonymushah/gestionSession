<?php
require('./gestionnaire.php');

$username=$_POST['username'];
$password=$_POST['password'];

// echo $username .' , '.$password ;

echo getSession($username,$password);
