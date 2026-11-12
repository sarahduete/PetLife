<?php
// admin/criar-admin.php
require_once '../config/conexao.php';

try {
    // Apaga a tabela antiga incorreta para evitar conflitos de colunas
    $conexao->exec("DROP TABLE IF EXISTS USUARIO");

    // Cria a tabela USUARIO com todas as colunas necessárias (id_usuario, nome, email, senha)
    $conexao->exec("CREATE TABLE USUARIO (
        id_usuario INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        email TEXT UNIQUE NOT NULL,
        senha TEXT NOT NULL
    )");

    $nome = "Administrador";
    $email = "admin@petlife.com";
    $senhaPura = "123456";

    // Gera o hash seguro da senha
    $senhaHash = password_hash($senhaPura, PASSWORD_DEFAULT);

    // Insere o administrador padrão
    $insert = $conexao->prepare("INSERT INTO USUARIO (nome, email, senha) VALUES (:nome, :email, :senha)");
    $insert->execute([
        ':nome'  => $nome,
        ':email' => $email,
        ':senha' => $senhaHash
    ]);

    echo "<div style='font-family: Arial; padding: 30px; text-align: center;'>";
    echo "<h2 style='color: #2e7d32;'>Sucesso! Tabela recriada e Administrador cadastrado.</h2>";
    echo "<p><strong>E-mail:</strong> admin@petlife.com</p>";
    echo "<p><strong>Senha:</strong> 123456</p><br>";
    echo "<a href='login.php' style='padding: 12px 25px; background: #ff7a00; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;'>Ir para a Tela de Login</a>";
    echo "</div>";

} catch (PDOException $e) {
    echo "Erro ao recriar a tabela: " . $e->getMessage();
}
?>