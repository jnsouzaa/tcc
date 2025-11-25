<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_SESSION['id_usuario'];
    
    $email_digitado = trim($_POST['email_confirma']);
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];

    // VALIDAR SE TUDO FOI PREENCHIDO
    if (empty($email_digitado) || empty($senha_atual) || empty($nova_senha)) {
        header("Location: ../perfil.php?erro=Preencha todos os campos da senha.");
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT email, senha FROM usuarios WHERE id = ?");
        $stmt->execute([$id_usuario]);
        $usuario_banco = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario_banco) {
            header("Location: ../login.php");
            exit;
        }

        // VERIFICA E-MAIL
        if (strtolower($email_digitado) !== strtolower($usuario_banco['email'])) {
            header("Location: ../perfil.php?erro=O e-mail informado não confere.");
            exit;
        }

        // VERIFICA SENHA ANTIGA
        if (!password_verify($senha_atual, $usuario_banco['senha'])) {
            header("Location: ../perfil.php?erro=A senha atual está incorreta.");
            exit;
        }

        // ATUALIZA SENHA
        $nova_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
        $update->execute([$nova_hash, $id_usuario]);

        header("Location: ../perfil.php?msg=Senha alterada com sucesso!");
        exit;

    } catch (PDOException $e) {
        header("Location: ../perfil.php?erro=Erro interno no banco de dados.");
        exit;
    }

} else {
    header("Location: ../perfil.php");
    exit;
}
?>