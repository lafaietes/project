<?php
session_start();
if (!isset($_SESSION['logado'])) { // Verifica se o usuário está logado
    header('Location: login.php');
    exit();
}

require 'uploads/db.php';

// Eliminar mensagem
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conn->query("DELETE FROM mensagens WHERE id = $id");
    header('Location: mensagens.php');
    exit();
}
?>

<?php require '../includes/header.php'; ?>

<main class="container">
  <h2>Mensagens Recebidas</h2>

  <?php
  $res = $conn->query("SELECT * FROM mensagens ORDER BY enviado_em DESC");

  if ($res->num_rows === 0) {
      echo "<p>Sem mensagens no momento.</p>";
  } else {
      while ($msg = $res->fetch_assoc()):
  ?>
      <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 8px;">
        <p><strong>Nome:</strong> <?= htmlspecialchars($msg['nome']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($msg['email']) ?></p>
        <p><strong>Mensagem:</strong><br><?= nl2br(htmlspecialchars($msg['mensagem'])) ?></p>
        <p><small>Enviado em: <?= $msg['enviado_em'] ?></small></p>
        <a href="?eliminar=<?= $msg['id'] ?>" style="color:red;" onclick="return confirm('Tem a certeza que deseja eliminar esta mensagem?')">🗑️ Eliminar</a>
      </div>
  <?php endwhile; } ?>
</main>

<?php require '../includes/footer.php'; ?>