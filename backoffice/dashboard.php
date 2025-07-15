<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
?>

<h2>Dashboard</h2>
<ul>
  <li><a href="galeria.php">Gerir Galeria</a></li>
  <li><a href="logout.php">Sair</a></li>
</ul>