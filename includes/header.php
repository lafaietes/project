<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- header.php -->
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Meu Projeto</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
  <header>
    <nav>
      <a href="/projeto/index.php">Home</a>
      <a href="/projeto/sobre.php">Sobre</a>
      <a href="/projeto/galeria.php">Galeria</a>
      <a href="/projeto/contactos.php">Contactos</a>

      <?php if (isset($_SESSION['logado'])): ?>
        <a href="/projeto/backoffice/mensagens.php">📥 Mensagens</a>
        <a href="/projeto/backoffice/logout.php">Logout</a>
      <?php else: ?>
        <a href="/projeto/backoffice/login.php">Admin</a>
      <?php endif; ?>
      
    </nav>
  </header>