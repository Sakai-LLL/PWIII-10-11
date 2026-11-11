<?php
require_once 'includes/auth.php';
require_once 'includes/conexao.php';
require_once 'classes/Produto.class.php';

$p = new Produto($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    if ($acao === 'salvar') {
        $p->setId($_POST['id'] ?? 0);
        $p->setNome($_POST['nome']);
        $p->setDescricao($_POST['descricao']);
        $p->setPreco($_POST['preco']);
        if ($p->getId() > 0) { $p->alterar(); } else { $p->inserir(); }
    } elseif ($acao === 'apagar') {
        $p->setId($_POST['id']);
        $p->apagar();
    }
    header('Location: produtos.php');
    exit;
}

$editando = null;
if (isset($_GET['editar'])) {
    $p->setId($_GET['editar']);
    $editando = $p->buscar();
}
$lista = $p->listar();

$titulo = 'Produtos';
include 'includes/head.php';
include 'includes/navbar.php';
?>
<div class="container mt-4">
  <div class="card mb-4"><div class="card-body p-4">
    <h4 class="titulo-fofo mb-3"><?= $editando ? '✏️ Alterar produto' : '🍓 Novo produto' ?></h4>
    <form method="post" class="row g-2">
      <input type="hidden" name="acao" value="salvar">
      <input type="hidden" name="id" value="<?= $editando['id'] ?? 0 ?>">
      <div class="col-md-3"><input name="nome" class="form-control" placeholder="Nome" required
           value="<?= htmlspecialchars($editando['nome'] ?? '') ?>"></div>
      <div class="col-md-4"><input name="descricao" class="form-control" placeholder="Descrição"
           value="<?= htmlspecialchars($editando['descricao'] ?? '') ?>"></div>
      <div class="col-md-2"><input name="preco" class="form-control" placeholder="Preço" required
           value="<?= $editando['preco'] ?? '' ?>"></div>
      <div class="col-md-3">
        <button class="btn btn-dark">Salvar ♡</button>
        <?php if ($editando): ?><a href="produtos.php" class="btn btn-secondary">Cancelar</a><?php endif; ?>
      </div>
    </form>
  </div></div>

  <table class="table table-fofa align-middle">
    <thead><tr><th>#</th><th>Nome</th><th>Descrição</th><th>Preço</th><th class="text-end">Ações</th></tr></thead>
    <tbody>
    <?php foreach ($lista as $l): ?>
      <tr>
        <td><?= $l['id'] ?></td>
        <td>🎀 <?= htmlspecialchars($l['nome']) ?></td>
        <td><?= htmlspecialchars($l['descricao']) ?></td>
        <td>R$ <?= number_format($l['preco'], 2, ',', '.') ?></td>
        <td class="text-end">
          <a class="btn btn-sm btn-outline-primary" href="?editar=<?= $l['id'] ?>">Editar</a>
          <form method="post" class="d-inline" onsubmit="return confirm('Apagar este produto? 🥺')">
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
