<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

require 'uploads/db.php';

// Processar edição de status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar']) && is_numeric($_POST['id'])) {
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("SELECT lida FROM mensagens WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($lida_atual);
    $stmt->fetch();
    $stmt->close();

    $novo_status = $lida_atual ? 0 : 1;
    $stmt = $conn->prepare("UPDATE mensagens SET lida = ? WHERE id = ?");
    $stmt->bind_param("ii", $novo_status, $id);
    $stmt->execute();
    $stmt->close();
    header('Location: mensagens.php');
    exit();
}

// Eliminar mensagem
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conn->prepare("DELETE FROM mensagens WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header('Location: mensagens.php');
    exit();
}

$stmt = $conn->prepare("SELECT id, nome, email, mensagem, enviado_em, lida FROM mensagens ORDER BY enviado_em DESC");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>Sem mensagens no momento.</p>";
} else {
    while ($msg = $result->fetch_assoc()):
?>
    <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 8px;">
        <p><strong>Nome:</strong> <?= htmlspecialchars($msg['nome']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($msg['email']) ?></p>
        <p><strong>Mensagem:</strong><br><?= nl2br(htmlspecialchars($msg['mensagem'])) ?></p>
        <p><small>Enviado em: <?= $msg['enviado_em'] ?></p>
        <p><strong>Status:</strong> <?= $msg['lida'] ? 'Lida' : 'Não Lida' ?></p>
        <form method="POST" style="display:inline;">
            <input type="hidden" name="id" value="<?= $msg['id'] ?>">
            <button type="submit" name="editar"><?= $msg['lida'] ? 'Marcar como Não Lida' : 'Marcar como Lida' ?></button>
        </form>
        <a href="?eliminar=<?= $msg['id'] ?>" style="color:red;" onclick="return confirm('Tem a certeza que deseja eliminar esta mensagem?')">🗑️ Eliminar</a>
    </div>
<?php
    endwhile;
}
$stmt->close();
closeConnection($conn);
?>
<?php require '../includes/header.php'; ?>
<?php require '../includes/footer.php'; ?>