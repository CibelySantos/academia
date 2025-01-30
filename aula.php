<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'db_academia');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Obter instrutores
$instrutores = $mysqli->query("SELECT instrutor_cod, instrutor_nome FROM instrutores")->fetch_all(MYSQLI_ASSOC);
// Obter tipos de treino
$tipos_treino = $mysqli->query("SELECT DISTINCT aula_tipo FROM aula")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Aula</title>
</head>

<body>
    <h2>Agendamento de Aulas</h2>
    <form action="confirmar_aula.php" method="POST">
        <label for="nome">Seu Nome:</label>
        <input type="text" name="nome" required><br>

        <label for="instrutor">Escolha o Instrutor:</label>
        <select name="instrutor" required>
            <option value="">Selecione</option>
            <?php foreach ($instrutores as $instrutor) {
                echo "<option value='" . $instrutor['instrutor_cod'] . "'>" . $instrutor['instrutor_nome'] . "</option>";
            } ?>
        </select><br>

        <label for="tipo_treino">Tipo de Treino:</label>
        <select name="tipo_treino" required>
            <option value="">Selecione</option>
            <?php foreach ($tipos_treino as $treino) {
                echo "<option value='" . $treino['aula_tipo'] . "'>" . $treino['aula_tipo'] . "</option>";
            } ?>
        </select><br>

        <label for="data">Escolha a Data:</label>
        <input type="date" name="data" required><br>

        <label for="horario">Escolha o Horário:</label>
        <input type="time" name="horario" required><br>

    
        <button type="submit">Agendar</button>
        

    

    </for>
</body>

</html>