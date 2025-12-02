<?php
session_start();

// Verifica se o usuário está logado e se é do tipo correto
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'graduacao') {
    // Se não estiver logado ou não for do tipo certo, redireciona para o login
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Aluno de Graduação</title>
</head>
<body>
    <h1>Bem-vindo ao Painel do Aluno de Graduação</h1>
    <p>Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</p>
    <p>Esta é a sua área restrita.</p>
    <br>
    <a href="../backend/logout.php">Sair</a>
</body>
</html>