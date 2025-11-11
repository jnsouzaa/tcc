<?php
// backend/processa_login.php

// Inicia a sessão
session_start();

require_once '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha_postada = $_POST['senha'];

    if (empty($email) || empty($senha_postada)) {
        header("Location: ../login.php?erro=Preencha e-mail e senha.");
        exit;
    }

    try {
        // 1. Busca o usuário pelo e-mail
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. Verifica se o usuário existe E se a senha está correta
        if ($usuario && password_verify($senha_postada, $usuario['senha'])) {
            
            // 3. Senha correta! Salva os dados na sessão
            $_SESSION['loggedin'] = true;
            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['nome_usuario'] = $usuario['nome']; // Para o "Olá, [Nome]"

            // 4. Redireciona para a página principal (agora index.php)
            header("Location: ../index.php");
            exit;
            
        } else {
            // Usuário ou senha incorretos
            header("Location: ../login.php?erro=E-mail ou senha inválidos.");
            exit;
        }

    } catch (PDOException $e) {
        header("Location: ../login.php?erro=Erro no banco de dados.");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>