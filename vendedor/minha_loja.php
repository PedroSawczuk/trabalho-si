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

    // Consulta SQL para obter produtos do vendedor
    $consultaProdutos = "SELECT * FROM produtos WHERE vendedor_id = {$vendedor['id']}";
    $resultadoProdutos = $conn->query($consultaProdutos);
} else {
    // Redirecione ou exiba uma mensagem de erro, pois o usuário não é um vendedor
    header("Location: acesso_negado_loja.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Loja</title>
    <!-- Adicione os estilos Bootstrap necessários -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Adicione seus estilos CSS personalizados aqui, se necessário -->
</head>

<body class="container mt-5">

    <h2 class="text-center mb-4">Minha Loja</h2>

    <div class="mb-3">
        <strong>Nome da Loja:</strong> <?php echo $nomeLoja; ?>
    </div>

    <div class="mb-4">
        <strong>Categorias:</strong> <?php echo $categoriasLoja; ?>
    </div>

    <h3 class="mb-3">Produtos</h3>

    <?php if ($resultadoProdutos->num_rows > 0) : ?>
        <!-- Exibe a lista de produtos -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Valor</th>
                        <th>Descrição</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($produto = $resultadoProdutos->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $produto['nome']; ?></td>
                            <td><?php echo $produto['valor']; ?></td>
                            <td><?php echo $produto['descricao']; ?></td>
                            <td>
                                <?php
                                $caminhoFoto = $produto['foto'];
                                if (!empty($caminhoFoto) && file_exists($caminhoFoto)) {
                                    // Exiba a miniatura da foto
                                    echo '<img src="' . $caminhoFoto . '" alt="' . $produto['nome'] . ' Foto" style="max-width: 100px; max-height: 100px;">';
                                } else {
                                    // Exiba uma mensagem se a foto não estiver disponível
                                    echo 'Foto não disponível. Caminho: ' . $caminhoFoto;
                                }
                                ?>
                            </td>
                            <td>
                                <a href="editar_produto.php?id=<?php echo $produto['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            </td>   
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <!-- Exibe mensagem se não houver produtos cadastrados -->
        <p class="alert alert-info">Nenhum produto cadastrado.</p>
    <?php endif; ?>

    <!-- Botão para adicionar produto -->
    <a href="criar_produto.php" class="btn btn-primary">Adicionar Produto</a>
        
    <a href="../index.php" class="btn btn-warning">Voltar a Página Inicial</a>

    <!-- Adicione os scripts Bootstrap necessários -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
