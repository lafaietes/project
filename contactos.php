<?php
require 'includes/header.php';
require 'backoffice/uploads/db.php';

$mensagem_enviada = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);
    $mensagem = $conn->real_escape_string($_POST['mensagem']);

    $stmt = $conn->prepare("INSERT INTO mensagens (nome, email, mensagem, lida) VALUES (?, ?, ?, 0)");
    $stmt->bind_param("sss", $nome, $email, $mensagem);
    $mensagem_enviada = $stmt->execute();
    $stmt->close();
}
?>

<main class="container">
  <h2>Contactos</h2>

  <?php if ($mensagem_enviada): ?>
    <p style="color:green;">Mensagem enviada com sucesso!</p>
  <?php endif; ?>

  <form method="POST">
    <label>Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Mensagem:</label><br>
    <textarea name="mensagem" rows="5" required></textarea><br><br>

    <button type="submit">Enviar</button>
  </form>
</main>

<?php
require 'includes/footer.php';
closeConnection($conn);
?>