<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'db_academia');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Verifica se o ID foi passado
if (!isset($_GET['id'])) {
    die("ID da aula não fornecido.");
}

$aula_id = intval($_GET['id']);

// Consulta os dados da aula para preencher o formulário
$stmt = $mysqli->prepare("SELECT aula_tipo, aula_data FROM aula WHERE aula_cod = ?");
$stmt->bind_param("i", $aula_id);
$stmt->execute();
$result = $stmt->get_result();
$aula = $result->fetch_assoc();

if (!$aula) {
    die("Aula não encontrada.");
}

// Atualizar a aula após edição
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $novo_tipo = $_POST['tipo_treino'];
    $nova_data = $_POST['data'];

    $stmt = $mysqli->prepare("UPDATE aula SET aula_tipo = ?, aula_data = ? WHERE aula_cod = ?");
    $stmt->bind_param("ssi", $novo_tipo, $nova_data, $aula_id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Aula atualizada com sucesso!');
            window.location.href = 'minhas_aulas.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Aula</title>
</head>
<body>
    <h2>Editar Aula</h2>
    <form method="POST">
        <label for="tipo_treino">Tipo de Treino:</label>
        <input type="text" name="tipo_treino" value="<?= htmlspecialchars($aula['aula_tipo']); ?>" required><br>

        <label for="data">Data e Horário:</label>
        <input type="datetime-local" name="data" value="<?= date('Y-m-d\TH:i', strtotime($aula['aula_data'])); ?>" required><br>

        <button type="submit">Salvar</button>
        <a href="minhas_aulas.php">Cancelar</a>
    </form>
</body>
</html>
