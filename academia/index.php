<?php
include './bd/conexao.php';
session_start();

$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome']);
    $cpf = trim($_POST['cpf']);

    if (empty($nome) || empty($cpf)) {
        $mensagem = "Por favor, preencha todos os campos.";
    } else {
        try {
            $query = "SELECT * FROM clientes WHERE nome_cliente = :nome";
            $stmt = $conexao->prepare($query);
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $usuario_logado = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($senha, $usuario_logado['cpf'])) {
                    $_SESSION['aluno_cod'] = $usuario_logado['aluno_cod'];
                    $_SESSION['usuario_sessao'] = $usuario_logado['aluno_nome'];

                    header('Location: ./paginas/pagina_inicial.php');
                    exit();  
                } else {
                    $mensagem = "CPF incorreto. Tente novamente.";
                }
            } else {
                $mensagem = "Usuário não encontrado. Verifique seu nome.";
            }
        } catch (PDOException $e) {
            $mensagem = "Erro ao conectar ao banco de dados: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planeta Pet - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Atma:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="../img/img_para_colocar_no_title-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
<header>
    <div class="logo-nav">
        <img src="./img/logo_pet-removebg-preview.png" alt="Logo Planeta Pet">
        <span id="site">saude total</span>
    </div>
</header>

    <div class="login">
        <img src="./img/logo_pet-removebg-preview.png" alt="Logo do Planeta Pet" class="logo">
        <h1>saude total</h1>

        <form action="" method="POST">
            <?php if (!empty($mensagem)): ?>
                <div class="error-message"><?= htmlspecialchars($mensagem); ?></div>
            <?php endif; ?>

            <label for="nome">Nome:</label>
            <input name="nome" type="text" required placeholder="Digite seu nome">

            <label for="cpf">CPF:</label>
            <input name="senha" type="password" required placeholder="Digite seu CPF">

            <button type="submit">Entrar</button>

            <p class="register-link">
                Não possui uma conta? <a href="./paginas/cadastro.php">Cadastre-se</a>
            </p>
        </form>
    </div>
</body>
</html>
