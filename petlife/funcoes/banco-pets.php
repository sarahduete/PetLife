<?php
// funcoes/banco-pets.php
require_once __DIR__ . '/../config/conexao.php';

// Busca os pets juntando o nome do tutor
function listarPets($conexao) {$sql = "SELECT PET.*, TUTOR.nome AS nome_tutor 
            FROM PET 
            JOIN TUTOR ON PET.id_tutor = TUTOR.id_tutor 
            ORDER BY PET.nome ASC";
    $stmt = $conexao->query($sql);
    return $stmt->fetchAll();
}

// Insere um novo pet com suporte a upload de foto
function inserirPet($conexao,$id_tutor, $nome,$especie, $raca,$sexo, $data_nascimento,$peso, $cor,$observacoes, $foto_url = null) {$sql = "INSERT INTO PET (id_tutor, nome, especie, raca, sexo, data_nascimento, peso, cor, observacoes, foto_url) 
            VALUES (:id_tutor, :nome, :especie, :raca, :sexo, :data_nascimento, :peso, :cor, :observacoes, :foto_url)";
    $stmt = $conexao->prepare($sql);
    return $stmt->execute([
        ':id_tutor'       => $id_tutor,
        ':nome'           => $nome,
        ':especie'        => $especie,
        ':raca'           => $raca,
        ':sexo'           => $sexo,
        ':data_nascimento'=> $data_nascimento,
        ':peso'           => $peso,
        ':cor'            => $cor,
        ':observacoes'    => $observacoes,
        ':foto_url'       => $foto_url
    ]);
}
?>