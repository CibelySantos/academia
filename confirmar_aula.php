<?php
session_start();

if ($_SESSION['id_cliente'] == "" && $_SESSION['usuario_sessao'] == "") {
    header("Location: ./minhas_aulas.php");
    exit();
}

// Inicializa as variáveis para evitar warnings
$nome = '';
$instrutor = '';
$tipo_treino = '';
$data = '';
$horario = '';

// Verifica se os dados foram passados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do agendamento
    $nome = $_POST['nome'] ?? '';
    $instrutor = $_POST['instrutor'] ?? '';
    $tipo_treino = $_POST['tipo_treino'] ?? '';
    $data = $_POST['data'] ?? '';
    $horario = $_POST['horario'] ?? '';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Agendamento</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
</head>
<body>
    <center><h2>Confirmar Agendamento</h2></center>

    <!-- Exibe os dados do agendamento -->
    <p><strong>Nome:</strong> <?= ($nome); ?></p>
    <p><strong>Instrutor:</strong> <?= ($instrutor); ?></p>
    <p><strong>Tipo de Treino:</strong> <?= ($tipo_treino); ?></p>
    <p><strong>Data:</strong> <?= ($data); ?></p>
    <p><strong>Horário:</strong> <?= ($horario); ?></p>

    <!-- Formulário para confirmar ou cancelar -->
    <form id="agendamentoForm" method="POST" action="confirmar_aula.php">
        <input type="hidden" name="nome" value="<?= ($nome); ?>">
        <input type="hidden" name="instrutor" value="<?= ($instrutor); ?>">
        <input type="hidden" name="tipo_treino" value="<?= ($tipo_treino); ?>">
        <input type="hidden" name="data" value="<?= ($data); ?>">
        <input type="hidden" name="horario" value="<?= ($horario); ?>">

        <button type="button" onclick="confirmarAgendamento()">Confirmar Agendamento</button>
        <button type="button" onclick="location.href='./aula.php'">Cancelar</button>
    </form>

    <script>
        function confirmarAgendamento() {
            Swal.fire({
                title: "Aula Agendada!",
                text: "Seu agendamento foi realizado com sucesso.",
                icon: "success",
                timer: 1500, // Tempo antes de redirecionar (2 segundos)
                showConfirmButton: false
            }).then(() => {
                window.location.href = "minhas_aulas.php"; // Redireciona para outra página
            });
        }
    </script>
</body>
</html>
