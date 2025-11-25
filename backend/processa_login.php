<?php

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

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

  
        if ($usuario && password_verify($senha_postada, $usuario['senha'])) {
            

            $_SESSION['loggedin'] = true;
            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['nome_usuario'] = $usuario['nome'];
            $_SESSION['foto_usuario'] = $usuario['foto_perfil']; 

    
            header("Location: ../index.php");
            exit;
            
        } else {
    
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