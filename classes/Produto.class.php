<?php
class Produto
{
    private $pdo;
    private $id;
    private $nome;
    private $descricao;
    private $preco;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = (int)$id; }
    public function getNome() { return $this->nome; }
    public function setNome($nome) { $this->nome = trim($nome); }
    public function getDescricao() { return $this->descricao; }
    public function setDescricao($d) { $this->descricao = trim($d); }
    public function getPreco() { return $this->preco; }
    public function setPreco($p) { $this->preco = (float)str_replace(',', '.', $p); }

    public function inserir()
    {
        $st = $this->pdo->prepare("INSERT INTO produtos (nome, descricao, preco) VALUES (:nome, :descricao, :preco)");
        $st->bindValue(':nome', $this->nome);
        $st->bindValue(':descricao', $this->descricao);
        $st->bindValue(':preco', $this->preco);
        return $st->execute();
    }

    public function alterar()
    {
        $st = $this->pdo->prepare("UPDATE produtos SET nome=:nome, descricao=:descricao, preco=:preco WHERE id=:id");
        $st->bindValue(':nome', $this->nome);
        $st->bindValue(':descricao', $this->descricao);
        $st->bindValue(':preco', $this->preco);
        $st->bindValue(':id', $this->id);
        return $st->execute();
    }

    public function apagar()
    {
        $st = $this->pdo->prepare("DELETE FROM produtos WHERE id=:id");
        $st->bindValue(':id', $this->id);
        return $st->execute();
    }

    public function listar()
    {
        return $this->pdo->query("SELECT * FROM produtos ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar()
    {
        $st = $this->pdo->prepare("SELECT * FROM produtos WHERE id=:id");
        $st->bindValue(':id', $this->id);
        $st->execute();
        return $st->fetch(PDO::FETCH_ASSOC);
    }
}
