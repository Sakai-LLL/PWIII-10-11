<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="principal.php">Loja Fofinha</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="produtos.php">Produtos</a></li>
        <li class="nav-item"><a class="nav-link" href="usuarios.php">Usuários</a></li>
      </ul>
      <span class="navbar-text me-3">Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?></span>
      <a class="btn btn-outline-light btn-sm" href="logout.php">Sair</a>
    </div>
  </div>
</nav>
