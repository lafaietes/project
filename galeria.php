<?php require 'includes/header.php'; ?>
<?php require 'backoffice/uploads/db.php'; ?>

<main class="container">
  <h2>Galeria</h2>
  <div style="display: flex; flex-wrap: wrap; gap: 15px;">
    <?php
    $res = $conn->query("SELECT * FROM galeria ORDER BY criado_em DESC");
    while ($item = $res->fetch_assoc()):
    ?>
      <div style="width: 200px; text-align: center;">
        <img src="backoffice/uploads/<?= htmlspecialchars($item['imagem']) ?>" width="100%" style="border-radius: 8px;">
        <p><?= htmlspecialchars($item['descricao']) ?></p>
      </div>
    <?php endwhile; ?>
  </div>
</main>

<?php require 'includes/footer.php'; ?>