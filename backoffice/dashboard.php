<?php
require '../includes/header.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

require 'uploads/db.php';
?>

<main class="container">
  <h2>Dashboard</h2>
  <ul>
    <li><a href="galeria.php">Gerir Galeria</a></li>
    <li><a href="mensagens.php">Mensagens</a></li>
    <li><a href="logout.php">Sair</a></li>
  </ul>

  <?php
  $res = $conn->prepare("SELECT COUNT(*) as nao_lidas FROM mensagens WHERE lida = 0");
  $res->execute();
  $res->bind_result($nao_lidas);
  $res->fetch();
  if ($nao_lidas > 0) {
      echo "<p>Você tem $nao_lidas mensagem(ns) não lida(s).</p>";
  }
  $res->close();
  closeConnection($conn);
  ?>
</main>

<?php require '../includes/footer.php'; ?>