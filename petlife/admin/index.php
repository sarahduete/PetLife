<?php
// admin/index.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'verificar.php';
require_once '../config/conexao.php';

// Busca dados para os contadores e tabela rápida
require_once '../funcoes/banco-tutores.php';
require_once '../funcoes/banco-pets.php';
require_once '../funcoes/banco-veterinarios.php';
require_once '../funcoes/banco-consultas.php';

$totalTutores = count(listarTutores($conexao));
$totalPets = count(listarPets($conexao));
$totalVeterinarios = count(listarVeterinarios($conexao));
$consultas = listarConsultas($conexao);
$totalConsultas = count($consultas);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Início - PetLife Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Estilos específicos para os widgets da dashboard */
        .dashboard-welcome {
            margin-bottom: 30px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 35px;
        }
        .stat-card {
            background: var(--color-bg-light);
            border: 1px solid var(--color-border);
            padding: 22px;
            border-radius: var(--radius-md);
            display: flex;
            flex-direction: column;
            gap: 8px;
            transition: var(--transition-fast);
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-sm);
            border-color: var(--color-orange);
        }
        .stat-card span {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--color-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-card strong {
            font-size: 2rem;
            font-family: var(--font-logo);
            color: var(--color-primary);
        }
        .quick-actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 35px;
        }
        .quick-btn {
            background-color: var(--color-primary);
            color: white;
            padding: 10px 20px;
            border-radius: var(--radius-full);
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition-fast);
        }
        .quick-btn:hover {
            background-color: var(--color-orange);
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <header>
        <div class="header-wrapper">
            <h2>🐾 PetLife Admin</h2>
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
        <!-- Boas-vindas -->
        <div class="dashboard-welcome">
            <h1>Bem-vindo ao Painel de Controle</h1>
            <p>Olá, <strong><?= htmlspecialchars($_SESSION['nome_usuario'] ?? 'Administrador') ?></strong>. Veja abaixo o resumo atualizado do sistema da clínica.</p>
        </div>

        <!-- 1. Cards de Estatísticas (KPIs) -->
        <div class="stats-grid">
            <div class="stat-card">
                <span>Total de Tutores</span>
                <strong><?= $totalTutores ?></strong>
            </div>
            <div class="stat-card">
                <span>Total de Pets</span>
                <strong><?= $totalPets ?></strong>
            </div>
            <div class="stat-card">
                <span>Veterinários</span>
                <strong><?= $totalVeterinarios ?></strong>
            </div>
            <div class="stat-card">
                <span>Consultas Registadas</span>
                <strong><?= $totalConsultas ?></strong>
            </div>
        </div>

        <!-- 2. Atalhos de Ação Rápida -->
        <div class="quick-actions">
            <a href="tutores.php" class="quick-btn">+ Novo Tutor</a>
            <a href="pets.php" class="quick-btn">+ Novo Pet</a>
            <a href="consultas.php" class="quick-btn">+ Agendar Consulta</a>
        </div>

        <hr>

        <!-- 3. Tabela Resumo das Consultas Recentes -->
        <h2>Últimas Consultas Agendadas</h2>
        <table>
            <thead>
                <tr>
                    <th>Data / Hora</th>
                    <th>Tutor</th>
                    <th>Pet</th>
                    <th>Veterinário</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($consultas)): ?>
                    <?php 
                    // Mostra apenas as 5 consultas mais recentes para não ocupar muito espaço
                    $consultasRecentes = array_slice($consultas, 0, 5);
                    foreach ($consultasRecentes as $c): 
                    ?>
                        <tr>
                            <td><?= ($c['data'] ?? '') . ' às ' . ($c['horario'] ?? '') ?></td>
                            <td><?= $c['tutor_nome'] ?? $c['nome_tutor'] ?? 'N/D' ?></td>
                            <td><?= $c['pet_nome'] ?? $c['nome_pet'] ?? 'N/D' ?></td>
                            <td><?= $c['veterinario_nome'] ?? $c['nome_veterinario'] ?? 'N/D' ?></td>
                            <td><?= $c['status'] ?? 'Agendada' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Nenhuma consulta registada no sistema.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>