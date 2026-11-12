<?php
// admin/usuarios.php
require_once 'verificar.php';
require_once '../config/conexao.php';
require_once '../funcoes/banco-usuarios.php';

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (!empty($nome) && !empty($email) && !empty($senha)) {
        try {
            inserirUsuario($conexao, $nome, $email, $senha);
            $sucesso = "Utilizador cadastrado com sucesso!";
        } catch (PDOException $e) {
            $erro = "Erro ao cadastrar: Este e-mail já pode estar em uso.";
        }
    } else {
        $erro = "Preencha todos os campos.";
    }
}

if (isset($_GET['excluir'])) {
    $id = (int)$_GET['excluir'];
    // Evita que o admin exclua a própria conta ativa no momento
    if ($id !== $_SESSION['id_usuario']) {
        excluirUsuario($conexao, $id);
        header('Location: usuarios.php');
        exit;
    } else {
        $erro = "Não pode excluir a sua própria conta ativa.";
    }
}

$usuarios = listarUsuarios($conexao);


?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Utilizadores - PetLife</title>
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
        <h1>Gestão de Utilizadores do Sistema</h1>

        <?php if ($erro): ?>
            <div style="background-color: #ffebee; color: #c62828; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 14px;"><?= $erro ?></div>
        <?php endif; ?>

        <?php if ($sucesso): ?>
            <div style="background-color: #e8f5e9; color: #2e7d32; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 14px;"><?= $sucesso ?></div>
        <?php endif; ?>

        <form action="usuarios.php" method="POST">
            <input type="text" name="nome" placeholder="Nome do Utilizador" required>
            <input type="email" name="email" placeholder="E-mail de Acesso" required>
            <input type="password" name="senha" placeholder="Senha de Acesso" required>
            <button type="submit">Cadastrar Novo Utilizador</button>
        </form>

        <hr>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= $u['id_usuario'] ?></td>
                        <td><?= htmlspecialchars($u['nome']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <?php if ($u['id_usuario'] != $_SESSION['id_usuario']): ?>
                                <a href="usuarios.php?excluir=<?= $u['id_usuario'] ?>" onclick="return confirm('Tem certeza que deseja excluir este utilizador?')" style="color: #c62828; text-decoration: none; font-weight: 600;">Excluir</a>
                            <?php else: ?>
                                <span style="color: var(--text-muted); font-size: 13px;">(A sua conta)</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>