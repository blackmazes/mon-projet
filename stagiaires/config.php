<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'stagiairesdb';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>