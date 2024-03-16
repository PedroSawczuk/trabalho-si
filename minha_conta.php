<?php
// Arquivo: minha_conta.php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: conta/login.php"); // Redirecionar para a página de login se não estiver logado
    exit();
}

// Incluir o arquivo de conexão
include('dados/conexao.php');

// Obter dados do usuário logado
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM usuarios WHERE id = $usuario_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Exibir os dados do usuário
    $row = $result->fetch_assoc();
} else {
    echo "Usuário não encontrado.";
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Minha Conta</title>
    <!-- Adicione o link para o arquivo CSS do Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <button><a href="index.php" class="btn btn-primary">Voltar</a></button>
    <div class="container mt-5">
        <h2>Informações da Conta</h2>
        <div class="card">
            <div class="card-body">
                <?php
                echo "<p><strong>Usuário:</strong> " . $row['username'] . "</p>";
                echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
                echo "<p><strong>Permissão:</strong> " . $row['permissao'] . "</p>";
                echo "<p><strong>Data de Criação:</strong> " . $row['data_cadastro'] . "</p>";
                ?>
            </div>
        </div>
    </div>

    <!-- Adicione o link para o arquivo JS do Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
