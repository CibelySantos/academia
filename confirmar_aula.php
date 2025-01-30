<?php
session_start();


if ($_SESSION['id_cliente'] == "" && $_SESSION['usuario_sessao'] == "") {
    header("Location: ./minhas_aulas.php");
    exit();
}

// Verifica se os dados foram enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar']) && $_POST['confirmar'] === 'true') {
    // Recebe os dados do agendamento
    $nome = $_POST['nome'];
    $instrutor = $_POST['instrutor'];
    $tipo_treino = $_POST['tipo_treino'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];

    // Conectar ao banco de dados
    $mysqli = new mysqli('localhost', 'root', '', 'db_academia');
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Verifica se o horário já está agendado
    $sql = "SELECT * FROM agendamentos WHERE data = ? AND horario = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $data, $horario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Esse horário já foi reservado.";
        exit();
    }

    // Insere o agendamento no banco de dados
    $sql = "INSERT INTO agendamentos (nome, instrutor_cod, tipo_treino, data, horario) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sisss', $nome, $instrutor, $tipo_treino, $data, $horario);

    if ($stmt->execute()) {
        echo "Agendamento confirmado com sucesso!";
        // Redireciona após sucesso
        header("Location: agendamento_confirmado.php");
        exit();
    } else {
        echo "Erro ao agendar.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Agendamento</title>
</head>

<body>
    <center><h2>Confirmar Agendamento</h2></center>

    <!-- Exibe os dados do agendamento -->
    <p><strong>Nome:</strong> <?= htmlspecialchars($nome); ?></p>
    <p><strong>Instrutor:</strong> <?= htmlspecialchars($instrutor); ?></p>
    <p><strong>Tipo de Treino:</strong> <?= htmlspecialchars($tipo_treino); ?></p>
    <p><strong>Data:</strong> <?= htmlspecialchars($data); ?></p>
    <p><strong>Horário:</strong> <?= htmlspecialchars($horario); ?></p>

    <form method="POST">
        <button type="button" onclick="location.href='./minhas_aulas.php'">Confirmar Agendamento</button>
        <button type="button" onclick="location.href='./aula.php'">Cancelar</button>
    </form>
</body>

</html>
