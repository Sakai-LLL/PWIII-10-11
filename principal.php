<?php require_once 'includes/auth.php'; ?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Principal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<div class="container mt-4">
  <h3>Bem-vindo(a), <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!</h3>
  <p class="text-muted">Use o menu para gerenciar produtos e usuários.</p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
