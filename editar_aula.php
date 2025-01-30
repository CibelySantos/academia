<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'db_academia');

if ($mysqli->connect_error) {
    die("Erro na conexão: " . $mysqli->connect_error);
}

if (isset($_GET['id'])) {
    $aula_id = intval($_GET['id']);

    $stmt = $mysqli->prepare("SELECT aula_tipo, aula_data FROM aula WHERE aula_cod = ?");
    $stmt->bind_param("i", $aula_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $aula = $result->fetch_assoc();
}

// Atualizar a aula após edição
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $novo_tipo = $_POST['tipo_treino'];
    $nova_data = $_POST['data'];

    $stmt = $mysqli->prepare("UPDATE aula SET aula_tipo = ?, aula_data = ? WHERE aula_cod = ?");
    $stmt->bind_param("ssi", $novo_tipo, $nova_data, $aula_id);
    
    if ($stmt->execute()) {
        echo "<script>
            alert('Agendamento atualizado com sucesso!');
            window.location.href = 'minhas_aulas.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Agendamento</title>
</head>
<body>
    <h2>Editar Agendamento</h2>
    <form method="POST">
        <label for="tipo_treino">Tipo de Treino:</label>
        <input type="text" name="tipo_treino" value="<?= htmlspecialchars($aula['aula_tipo']); ?>" required><br>

        <label for="data">Data e Horário:</label>
        <input type="datetime-local" name="data" value="<?= date('Y-m-d\TH:i', strtotime($aula['aula_data'])); ?>" required><br>

        <label for="horario">Horário:</label>
        <input type="time" name="horario" value="<?= date('H:i', strtotime($agendamento['aula_data'])); ?>" required><br>

        <button type="submit">Salvar</button>
        <a href="minhas_aulas.php">Cancelar</a>
    </form>
</body>
</html>
