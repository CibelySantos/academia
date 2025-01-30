<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'db_academia');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Verifica se recebeu um ID válido
if (isset($_GET['aula_cod']) && !empty($_GET['aula_cod'])) {
    $aula_cod = $_GET['aula_cod'];

    // Exclui o agendamento
    $sql = "DELETE FROM aula WHERE aula_cod = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $aula_cod);

    if ($stmt->execute()) {
        echo "<script>
            alert('Agendamento excluído com sucesso!');
            window.location.href = 'minhas_aulas.php';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao excluir o agendamento.');
            window.location.href = 'minhas_aulas.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Agendamento não encontrado.');
        window.location.href = 'minhas_aulas.php';
    </script>";
}
?>
