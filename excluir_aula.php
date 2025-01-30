<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'db_academia');

if ($mysqli->connect_error) {
    die("Erro de conexão: " . $mysqli->connect_error);
}

// Verifica se o ID foi passado pelo formulário
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['aula_cod'])) {
    $aula_id = intval($_POST['aula_cod']);

    // Verifica se a aula existe antes de excluir
    $stmt = $mysqli->prepare("SELECT aula_cod FROM aula WHERE aula_cod = ?");
    $stmt->bind_param("i", $aula_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo "<script>
            alert('Erro: Aula não encontrada.');
            window.location.href = 'minhas_aulas.php';
        </script>";
        exit;
    }

    // Agora podemos excluir com segurança
    $stmt = $mysqli->prepare("DELETE FROM aula WHERE aula_cod = ?");
    $stmt->bind_param("i", $aula_id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Aula excluída com sucesso!');
            window.location.href = 'minhas_aulas.php';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao excluir a aula.');
            window.location.href = 'minhas_aulas.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Requisição inválida.');
        window.location.href = 'minhas_aulas.php';
    </script>";
}
?>
