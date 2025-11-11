<?php
// backend/processa_cadastro.php

// 1. Inclui o arquivo de conexão
require_once '../config/db.php';

// 2. Verifica se os dados vieram por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Pega os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];

    // Validação básica (apenas para exemplo)
    if (empty($nome) || empty($email) || empty($senha)) {
        // Redireciona de volta com um erro
        header("Location: ../cadastro.php?erro=Campos obrigatórios não preenchidos");
        exit;
    }

    // 4. Criptografa a senha (NUNCA guarde senhas em texto puro!)
    $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

    try {
        // 5. Verifica se o e-mail já existe
        $stmt_check = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt_check->execute([$email]);
        
        if ($stmt_check->rowCount() > 0) {
            // E-mail já cadastrado
            header("Location: ../cadastro.php?erro=Este e-mail já está cadastrado.");
            exit;
        }

        // 6. Insere o novo usuário no banco (usando prepared statements contra SQL Injection)
        $stmt_insert = $pdo->prepare("INSERT INTO usuarios (nome, email, telefone, senha) VALUES (?, ?, ?, ?)");
        $stmt_insert->execute([$nome, $email, $telefone, $senha_hash]);

        // 7. Redireciona para o login com sucesso
        header("Location: ../login.php?sucesso=Cadastro realizado! Faça o login.");
        exit;

    } catch (PDOException $e) {
        // Redireciona com um erro genérico
        header("Location: ../cadastro.php?erro=Erro no banco de dados: " . $e->getMessage());
        exit;
    }
} else {
    // Se alguém tentar acessar o script diretamente
    header("Location: ../cadastro.php");
    exit;
}
?>