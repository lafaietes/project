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
  <link rel="stylesheet" href="<?php echo (dirname($_SERVER['PHP_SELF']) === '/projeto' || dirname($_SERVER['PHP_SELF']) === '/') ? '/projeto/assets/css/style.css' : '../../projeto/assets/css/style.css'; ?>">
</head>
<body>
  <header>
    <nav>
      <a href="/projeto/index.php">Home</a>
      <a href="/projeto/sobre.php">Sobre</a>
      <a href="/projeto/galeria.php">Galeria</a>
      <a href="/projeto/contactos.php">Contactos</a>

      <?php if (isset($_SESSION['admin'])): ?>
        <a href="/projeto/backoffice/mensagens.php">📥 Mensagens</a>
        <a href="/projeto/backoffice/logout.php">Logout</a>
      <?php else: ?>
        <a href="/projeto/backoffice/login.php">Admin</a>
      <?php endif; ?>
    </nav>
  </header>