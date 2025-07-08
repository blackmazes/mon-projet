<?php
session_start();

$host = 'localhost'; $users = 'root'; $pass = ''; $db = 'stagiairesdb';
$conn = new mysqli($host, $users, $pass, $db);
if ($conn->connect_error) die('Erreur : ' . $conn->connect_error);
$conn->set_charset('utf8');
?>