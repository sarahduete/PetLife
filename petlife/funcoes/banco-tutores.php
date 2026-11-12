<?php
// funcoes/banco-tutores.php
require_once __DIR__ . '/../config/conexao.php';

function listarTutores($conexao) {
    $sql = "SELECT * FROM TUTOR ORDER BY nome ASC";
    $stmt = $conexao->query($sql);
    return $stmt->fetchAll();
}

function inserirTutor($conexao, $nome, $cpf, $telefone, $email, $endereco) {
    $sql = "INSERT INTO TUTOR (nome, cpf, telefone, email, endereco, data_cadastro) 
            VALUES (:nome, :cpf, :telefone, :email, :endereco, :data_cadastro)";
    $stmt = $conexao->prepare($sql);
    return $stmt->execute([
        ':nome'          => $nome,
        ':cpf'           => $cpf,
        ':telefone'      => $telefone,
        ':email'         => $email,
        ':endereco'      => $endereco,
        ':data_cadastro' => date('Y-m-d')
    ]);
}
?>