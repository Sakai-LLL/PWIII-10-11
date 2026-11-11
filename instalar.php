<?php
// Rode UMA vez no navegador para criar o usuário admin. Depois, apague este arquivo.
require_once 'includes/conexao.php';
require_once 'classes/Usuarios.class.php';
$u = new Usuarios($pdo);
if (count($u->listar()) > 0) { die('Já existem usuários. Apague este arquivo.'); }
$u->setNome('Administrador');
$u->setEmail('admin@loja.com');
$u->setSenha('123456');
$u->inserir();
echo 'Admin criado: admin@loja.com / 123456 — apague o instalar.php.';
