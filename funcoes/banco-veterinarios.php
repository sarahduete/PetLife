<?php

// funcoes/banco-veterinarios.php
require_once __DIR__ . '/../config/conexao.php';

function listarVeterinarios($conexao) {
    $sql = "SELECT * FROM VETERINARIO ORDER BY nome ASC";
    $stmt = $conexao->query($sql);
    return $stmt->fetchAll();
}

function inserirVeterinario($conexao, $nome, $crmv, $especialidade, $telefone, $email, $situacao) {
    $sql = "INSERT INTO VETERINARIO (nome, crmv, especialidade, telefone, email, situacao) 
            VALUES (:nome, :crmv, :especialidade, :telefone, :email, :situacao)";
    $stmt = $conexao->prepare($sql);
    return $stmt->execute([
        ':nome'          => $nome,
        ':crmv'          => $crmv,
        ':especialidade' => $especialidade,
        ':telefone'      => $telefone,
        ':email'         => $email,
        ':situacao'      => $situacao
    ]);
}
?>