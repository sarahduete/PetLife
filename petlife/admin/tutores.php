<?php
// admin/tutores.php
require_once '../funcoes/banco-tutores.php';

// Processa o formulário de cadastro caso seja enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    inserirTutor(
        $conexao, 
        $_POST['nome'], 
        $_POST['cpf'], 
        $_POST['telefone'], 
        $_POST['email'], 
        $_POST['endereco']
    );
    header('Location: tutores.php');
    exit;
}

$tutores = listarTutores($conexao);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Tutores - Petlite</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
      <!-- Cabeçalho e Menu de Navegação Unificado -->
    <header>
    <div class="header-wrapper">
        <h2>🐾 PetLife - Painel de Gestão</h2>
        <nav>
            <ul>
                <li><a href="index.php">Início</a></li>
                <li><a href="tutores.php">Tutores</a></li>
                <li><a href="pets.php">Pets</a></li>
                <li><a href="veterinarios.php">Veterinários</a></li>
                <li><a href="consultas.php">Consultas</a></li>
                <li><a href="usuarios.php">Utilizadores</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </div>
</header>
<div class="container">
    <h1>Gestão de Tutores</h1>

    <!-- Formulário de Cadastro -->
    <form action="tutores.php" method="POST">
        <input type="text" name="nome" placeholder="Nome completo" required>
        <input type="text" name="cpf" placeholder="CPF" required>
        <input type="text" name="telefone" placeholder="Telefone">
        <input type="email" name="email" placeholder="E-mail">
        <input type="text" name="endereco" placeholder="Endereço">
        <button type="submit">Cadastrar Tutor</button>
    </form>

    <hr>

    <!-- Tabela de Listagem -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>E-mail</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tutores as $tutor): ?>
                <tr>
                    <td><?= $tutor['id_tutor'] ?></td>
                    <td><?= htmlspecialchars($tutor['nome']) ?></td>
                    <td><?= htmlspecialchars($tutor['cpf']) ?></td>
                    <td><?= htmlspecialchars($tutor['telefone']) ?></td>
                    <td><?= htmlspecialchars($tutor['email']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
     </table>
    </div>
</body>
</html>


