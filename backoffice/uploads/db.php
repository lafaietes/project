<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'projeto_web';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Erro na conexão com a base de dados: " . $conn->connect_error);
}

function closeConnection($conn) {
    if ($conn) {
        $conn->close();
    }
}
?>