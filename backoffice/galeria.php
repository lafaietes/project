<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

require 'uploads/db.php';

$mensagem = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $ficheiro = $_FILES['ficheiro'];

    if ($ficheiro['error'] === 0) {
        $nomeFinal = time() . '_' . basename($ficheiro['name']);
        $destino = 'uploads/' . $nomeFinal;

        if (move_uploaded_file($ficheiro['tmp_name'], $destino)) {
            $stmt = $conn->prepare("INSERT INTO galeria (descricao, imagem, criado_em) VALUES (?, ?, NOW())");
            $stmt->bind_param("ss", $descricao, $nomeFinal);
            $stmt->execute();
            $mensagem = "Imagem enviada com sucesso!";
        } else {
            $erro = "Erro ao mover o ficheiro.";
        }
    } else {
        $erro = "Erro no upload.";
    }
}

$stmt = $conn->prepare("SELECT id, descricao, imagem FROM galeria ORDER BY criado_em DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<?php require '../includes/header.php'; ?>

<main class="container">
  <h2>Backoffice - Galeria</h2>

  <?php if ($mensagem) echo "<p style='color:green;'>$mensagem</p>"; ?>
  <?php if ($erro) echo "<p style='color:red;'>$erro</p>"; ?>

  <form method="POST" enctype="multipart/form-data">
    <label>Descrição:</label><br>
    <input type="text" name="descricao" required><br><br>

    <label>Imagem:</label><br>
    <input type="file" name="ficheiro" accept="image/*" required><br><br>

    <button type="submit">Enviar</button>
  </form>

  <hr>

  <h3>Imagens na Galeria</h3>
  <div style="display: flex; flex-wrap: wrap; gap: 15px;">
    <?php while ($item = $result->fetch_assoc()): ?>
    <div style="width: 200px; text-align: center; border: 1px solid #ccc; padding: 10px; border-radius: 8px;">
      <img src="uploads/<?= htmlspecialchars($item['imagem']) ?>" width="100%" style="border-radius: 8px;">
      <p><?= htmlspecialchars($item['descricao']) ?></p>
      <div style="margin-top: 10px;">
        <a href="editar.php?id=<?= $item['id'] ?>">✏️ Editar</a> |
        <a href="eliminar.php?id=<?= $item['id'] ?>" onclick="return confirm('Tem a certeza que deseja eliminar esta imagem?');">🗑️ Eliminar</a>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</main>

<?php
$stmt->close();
closeConnection($conn);
require '../includes/footer.php';
?>