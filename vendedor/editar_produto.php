<?php
session_start();

// Inclua o arquivo de conexão
include '../dados/conexao.php';

// Verifique se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

// Verifique se o usuário é um vendedor
$usuario_id = $_SESSION['usuario_id'];
$consultaVendedor = "SELECT * FROM vendedores WHERE usuario_id = $usuario_id";
$resultadoVendedor = $conn->query($consultaVendedor);

if ($resultadoVendedor->num_rows > 0) {
    $vendedor = $resultadoVendedor->fetch_assoc();
} else {
    // Redirecione ou exiba uma mensagem de erro, pois o usuário não é um vendedor
    header("Location: ../index.php");
    exit();
}

// Verifique se um ID de produto foi fornecido como parâmetro
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: minha_loja.php");
    exit();
}

$produto_id = $_GET['id'];

// Consulta SQL para obter informações do produto
$consultaProduto = "SELECT * FROM produtos WHERE id = $produto_id AND vendedor_id = {$vendedor['id']}";
$resultadoProduto = $conn->query($consultaProduto);

if ($resultadoProduto->num_rows > 0) {
    $produto = $resultadoProduto->fetch_assoc();

    // Verifique se o formulário foi enviado para atualizar o produto
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Processar o formulário de edição aqui

        // Exemplo de atualização do produto
        $novoNome = $_POST['novo_nome'];
        $novaDescricao = $_POST['nova_descricao'];
        $novoValor = $_POST['novo_valor'];

        $sqlAtualizarProduto = "UPDATE produtos SET nome = '$novoNome', descricao = '$novaDescricao', valor = $novoValor WHERE id = $produto_id";

        if ($conn->query($sqlAtualizarProduto) === TRUE) {
            header("Location: minha_loja.php");
            exit();
        } else {
            echo "Erro ao atualizar produto: " . $conn->error;
        }
    }
} else {
    // Redirecione ou exiba uma mensagem de erro, pois o produto não foi encontrado
    header("Location: minha_loja.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <!-- Adicione os estilos Bootstrap necessários -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Adicione seus estilos CSS personalizados aqui, se necessário -->
</head>

<body class="container mt-5">

    <h2 class="text-center mb-4">Editar Produto</h2>

    <form method="post" action="">
        <div class="mb-3">
            <label for="novo_nome" class="form-label">Novo Nome:</label>
            <input type="text" id="novo_nome" name="novo_nome" class="form-control" value="<?php echo $produto['nome']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="nova_descricao" class="form-label">Nova Descrição:</label>
            <textarea id="nova_descricao" name="nova_descricao" class="form-control" required><?php echo $produto['descricao']; ?></textarea>
        </div>

        <div class="mb-3">
            <label for="novo_valor" class="form-label">Novo Valor:</label>
            <input type="text" id="novo_valor" name="novo_valor" class="form-control" value="<?php echo $produto['valor']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Produto</button>
        <a href="minha_loja.php" class="btn btn-secondary">Cancelar</a>

        <!-- Adicione o link para excluir o produto -->
        <a href="excluir_produto.php?id=<?php echo $produto['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir Produto</a>
    </form>

    <!-- Adicione outros elementos HTML conforme necessário -->

    <!-- Adicione os scripts Bootstrap necessários -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
