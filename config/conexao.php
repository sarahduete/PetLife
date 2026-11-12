<?php
// config/conexao.php
try {
    $caminho_banco = __DIR__ . '/../database/bdpetlife.db';

    // Cria a conexão via PDO
    $conexao = new PDO("sqlite:" . $caminho_banco);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro de conexão com o banco de dados: " . $e->getMessage());
}
?>