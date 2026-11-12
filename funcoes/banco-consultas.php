<?php
// funcoes/banco-consultas.php
require_once __DIR__ . '/../config/conexao.php';

function listarConsultas($conexao) {
    $sql = "SELECT CONSULTA.*, 
                   TUTOR.nome AS nome_tutor, 
                   PET.nome AS nome_pet, 
                   VETERINARIO.nome AS nome_vet 
            FROM CONSULTA
            JOIN TUTOR ON CONSULTA.id_tutor = TUTOR.id_tutor
            JOIN PET ON CONSULTA.id_pet = PET.id_pet
            JOIN VETERINARIO ON CONSULTA.id_veterinario = VETERINARIO.id_veterinario
            ORDER BY CONSULTA.data DESC, CONSULTA.horario DESC";
    $stmt = $conexao->query($sql);
    return $stmt->fetchAll();
}

function agendarConsulta($conexao, $id_tutor, $id_pet, $id_veterinario, $data, $horario, $descricao, $observacoes, $status) {
    $sql = "INSERT INTO CONSULTA (id_tutor, id_pet, id_veterinario, data, horario, descricao, observacoes, status) 
            VALUES (:id_tutor, :id_pet, :id_veterinario, :data, :horario, :descricao, :observacoes, :status)";
    $stmt = $conexao->prepare($sql);
    return $stmt->execute([
        ':id_tutor'       => $id_tutor,
        ':id_pet'         => $id_pet,
        ':id_veterinario' => $id_veterinario,
        ':data'           => $data,
        ':horario'        => $horario,
        ':descricao'      => $descricao,
        ':observacoes'    => $observacoes,
        ':status'         => $status
    ]);
}
?>