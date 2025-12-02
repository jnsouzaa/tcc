<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'professor') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Professor</title>
</head>
<body>
    <h1>Bem-vindo ao Painel do Professor</h1>
    <p>Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</p>
    <p>Esta é a sua área restrita.</p>
    <br>
    <a href="../backend/logout.php">Sair</a>
</body>
</html>