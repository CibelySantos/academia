<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'db_academia');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Verifica se o usuário está logado
if (!isset($_SESSION['id_cliente']) || empty($_SESSION['id_cliente'])) {
    header("Location: login.php"); 
    exit();
}

$id_cliente = $_SESSION['id_cliente'];

// Consulta os agendamentos do usuário logado
$sql = "SELECT a.aula_cod, a.aula_tipo, a.aula_data, i.instrutor_nome 
        FROM aula a
        JOIN instrutores i ON a.fk_instrutor_cod = i.instrutor_cod
        WHERE a.fk_aluno_cod = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Aulas</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
</head>
<body>
    <h2>Minhas Aulas</h2>

    <table border="1">
        <thead>
            <tr>
                <th>Tipo de Treino</th>
                <th>Instrutor</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['aula_tipo']); ?></td>
                    <td><?= htmlspecialchars($row['instrutor_nome']); ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['aula_data'])); ?></td>
                    <td>
                        <!-- Formulário para editar -->
                        <form action="editar_aula.php" method="POST" style="display:inline;">
                            <input type="hidden" name="aula_cod" value="<?= $row['aula_cod']; ?>">
                            <button type="submit">Editar</button>
                        </form>

                        <!-- Botão para excluir com alerta -->
                        <button onclick="confirmarExclusao(<?= $row['aula_cod']; ?>)">Excluir</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        function confirmarExclusao(aula_cod) {
            Swal.fire({
                title: "Tem certeza?",
                text: "Você deseja excluir este agendamento?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sim, excluir!",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "excluir_aula.php?aula_cod=" + aula_cod;
                }
            });
        }
    </script>
</body>
</html>
