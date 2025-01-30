<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_academia";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instrutores Cadastrados</title>
    <link rel="stylesheet" href="./css/instrutor.css">
</head>
<body>

<!-- Barra de Navegação -->
<nav class="navbar">
    <a href="index.php"><img src="./img/logo_academia_nav.png" alt=""></a>
    <a href="aluno.php">Aluno</a>
    <a href="instrutor.php">Instrutor</a>
    <a href="aula.php">Agendar aula</a>
</nav>

<h2>Instrutores Cadastrados</h2>

<?php
// Consulta os instrutores
$sql = "SELECT instrutor_nome, instrutor_especialidade FROM instrutores";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>Nome</th><th>Especialidade</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . htmlspecialchars($row["instrutor_nome"]) . "</td><td>" . htmlspecialchars($row["instrutor_especialidade"]) . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nenhum instrutor encontrado.</p>";
}

$conn->close();
?>

<!-- Rodapé -->
<footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> Academia Saúde Total. Todos os direitos reservados.</p>
</footer>

</body>
</html>
