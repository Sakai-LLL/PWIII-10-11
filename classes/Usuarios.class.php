<?php
class Usuarios
{
    private $pdo;
    private $id;
    private $nome;
    private $email;
    private $senha;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // getters e setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = (int)$id; }
    public function getNome() { return $this->nome; }
    public function setNome($nome) { $this->nome = trim($nome); }
    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = trim($email); }
    public function getSenha() { return $this->senha; }
    public function setSenha($senha) { $this->senha = $senha; }

    public function inserir()
    {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(':nome', $this->nome);
        $st->bindValue(':email', $this->email);
        $st->bindValue(':senha', password_hash($this->senha, PASSWORD_DEFAULT));
        return $st->execute();
    }

    public function alterar()
    {
        $trocaSenha = ($this->senha !== '' && $this->senha !== null);
        if ($trocaSenha) {
            $sql = "UPDATE usuarios SET nome=:nome, email=:email, senha=:senha WHERE id=:id";
        } else {
            $sql = "UPDATE usuarios SET nome=:nome, email=:email WHERE id=:id";
        }
        $st = $this->pdo->prepare($sql);
        $st->bindValue(':nome', $this->nome);
        $st->bindValue(':email', $this->email);
        $st->bindValue(':id', $this->id);
        if ($trocaSenha) {
            $st->bindValue(':senha', password_hash($this->senha, PASSWORD_DEFAULT));
        }
        return $st->execute();
    }

    public function apagar()
    {
        $st = $this->pdo->prepare("DELETE FROM usuarios WHERE id=:id");
        $st->bindValue(':id', $this->id);
        return $st->execute();
    }

    public function listar()
    {
        return $this->pdo->query("SELECT id, nome, email FROM usuarios ORDER BY nome")
                         ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar()
    {
        $st = $this->pdo->prepare("SELECT id, nome, email FROM usuarios WHERE id=:id");
        $st->bindValue(':id', $this->id);
        $st->execute();
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    // retorna o usuário se email/senha estiverem corretos, senão false
    public function login()
    {
        $st = $this->pdo->prepare("SELECT * FROM usuarios WHERE email=:email");
        $st->bindValue(':email', $this->email);
        $st->execute();
        $u = $st->fetch(PDO::FETCH_ASSOC);
        if ($u && password_verify($this->senha, $u['senha'])) {
            return $u;
        }
        return false;
    }
}
