<?php
// processa_form.php

// Conecta à base de dados (ajusta se usares outro login/senha)
$conn = new mysqli('localhost', 'root', '', 'projeto_web');

// Verifica conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Processa apenas se for POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escapa os dados para evitar SQL Injection
    $nome = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);
    $mensagem = $conn->real_escape_string($_POST['mensagem']);

    // Monta a query
    $sql = "INSERT INTO contactos (nome, email, mensagem) 
            VALUES ('$nome', '$email', '$mensagem')";

    // Executa a query
    if ($conn->query($sql) === TRUE) {
        header('Location: contactos.php?sucesso=1');
        exit();
    } else {
        echo "Erro ao enviar mensagem: " . $conn->error;
    }
}

$conn->close();
?>