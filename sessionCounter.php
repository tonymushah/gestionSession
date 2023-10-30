<?php
require_once("./Handler.php");
session_start();

if(isset($_SESSION["count"])){
    $count = $_SESSION["count"];
    
    $count = $count + 1;
    $_SESSION["count"] = $count;
}else {
    $_SESSION["count"] = 0;
}
header("Location: ./index.php");
?>