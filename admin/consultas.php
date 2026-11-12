<?php
// admin/consultas.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'verificar.php';
require_once '../config/conexao.php';
require_once '../funcoes/banco-consultas.php';
require_once '../funcoes/banco-tutores.php';
require_once '../funcoes/banco-pets.php';
require_once '../funcoes/banco-veterinarios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    agendarConsulta(
        $conexao,
        $_POST['id_tutor'] ?? '',
        $_POST['id_pet'] ?? '',
        $_POST['id_veterinario'] ?? '',
        $_POST['data'] ?? '',
        $_POST['horario'] ?? '',
        $_POST['descricao'] ?? '',
        $_POST['observacoes'] ?? '',
        $_POST['status'] ?? 'Agendada'
    );
    header('Location: consultas.php');
    exit;
}

$consultas = function_exists('listarConsultas') ? listarConsultas($conexao) : [];
$tutores = function_exists('listarTutores') ? listarTutores($conexao) : [];
$pets = function_exists('listarPets') ? listarPets($conexao) : [];
$veterinarios = function_exists('listarVeterinarios') ? listarVeterinarios($conexao) : [];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Consultas - PetLife Admin</title>
    <link rel="stylesheet" href="../css/style.css">
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
        <h1>Gestão de Consultas</h1>
        <p>Preencha os dados abaixo para agendar uma nova consulta na clínica.</p>

        <form action="consultas.php" method="POST">
            <div>
                <label for="id_tutor">Tutor:</label>
                <select name="id_tutor" id="id_tutor" required>
                    <option value="">Selecione o tutor</option>
                    <?php foreach ($tutores as $tutor): ?>
                        <option value="<?= $tutor['id_tutor'] ?? $tutor['id'] ?>"><?= $tutor['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="id_pet">Pet:</label>
                <select name="id_pet" id="id_pet" required>
                    <option value="">Selecione o pet</option>
                    <?php foreach ($pets as $pet): ?>
                        <option value="<?= $pet['id_pet'] ?? $pet['id'] ?>"><?= $pet['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="id_veterinario">Veterinário:</label>
                <select name="id_veterinario" id="id_veterinario" required>
                    <option value="">Selecione o veterinário</option>
                    <?php foreach ($veterinarios as $vet): ?>
                        <option value="<?= $vet['id_veterinario'] ?? $vet['id'] ?>"><?= $vet['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="data">Data:</label>
                <input type="date" name="data" id="data" required>
            </div>

            <div>
                <label for="horario">Horário:</label>
                <input type="time" name="horario" id="horario" required>
            </div>

            <div>
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="Agendada">Agendada</option>
                    <option value="Realizada">Realizada</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
            </div>

            <div style="grid-column: 1 / -1;">
                <label for="descricao">Descrição / Motivo:</label>
                <input type="text" name="descricao" id="descricao" placeholder="Ex: Vacinação anual, consulta de rotina...">
            </div>

            <div style="grid-column: 1 / -1;">
                <label for="observacoes">Observações:</label>
                <textarea name="observacoes" id="observacoes" rows="3" placeholder="Observações adicionais..."></textarea>
            </div>

            <button type="submit">Agendar Consulta</button>
        </form>

        <hr>

        <h2>Consultas Registradas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data / Hora</th>
                    <th>Tutor</th>
                    <th>Pet</th>
                    <th>Veterinário</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($consultas)): ?>
                    <?php foreach ($consultas as $c): ?>
                        <tr>
                            <td><?= $c['id_consulta'] ?? $c['id'] ?? '' ?></td>
                            <td><?= ($c['data'] ?? '') . ' às ' . ($c['horario'] ?? '') ?></td>
                            <td><?= $c['tutor_nome'] ?? $c['nome_tutor'] ?? 'N/D' ?></td>
                            <td><?= $c['pet_nome'] ?? $c['nome_pet'] ?? 'N/D' ?></td>
                            <td><?= $c['veterinario_nome'] ?? $c['nome_veterinario'] ?? 'N/D' ?></td>
                            <td><?= $c['status'] ?? 'Agendada' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Nenhuma consulta agendada até o momento.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>