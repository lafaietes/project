<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
?>

<h2>Adicionar Imagem à Galeria</h2>
<form action="adicionar.php" method="POST" enctype="multipart/form-data">
    <label>Imagem:</label><br>
    <input type="file" name="imagem" accept="image/*" required><br><br>

    <label>Descrição:</label><br>
    <textarea name="descricao" rows="4" cols="40" required></textarea><br><br>

    <button type="submit" name="submit">Enviar</button>
</form>

<?php
if (isset($_POST['submit'])) {
    require_once 'uploads/db.php';

    $descricao = $_POST['descricao'];
    $imagem_nome = $_FILES['imagem']['name'];
    $imagem_temp = $_FILES['imagem']['tmp_name'];
    $destino = 'uploads/' . basename($imagem_nome);

    if (move_uploaded_file($imagem_temp, $destino)) {
        $stmt = $conn->prepare("INSERT INTO galeria (ficheiro, descricao) VALUES (?, ?)");
        $stmt->bind_param("ss", $imagem_nome, $descricao);
        if ($stmt->execute()) {
            echo "<p style='color:green;'>Imagem enviada com sucesso!</p>";
        } else {
            echo "<p style='color:red;'>Erro ao inserir na base de dados.</p>";
        }
    } else {
        echo "<p style='color:red;'>Erro ao fazer upload da imagem.</p>";
    }
}
?>