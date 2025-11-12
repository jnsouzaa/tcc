<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login.php?erro=Sessao expirada.");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_usuario = $_SESSION['id_usuario'];
    $id_curso = $_POST['id_curso'];
    
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $cep = $_POST['cep'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $nome_resp_1 = $_POST['nome_responsavel_1'];
    $tel_resp_1 = $_POST['telefone_responsavel_1'];
    $nome_resp_2 = $_POST['nome_responsavel_2'];
    $tel_resp_2 = $_POST['telefone_responsavel_2'];

    try {
        $pdo->beginTransaction();
        
        $sql_update_usuario = "UPDATE usuarios SET 
            nome = ?, email = ?, telefone = ?, endereco = ?, 
            cep = ?, cpf = ?, data_nascimento = ?, nome_responsavel_1 = ?, 
            telefone_responsavel_1 = ?, nome_responsavel_2 = ?, telefone_responsavel_2 = ?
            WHERE id = ?";
        
        $stmt_update = $pdo->prepare($sql_update_usuario);
        $stmt_update->execute([
            $nome, $email, $telefone, $endereco, $cep, $cpf, 
            $data_nascimento, $nome_resp_1, $tel_resp_1, 
            $nome_resp_2, $tel_resp_2, $id_usuario
        ]);

        $stmt_check = $pdo->prepare("SELECT * FROM inscricoes WHERE id_usuario = ? AND id_curso = ?");
        $stmt_check->execute([$id_usuario, $id_curso]);
        
        if ($stmt_check->rowCount() == 0) {
            $stmt_insert = $pdo->prepare("INSERT INTO inscricoes (id_usuario, id_curso) VALUES (?, ?)");
            $stmt_insert->execute([$id_usuario, $id_curso]);
        }

        $pdo->commit();
        
        $_SESSION['nome_usuario'] = $nome;

        header("Location: ../index.php?sucesso=Inscricao realizada com sucesso!");
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        header("Location: ../inscricao.php?id=$id_curso&erro=Erro ao salvar dados: " . $e->getMessage());
        exit;
    }

} else {
    header("Location: ../index.php");
    exit;
}
?>