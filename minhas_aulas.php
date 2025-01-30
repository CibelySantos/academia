<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'db_academia');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Consulta todas as aulas agendadas, incluindo instrutor e aluno
$sql = "SELECT a.aula_cod, a.aula_tipo, a.aula_data, i.instrutor_nome, al.aluno_nome 
        FROM aula a
        JOIN instrutores i ON a.fk_instrutor_cod = i.instrutor_cod
        JOIN aluno al ON a.fk_aluno_cod = al.aluno_cod";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minhas Aulas</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <h2>Minhas Aulas</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Tipo de Aula</th>
                <th>Data</th>
                <th>Instrutor</th>
                <th>Aluno</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['aula_tipo']); ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['aula_data'])); ?></td>
                    <td><?= htmlspecialchars($row['instrutor_nome']); ?></td>
                    <td><?= htmlspecialchars($row['aluno_nome']); ?></td>
                    <td>
                        <a href="editar_aula.php?id=<?= $row['aula_cod']; ?>">
                            <button>Editar</button>
                        </a>
                        <button onclick="confirmarExclusao(<?= $row['aula_cod']; ?>)">Excluir</button>
                        <form id="formExcluir<?= $row['aula_cod']; ?>" action="excluir_aula.php" method="POST" style="display:none;">
                            <input type="hidden" name="aula_cod" value="<?= $row['aula_cod']; ?>">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        function confirmarExclusao(aula_cod) {
            Swal.fire({
                title: "Tem certeza?",
                text: "Deseja excluir esta aula?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sim, excluir!",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("formExcluir" + aula_cod).submit();
                }
            });
        }
    </script>
</body>
</html>
