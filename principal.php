<?php
require_once 'includes/auth.php';
$titulo = 'Início';
include 'includes/head.php';
include 'includes/navbar.php';
?>
<div class="container mt-4">
  <div class="hero">
    <div class="grande">🎀</div>
    <h2 class="titulo-fofo">Bem-vindo(a), <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!</h2>
    <p class="text-muted">O que vamos cuidar hoje? ✨</p>
  </div>
  <div class="row g-4 justify-content-center">
    <div class="col-md-4"><a class="card atalho" href="produtos.php">
      <span class="emoji">🛍️</span><h4>Produtos</h4><small>cadastrar e organizar</small></a></div>
    <div class="col-md-4"><a class="card atalho" href="usuarios.php">
      <span class="emoji">👯</span><h4>Usuários</h4><small>quem pode entrar</small></a></div>
  </div>
</div>
<?php include 'includes/foot.php'; ?>
