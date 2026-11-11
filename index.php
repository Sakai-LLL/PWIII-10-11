<?php
session_start();
if (isset($_SESSION['usuario_id'])) { header('Location: principal.php'); exit; }
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'includes/conexao.php';
    require_once 'classes/Usuarios.class.php';
    $u = new Usuarios($pdo);
    $u->setEmail($_POST['email'] ?? '');
    $u->setSenha($_POST['senha'] ?? '');
    $dados = $u->login();
    if ($dados) {
        $_SESSION['usuario_id'] = $dados['id'];
        $_SESSION['usuario_nome'] = $dados['nome'];
        header('Location: principal.php');
        exit;
    }
    $erro = 'E-mail ou senha inválidos.';
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Login - Loja Fofinha</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container" style="max-width:380px; margin-top:12vh">
  <div class="card shadow-sm"><div class="card-body">
    <h4 class="mb-3 text-center">Loja Fofinha</h4>
    <?php if ($erro): ?><div class="alert alert-danger"><?= $erro ?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3"><label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">Senha</label>
        <input type="password" name="senha" class="form-control" required></div>
      <button class="btn btn-dark w-100">Entrar</button>
    </form>
  </div></div>
</div>
</body>
</html>
