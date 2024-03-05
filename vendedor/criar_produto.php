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
    $nomeLoja = $vendedor['nome_loja'];
    $categoriasLoja = $vendedor['categorias'];
} else {
    // Redirecione ou exiba uma mensagem de erro, pois o usuário não é um vendedor
    echo "Você não é um vendedor. Acesse como vendedor para criar sua loja.";
    exit();
}

// Processar o formulário de criação de produto aqui (quando o formulário for submetido)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os valores do formulário
    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $descricao = $_POST['descricao'];

    // Configuração para upload de imagem
    $diretorioImagens = "../media/produtos/{$nomeLoja}/fotos/";

    // Contar quantos produtos já existem para determinar o próximo número
    $contadorProdutos = count(glob($diretorioImagens . "produto-*"));

    // Incrementar o contador para obter o próximo número
    $proxNumeroProduto = $contadorProdutos + 1;

    $nomeArquivoOriginal = $_FILES['foto']['name'];
    $extensao = pathinfo($nomeArquivoOriginal, PATHINFO_EXTENSION);
    $nomeArquivo = "produto-$proxNumeroProduto.$extensao"; // Nome do arquivo com prefixo "produto-" e sufixo numérico

    $caminhoCompleto = $diretorioImagens . $nomeArquivo;

    // Certifique-se de que o vendedor (usuario_id) existe na tabela vendedores
    $verificarVendedor = "SELECT * FROM vendedores WHERE usuario_id = $usuario_id";
    $resultadoVendedor = $conn->query($verificarVendedor);

    if ($resultadoVendedor->num_rows == 0) {
        // Redirecione ou exiba uma mensagem de erro, pois o vendedor não existe na tabela vendedores
        echo "Erro: o vendedor não existe na tabela vendedores.";
        exit();
    }

    // Execute a inserção no banco de dados (ajuste conforme sua estrutura real)
    $inserirProduto = "INSERT INTO produtos (vendedor_id, nome, valor, descricao, foto) VALUES ('{$vendedor['id']}', '$nome', $valor, '$descricao', '$caminhoCompleto')";

    if ($conn->query($inserirProduto) === TRUE) {
        // Move a imagem para o diretório de destino
        if (!is_dir($diretorioImagens)) {
            mkdir($diretorioImagens, 0755, true);
        }
        move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoCompleto);

        // Redirecione para minha_loja.php após a criação do produto
        header("Location: minha_loja.php");
        exit();
    } else {
        echo "Erro ao criar produto: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

    <h2 class="text-center mb-4">Criar Produto</h2>

    <form action="criar_produto.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nome">Nome do Produto:</label>
            <input type="text" id="nome" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="valor">Valor:</label>
            <input type="text" id="valor" name="valor" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="foto">Foto do Produto:</label>
            <input type="file" id="foto" name="foto" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Criar Produto</button>
    </form>

    <!-- Adicione os scripts Bootstrap necessários -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>