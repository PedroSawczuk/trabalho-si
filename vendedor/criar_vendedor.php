<?php
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: conta/login.php");
    exit();
}

// Incluir o arquivo de conexão
include '../dados/conexao.php';

// Verificar se o usuário já é um vendedor
$usuario_id = $_SESSION['usuario_id'];
$consultaVendedor = "SELECT * FROM vendedores WHERE usuario_id = $usuario_id";
$resultadoVendedor = $conn->query($consultaVendedor);

// Se o usuário já for um vendedor, redirecione
if ($resultadoVendedor->num_rows > 0) {
    header("Location: ja_tem_loja.php"); // Altere para o local desejado
    exit();
}

// Processar os dados do formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar e escapar os dados recebidos do formulário
    $nomeLoja = htmlspecialchars($_POST["nome_loja"]);
    $categorias = htmlspecialchars($_POST["categorias"]);

    // Inserir os dados na tabela vendedores
    $sqlInserirVendedor = "INSERT INTO vendedores (usuario_id, nome_loja, categorias) VALUES (?, ?, ?)";
    $stmtInserirVendedor = $conn->prepare($sqlInserirVendedor);
    $stmtInserirVendedor->bind_param("iss", $usuario_id, $nomeLoja, $categorias);

    if ($stmtInserirVendedor->execute()) {
        // Atualizar o cargo do usuário para "vendedor" na tabela usuarios
        $novoCargo = "vendedor";
        $sqlAtualizarCargo = "UPDATE usuarios SET permissao = ? WHERE id = ?";
        $stmtAtualizarCargo = $conn->prepare($sqlAtualizarCargo);
        $stmtAtualizarCargo->bind_param("si", $novoCargo, $usuario_id);
        $stmtAtualizarCargo->execute();

        // Redirecionar para alguma página de sucesso
        header("Location: ../index.php");
        exit();
    } else {
        $erro = "Erro ao criar o vendedor: " . $stmtInserirVendedor->error;
    }

    // Fechar as declarações preparadas
    $stmtInserirVendedor->close();
    $stmtAtualizarCargo->close();
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seja um Vendedor</title>

    <!-- Adicione o link para os estilos do Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body class="container mt-5">

    <h2>Criar Vendedor</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="needs-validation" novalidate>
        <div class="form-group">
            <label for="nome_loja">Nome da Loja:</label>
            <input type="text" class="form-control" name="nome_loja" required>
        </div>

        <div class="form-group">
            <label for="categorias">Categorias:</label>
            <select class="form-control" name="categorias" required>
                <option value="esportes">Esportes</option>
                <option value="eletronicos">Eletrônicos</option>
                <option value="alimentos">Alimentos</option>
                <option value="software">Software</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Se juntar ao time</button>
    </form>



</body>

</html>