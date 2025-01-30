<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'db_academia');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aula_cod = $_POST['aula_cod'];
    $instrutor = $_POST['instrutor'];
    $data = $_POST['data'];

    $sql = "UPDATE aula SET fk_instrutor_cod = ?, aula_data = ? WHERE aula_cod = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("isi", $instrutor, $data, $aula_cod);

    if ($stmt->execute()) {
        echo "<script>alert('Agendamento atualizado com sucesso!'); window.location='minhas_aulas.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar agendamento.'); window.location='minhas_aulas.php';</script>";
    }
}
?>
