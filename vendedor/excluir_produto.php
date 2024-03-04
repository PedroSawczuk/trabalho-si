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

// Consulta SQL para verificar se o produto pertence ao vendedor
$consultaProduto = "SELECT * FROM produtos WHERE id = $produto_id AND vendedor_id = {$vendedor['id']}";
$resultadoProduto = $conn->query($consultaProduto);

if ($resultadoProduto->num_rows > 0) {
    // Produto encontrado, pode ser excluído
    $excluirProduto = "DELETE FROM produtos WHERE id = $produto_id";

    if ($conn->query($excluirProduto) === TRUE) {
        // Redirecione para minha_loja.php após a exclusão do produto
        header("Location: minha_loja.php");
        exit();
    } else {
        echo "Erro ao excluir produto: " . $conn->error;
    }
} else {
    // Redirecione ou exiba uma mensagem de erro, pois o produto não foi encontrado
    header("Location: minha_loja.php");
    exit();
}
?>
