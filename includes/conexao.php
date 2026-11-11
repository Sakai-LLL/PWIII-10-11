<?php
// Conexão PDO - ajuste usuário/senha conforme seu XAMPP
try {
    $pdo = new PDO('mysql:host=localhost;dbname=loja;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro de conexão: ' . $e->getMessage());
}
