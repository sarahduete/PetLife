<?php
// admin/veterinarios.php
require_once '../config/conexao.php';
require_once '../funcoes/banco-veterinarios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    inserirVeterinario(
        $conexao,
        $_POST['nome'],
        $_POST['crmv'],
        $_POST['especialidade'],
        $_POST['telefone'],
        $_POST['email'],
        $_POST['situacao']
    );
    header('Location: veterinarios.php');
    exit;
}

$veterinarios = listarVeterinarios($conexao);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Veterinários - Petlite</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
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
    <h1>Gestão de Veterinários</h1>

    <form action="veterinarios.php" method="POST">
        <input type="text" name="nome" placeholder="Nome Completo" required>
        <input type="text" name="crmv" placeholder="CRMV" required>
        <input type="text" name="especialidade" placeholder="Especialidade">
        <input type="text" name="telefone" placeholder="Telefone">
        <input type="email" name="email" placeholder="E-mail">
        <select name="situacao">
            <option value="Ativo">Ativo</option>
            <option value="Inativo">Inativo</option>
        </select>
        <button type="submit">Cadastrar Veterinário</button>
    </form>

    <hr>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CRMV</th>
                <th>Especialidade</th>
                <th>Situação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($veterinarios as $vet): ?>
                <tr>
                    <td><?= $vet['id_veterinario'] ?></td>
                    <td><?= htmlspecialchars($vet['nome']) ?></td>
                    <td><?= htmlspecialchars($vet['crmv']) ?></td>
                    <td><?= htmlspecialchars($vet['especialidade']) ?></td>
                    <td><?= htmlspecialchars($vet['situacao']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>