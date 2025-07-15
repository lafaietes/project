<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

require 'uploads/db.php';

// Se o formulário for submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'];
    $ficheiro = $_FILES['ficheiro'];

    if ($ficheiro['error'] === 0) {
        $nomeFinal = time() . '_' . basename($ficheiro['name']);
        $destino = 'uploads/' . $nomeFinal;

        if (move_uploaded_file($ficheiro['tmp_name'], $destino)) {
            // Corrigido: usar coluna "imagem" em vez de "ficheiro"
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
?>

<?php require '../includes/header.php'; ?>

<main class="container">
  <h2>Backoffice - Galeria</h2>

  <?php if (isset($mensagem)) echo "<p style='color:green;'>$mensagem</p>"; ?>
  <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

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
    <?php
    $res = $conn->query("SELECT * FROM galeria ORDER BY criado_em DESC");
    while ($item = $res->fetch_assoc()):
    ?>
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

<?php require '../includes/footer.php'; ?>