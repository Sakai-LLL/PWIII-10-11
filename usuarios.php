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
        $erro = 'Erro ao salvar (e-mail já cadastrado?) 🥺';
    }
}

$editando = null;
if (isset($_GET['editar'])) {
    $u->setId($_GET['editar']);
    $editando = $u->buscar();
}
$lista = $u->listar();

$titulo = 'Usuários';
include 'includes/head.php';
include 'includes/navbar.php';
?>
<div class="container mt-4">
  <div class="card mb-4"><div class="card-body p-4">
    <h4 class="titulo-fofo mb-3"><?= $editando ? '✏️ Alterar usuário' : '💖 Novo usuário' ?></h4>
    <?php if ($erro): ?><div class="alert alert-danger"><?= $erro ?></div><?php endif; ?>
    <form method="post" class="row g-2">
      <input type="hidden" name="acao" value="salvar">
      <input type="hidden" name="id" value="<?= $editando['id'] ?? 0 ?>">
      <div class="col-md-3"><input name="nome" class="form-control" placeholder="Nome" required
           value="<?= htmlspecialchars($editando['nome'] ?? '') ?>"></div>
      <div class="col-md-3"><input type="email" name="email" class="form-control" placeholder="E-mail" required
           value="<?= htmlspecialchars($editando['email'] ?? '') ?>"></div>
      <div class="col-md-3"><input type="password" name="senha" class="form-control"
           placeholder="<?= $editando ? 'Nova senha (opcional)' : 'Senha' ?>" <?= $editando ? '' : 'required' ?>></div>
      <div class="col-md-3">
        <button class="btn btn-dark">Salvar ♡</button>
        <?php if ($editando): ?><a href="usuarios.php" class="btn btn-secondary">Cancelar</a><?php endif; ?>
      </div>
    </form>
  </div></div>

  <table class="table table-fofa align-middle">
    <thead><tr><th>#</th><th>Nome</th><th>E-mail</th><th class="text-end">Ações</th></tr></thead>
    <tbody>
    <?php foreach ($lista as $l): ?>
      <tr>
        <td><?= $l['id'] ?></td>
        <td>🌸 <?= htmlspecialchars($l['nome']) ?></td>
        <td><?= htmlspecialchars($l['email']) ?></td>
        <td class="text-end">
          <a class="btn btn-sm btn-outline-primary" href="?editar=<?= $l['id'] ?>">Editar</a>
          <form method="post" class="d-inline" onsubmit="return confirm('Apagar este usuário? 🥺')">
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
<?php include 'includes/foot.php'; ?>
