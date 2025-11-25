<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['nova_foto'])) {
    $arquivo = $_FILES['nova_foto'];

    if ($arquivo['error']) {
        die("Falha ao enviar arquivo. Código de erro: " . $arquivo['error']);
    }

  
    $pasta_destino = "../img/";
    

    if (!is_dir($pasta_destino)) {
        mkdir($pasta_destino, 0777, true);
    }

    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    $permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (!in_array($extensao, $permitidos)) {
        die("Apenas arquivos JPG, PNG, GIF ou WEBP são permitidos.");
    }


    $novo_nome = "user_" . $_SESSION['id_usuario'] . "_" . uniqid() . "." . $extensao;
    $caminho_completo = $pasta_destino . $novo_nome;

    if (move_uploaded_file($arquivo['tmp_name'], $caminho_completo)) {
        
        try {
 
            $stmt = $pdo->prepare("UPDATE usuarios SET foto_perfil = ? WHERE id = ?");
            $stmt->execute([$novo_nome, $_SESSION['id_usuario']]);


            if (isset($_SESSION['foto_usuario']) && !empty($_SESSION['foto_usuario'])) {
                $foto_antiga = $pasta_destino . $_SESSION['foto_usuario'];

                if (file_exists($foto_antiga) && basename($_SESSION['foto_usuario']) != 'padrao.png') {
                    unlink($foto_antiga);
                }
            }

            $_SESSION['foto_usuario'] = $novo_nome;

            header("Location: ../perfil.php");
            exit;

        } catch (PDOException $e) {
            echo "Erro ao salvar no banco: " . $e->getMessage();
        }

    } else {
        echo "Erro ao salvar o arquivo na pasta img. Verifique permissões.";
    }
} else {

    header("Location: ../perfil.php");
    exit;
}
?>