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
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Barra de Navegação -->
<div class="navbar">
    <a href="index.php">Início</a>
    <a href="instrutores.php">Instrutores</a>
    <a href="contato.php">Contato</a>
</div>

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
<!-- Conteúdo da Página -->
<div class="content">
    <h2>Entre em Contato</h2>
    <p>Telefone: (XX) XXXX-XXXX</p>
    <p>Email: contato@saudetotal.com</p>
    <p>Endereço: Rua Exemplo, 123 - Academia Saúde Total</p>
</div>

</body>
</html>

</body>
</html>
