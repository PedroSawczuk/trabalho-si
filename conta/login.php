<?php
session_start();

// Adicione o código para a conexão com o banco de dados aqui (usando o arquivo de conexão)
include '../dados/conexao.php';

$erro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processar os dados do formulário quando o formulário for enviado

    // Validar e escapar os dados recebidos do formulário (para evitar injeção de SQL)
    $usuario = htmlspecialchars($_POST["usuario"]);
    $senha = htmlspecialchars($_POST["senha"]);

    // Verificar se o usuário está no banco de dados
    $sql = "SELECT * FROM usuarios WHERE username='$usuario' OR email='$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($senha, $row["senha"])) {
            // Login bem-sucedido, configurar a sessão e redirecionar para a página principal
            $_SESSION['usuario_id'] = $row['id'];
            header("Location: ../index.php");
            exit();
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "Usuário não encontrado.";
    }
}

// Lembre-se de fechar a conexão com o banco de dados quando não for mais necessária
// $conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Adicione o link para os estilos do Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

<h2>Login</h2>

<?php if ($erro !== '') : ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $erro; ?>
    </div>
<?php endif; ?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="needs-validation" novalidate>
    <div class="form-group">
        <label for="usuario">Username ou Email:</label>
        <input type="text" class="form-control" name="usuario" required>
    </div>

    <div class="form-group">
        <label for="senha">Senha:</label>
        <input type="password" class="form-control" name="senha" required>
    </div>

    <button type="submit" class="btn btn-primary">Entrar</button>

    <p>Não tem conta?<a href="criar_conta.php">Crie Aqui</a></p>
</form>

<!-- Adicione o link para os scripts do Bootstrap (JQuery e Popper.js) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
