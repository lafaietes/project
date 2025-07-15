<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

require 'uploads/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: galeria.php');
    exit();
}

$id = intval($_GET['id']);

// Buscar dados da imagem
$stmt = $conn->prepare("SELECT descricao, imagem FROM galeria WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($descricaoAtual, $imagemAtual);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaDescricao = $_POST['descricao'];
    $novoFicheiro = $_FILES['ficheiro'];

    $imagemFinal = $imagemAtual;

    // Se houver novo upload de imagem
    if ($novoFicheiro['error'] === 0) {
        $imagemFinal = time() . '_' . basename($novoFicheiro['name']);
        $destino = 'uploads/' . $imagemFinal;

        if (move_uploaded_file($novoFicheiro['tmp_name'], $destino)) {
            // Apagar imagem antiga
            if (file_exists('uploads/' . $imagemAtual)) {
                unlink('uploads/' . $imagemAtual);
            }
        } else {
            $erro = "Erro ao enviar nova imagem.";
        }
    }

    // Atualizar dados
    $stmt = $conn->prepare("UPDATE galeria SET descricao = ?, imagem = ? WHERE id = ?");
    $stmt->bind_param("ssi", $novaDescricao, $imagemFinal, $id);
    $stmt->execute();

    header('Location: galeria.php');
    exit();
}
?>

<?php require '../includes/header.php'; ?>

<main class="container">
  <h2>Editar Imagem</h2>

  <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

  <form method="POST" enctype="multipart/form-data">
    <label>Descrição:</label><br>
    <input type="text" name="descricao" value="<?= htmlspecialchars($descricaoAtual) ?>" required><br><br>

    <p><strong>Imagem atual:</strong></p>
    <img src="uploads/<?= htmlspecialchars($imagemAtual) ?>" width="200" style="border-radius: 8px;"><br><br>

    <label>Nova imagem (opcional):</label><br>
    <input type="file" name="ficheiro" accept="image/*"><br><br>

    <button type="submit">Salvar Alterações</button>
  </form>
</main>

<?php require '../includes/footer.php'; ?>