<?php
// funcoes/banco-usuarios.php

function listarUsuarios($conexao) {
    $sql = "SELECT id_usuario, nome, email FROM USUARIO ORDER BY nome ASC";
    $stmt = $conexao->query($sql);
    return $stmt->fetchAll();
}

function inserirUsuario($conexao, $nome, $email, $senha) {
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "INSERT INTO USUARIO (nome, email, senha) VALUES (:nome, :email, :senha)";
    $stmt = $conexao->prepare($sql);
    return $stmt->execute([
        ':nome'  => $nome,
        ':email' => $email,
        ':senha' => $senhaHash
    ]);
}

function excluirUsuario($conexao, $id_usuario) {
    $sql = "DELETE FROM USUARIO WHERE id_usuario = :id_usuario";
    $stmt = $conexao->prepare($sql);
    return $stmt->execute([':id_usuario' => $id_usuario]);
}
?>