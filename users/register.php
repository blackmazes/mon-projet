<?php
require 'config.php';

$stmt = $conn->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
$username = 'admin';
$pass_hash = password_hash('secret123', PASSWORD_DEFAULT);
$stmt->bind_param('ss', $username, $pass_hash);
$stmt->execute();
echo 'Compte admin créé (admin / secret123)';
$stmt->close();
$conn->close();
