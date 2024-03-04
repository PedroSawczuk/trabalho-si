<?php
// conta/criar_conta.php
session_start();

// Inclua o arquivo de conexão
include '../dados/conexao.php';

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Processar os dados do formulário quando o formulário for enviado

        // Validar e escapar os dados recebidos do formulário (para evitar injeção de SQL)
        $username = htmlspecialchars($_POST["username"]);
        $email = htmlspecialchars($_POST["email"]);
        $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT); // Criptografar a senha antes de armazená-la no banco de dados

        // Definir a permissão como "cliente"
        $permissao = "cliente";

        // Inserir os dados no banco de dados, incluindo a permissão
        $stmt = $conn->prepare("INSERT INTO usuarios (username, email, senha, permissao) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $senha, $permissao);
        
        // Execute a consulta preparada
        if ($stmt->execute()) {
            // Conta criada com sucesso, redirecionar para login.php
            header("Location: login.php");
            exit();
        } else {
            echo "Erro ao criar a conta: " . $stmt->error;
        }
        
        // Fechar a declaração preparada
        $stmt->close();
    }
} catch (Exception $e) {
    echo "Erro ao processar a requisição: " . $e->getMessage();
} finally {
    // A conexão será fechada automaticamente no final do script ou se ocorrer alguma exceção
    if ($conn && $conn->ping()) {
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<!-- Restante do seu código HTML permanece o mesmo -->


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta</title>

    <!-- Adicione o link para os estilos do Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Criar Conta</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="needs-validation" novalidate>
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" name="username" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" name="email" required>
    </div>

    <div class="form-group">
        <label for="senha">Senha:</label>
        <input type="password" class="form-control" name="senha" required>
    </div>

    <button type="submit" class="btn btn-primary">Criar Conta</button>
</form>

<!-- Adicione o link para os scripts do Bootstrap (JQuery e Popper.js) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
