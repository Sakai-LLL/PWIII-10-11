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
    $erro = 'E-mail ou senha inválidos 🥺';
}
$titulo = 'Login';
include 'includes/head.php';
?>
<div class="container">
  <div class="login-box">
    <span class="laco">🎀</span>
    <div class="card"><div class="card-body p-4">
      <h3 class="text-center titulo-fofo mb-3">Loja Fofinha</h3>
      <?php if ($erro): ?><div class="alert alert-danger"><?= $erro ?></div><?php endif; ?>
      <form method="post">
        <div class="mb-3"><label class="form-label">💌 E-mail</label>
          <input type="email" name="email" class="form-control" placeholder="seu@email.com" required></div>
        <div class="mb-3"><label class="form-label">🔑 Senha</label>
          <input type="password" name="senha" class="form-control" placeholder="••••••" required></div>
        <button class="btn btn-dark w-100">Entrar ♡</button>
      </form>
      <div class="seletor-tema justify-content-center w-100 mt-3 mb-0">
        <button class="t-kitty"  onclick="trocarTema('kitty')"  aria-label="Tema Kitty"></button>
        <button class="t-melody" onclick="trocarTema('melody')" aria-label="Tema Melody"></button>
        <button class="t-kuromi" onclick="trocarTema('kuromi')" aria-label="Tema Kuromi"></button>
      </div>
    </div></div>
  </div>
</div>
<?php include 'includes/foot.php'; ?>
