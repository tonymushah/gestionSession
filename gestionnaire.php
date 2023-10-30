<?php
require("./Handler.php");
session_set_save_handler($customSessionHandler);

function getSession($nameuser,$mdp){
$servername = "192.168.43.5:3306"; 
$username = "haproxytest";
$password = "1773";
$database = "haproxytest_data";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("La connexion à la base de données a échoué : " . $connection->connect_error);
}

$query = "SELECT id FROM sessiontable where nom='%s' and password='%s' ";
$query=sprintf($query,$nameuser,$mdp);
$result = $connection->query($query);
$session_user=0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $session_user=$row['id'];
    }
} else {
    echo "Aucun résultat trouvé.";
}

$connection->close();
return $session_user;

}

function newSession($nameuser,$mdp){

    $servername = "192.168.43.5:3306"; 
    $username = "haproxytest";
    $password = "1773";
    $database = "haproxytest_data";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("La connexion à la base de données a échoué : " . $connection->connect_error);
}

$query = "INSERT INTO sessiontable (nom,password) VALUES ('%s','%s')";
$query=sprintf($query,$nameuser,$mdp);

if ($connection->query($query) === TRUE) {
    echo "Nouvel enregistrement inséré avec succès.";
} else {
    echo "Erreur lors de l'insertion : " . $connection->error;
}

$connection->close();

}

?>
