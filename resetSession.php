<?php
require_once("./Handler.php");
session_start();
session_destroy();
header("Location: ./index.php");
?>