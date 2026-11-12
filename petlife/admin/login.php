<?php
// admin/login.php
session_start();
require_once '../config/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senhaInformada = trim($_POST['senha']);

    if (!empty($email) && !empty($senhaInformada)) {
        // Busca o utilizador pelo e-mail
        $stmt = $conexao->prepare("SELECT * FROM USUARIO WHERE email = :email and senha = :senha");
        $stmt->execute([':email' => $email, ':senha' => $senhaInformada]);
        $usuario = $stmt->fetch();

      

        if ($usuario) {
            // Descobre qual é o nome exato da coluna de senha na base de dados
                $_SESSION['id_usuario'] = $usuario['id_usuario'] ?? $usuario['id'] ?? 1;
                $_SESSION['nome_usuario'] = $usuario['nome'] ?? 'Administrador';
                header('Location: index.php');
                exit;
        
            } else {
                $erro = 'E-mail ou senha incorretos.';
            }
        
    
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login - PetLife Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: var(--bg-light);
            margin: 0;
        }
        .login-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(15, 41, 66, 0.08);
            width: 100%;
            max-width: 380px;
            border: 1px solid var(--border-color);
        }
        .login-card h2 {
            color: var(--primary-blue);
            margin-bottom: 25px;
            text-align: center;
        }
        .login-card form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            background: none;
            border: none;
            padding: 0;
        }
        .erro-msg {
            background-color: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 6px;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>🐾 PetLife Admin</h2>
        
        <?php if ($erro): ?>
            <div class="erro-msg"><?= $erro ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="E-mail de acesso" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar no Sistema</button>
        </form>
    </div>
</body>
</html>