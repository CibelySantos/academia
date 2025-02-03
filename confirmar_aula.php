<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'db_academia');

if ($mysqli->connect_error) {
    die("Erro na conexão: " . $mysqli->connect_error);
}

// Verifica se o usuário está autenticado
if (empty($_SESSION['id_cliente']) || empty($_SESSION['usuario_sessao'])) {
    header("Location: ./minhas_aulas.php");
    exit();
}

// Inicializa as variáveis
$nome = $instrutor = $tipo_treino = $especialidade = $data = $horario = '';

// Verifica se os dados foram passados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $instrutor_cod = $_POST['instrutor'] ?? '';
    $tipo_treino = $_POST['tipo_treino'] ?? '';
    $data = $_POST['data'] ?? '';
    $horario = $_POST['horario'] ?? '';

    // Buscar o nome e especialidade do instrutor
    $query = $mysqli->prepare("SELECT instrutor_nome, instrutor_especialidade FROM instrutores WHERE instrutor_cod = ?");
    $query->bind_param("i", $instrutor_cod);
    $query->execute();
    $result = $query->get_result();
    if ($row = $result->fetch_assoc()) {
        $instrutor = $row['instrutor_nome'];
        $especialidade = $row['instrutor_especialidade']; // Obtendo a especialidade
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Agendamento</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <center><h2>Confirmar Agendamento</h2></center>

    <p><strong>Nome:</strong> <?= htmlspecialchars($nome); ?></p>
    <p><strong>Instrutor:</strong> <?= htmlspecialchars($instrutor); ?></p>
    <p><strong>Especialidade do Instrutor:</strong> <?= htmlspecialchars($especialidade); ?></p> <!-- Adicionando especialidade -->
    <p><strong>Data:</strong> <?= htmlspecialchars($data); ?></p>
    <p><strong>Horário:</strong> <?= htmlspecialchars($horario); ?></p>

    <form id="agendamentoForm" method="POST" action="minhas_aulas.php">
        <input type="hidden" name="nome" value="<?= htmlspecialchars($nome); ?>">
        <input type="hidden" name="instrutor" value="<?= htmlspecialchars($instrutor_cod); ?>">
        <input type="hidden" name="tipo_treino" value="<?= htmlspecialchars($tipo_treino); ?>">
        <input type="hidden" name="data" value="<?= htmlspecialchars($data); ?>">
        <input type="hidden" name="horario" value="<?= htmlspecialchars($horario); ?>">

        <button type="submit">Confirmar Agendamento</button>
        <button type="button" onclick="location.href='./aula.php'">Cancelar</button>
    </form>

    <script>
        document.getElementById("agendamentoForm").addEventListener("submit", function(event) {
            event.preventDefault();
            var form = this;

            Swal.fire({
                title: "Aula Agendada!",
                text: "Seu agendamento foi realizado com sucesso.",
                icon: "success",
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                form.submit(); // Somente após o alerta, o formulário é enviado
            });
        });
    </script>
</body>
</html>
