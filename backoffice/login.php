<?php
require '../includes/header.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilizador = $_POST['utilizador'];
    $senha = $_POST['senha'];

    // Login simples (ideal seria usar hash + base de dados)
    if ($utilizador === 'admin' && $senha === '1234') {
        $_SESSION['admin'] = true;
        header('Location: dashboard.php');
        exit();
    } else {
        $erro = "Utilizador ou senha inválidos.";
    }
}
?>

<main class="container">
  <h2>Login</h2>
  <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
  <form method="POST">
    <label>Utilizador:</label><br>
    <input type="text" name="utilizador"><br>
    <label>Senha:</label><br>
    <input type="password" name="senha"><br><br>
    <button type="submit">Entrar</button>
  </form>
</main>

<?php require '../includes/footer.php'; ?>