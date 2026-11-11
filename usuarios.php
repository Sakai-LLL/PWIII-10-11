<?php
require_once 'includes/auth.php';
require_once 'includes/conexao.php';
require_once 'classes/Usuarios.class.php';

$u = new Usuarios($pdo);
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    try {
        if ($acao === 'salvar') {
            $u->setId($_POST['id'] ?? 0);
            $u->setNome($_POST['nome']);
            $u->setEmail($_POST['email']);
            $u->setSenha($_POST['senha'] ?? '');
            if ($u->getId() > 0) { $u->alterar(); } else { $u->inserir(); }
        } elseif ($acao === 'apagar') {
            $u->setId($_POST['id']);
            $u->apagar();
        }
        header('Location: usuarios.php');
        exit;
    } catch (PDOException $e) {
        $erro = 'Erro ao salvar (e-mail já cadastrado?).';
    }
}

$editando = null;
if (isset($_GET['editar'])) {
    $u->setId($_GET['editar']);
    $editando = $u->buscar();
}
$lista = $u->listar();
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Usuários</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<div class="container mt-4">
  <h4><?= $editando ? 'Alterar usuário' : 'Novo usuário' ?></h4>
  <?php if ($erro): ?><div class="alert alert-danger"><?= $erro ?></div><?php endif; ?>
  <form method="post" class="row g-2 mb-4">
    <input type="hidden" name="acao" value="salvar">
    <input type="hidden" name="id" value="<?= $editando['id'] ?? 0 ?>">
    <div class="col-md-3"><input name="nome" class="form-control" placeholder="Nome" required
         value="<?= htmlspecialchars($editando['nome'] ?? '') ?>"></div>
    <div class="col-md-3"><input type="email" name="email" class="form-control" placeholder="E-mail" required
         value="<?= htmlspecialchars($editando['email'] ?? '') ?>"></div>
    <div class="col-md-3"><input type="password" name="senha" class="form-control"
         placeholder="<?= $editando ? 'Nova senha (opcional)' : 'Senha' ?>" <?= $editando ? '' : 'required' ?>></div>
    <div class="col-md-3">
      <button class="btn btn-dark">Salvar</button>
      <?php if ($editando): ?><a href="usuarios.php" class="btn btn-secondary">Cancelar</a><?php endif; ?>
    </div>
  </form>

  <table class="table table-striped align-middle">
    <thead><tr><th>#</th><th>Nome</th><th>E-mail</th><th class="text-end">Ações</th></tr></thead>
    <tbody>
    <?php foreach ($lista as $l): ?>
      <tr>
        <td><?= $l['id'] ?></td>
        <td><?= htmlspecialchars($l['nome']) ?></td>
        <td><?= htmlspecialchars($l['email']) ?></td>
        <td class="text-end">
          <a class="btn btn-sm btn-outline-primary" href="?editar=<?= $l['id'] ?>">Editar</a>
          <form method="post" class="d-inline" onsubmit="return confirm('Apagar este usuário?')">
            <input type="hidden" name="acao" value="apagar">
            <input type="hidden" name="id" value="<?= $l['id'] ?>">
            <button class="btn btn-sm btn-outline-danger">Apagar</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
