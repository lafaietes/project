<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

require 'uploads/db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // 1. Buscar o nome do ficheiro
    $stmt = $conn->prepare("SELECT imagem FROM galeria WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($imagem);
    $stmt->fetch();
    $stmt->close();

    if ($imagem) {
        // 2. Apagar o ficheiro do servidor
        $caminho = 'uploads/' . $imagem;
        if (file_exists($caminho)) {
            unlink($caminho); // Apaga o ficheiro
        }

        // 3. Apagar do banco de dados
        $stmt = $conn->prepare("DELETE FROM galeria WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

header('Location: galeria.php');
exit();