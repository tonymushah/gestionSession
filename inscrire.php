<?php
require('./gestionnaire.php');

$username=$_POST['username'];
$password=$_POST['password'];

echo newSession($username,$password);