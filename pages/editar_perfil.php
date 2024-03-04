<?php
session_start();

// Inclua o arquivo de conexão
include '../dados/conexao.php';

// Verifique se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

// Verifique se um usuário específico foi solicitado
if (!isset($_GET['usuario_id']) || !is_numeric($_GET['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

$usuario_id = $_GET['usuario_id'];

// Verifique se o usuário tem permissão para editar este perfil (adicione sua lógica aqui)
$usuarioAdmin = true; // Adicione sua lógica real para verificar se o usuário é um admin

if (!$usuarioAdmin) {
    // Redirecione ou exiba uma mensagem de erro, pois o usuário não tem permissão
    echo "Você não tem permissão para editar este perfil.";
    exit();
}

// Verifique se o formulário foi enviado e se a chave 'novo_cargo' existe no array $_POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['novo_cargo'])) {
    // Processar o formulário de edição aqui

    // Exemplo de atualização do cargo
    $novoCargo = $_POST['novo_cargo'];
    $sqlAtualizarCargo = "UPDATE usuarios SET permissao = '$novoCargo' WHERE id = $usuario_id";
    
    if ($conn->query($sqlAtualizarCargo) === TRUE) {
        echo "Permissão atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar permissão: " . $conn->error;
    }

    // Exemplo de exclusão de perfil e referências em tabelas relacionadas
    $conn->begin_transaction(); // Inicia uma transação para garantir consistência nos dados

    $sqlExcluirLoja = "DELETE FROM vendedores WHERE usuario_id = $usuario_id";
    if (!$conn->query($sqlExcluirLoja)) {
        echo "Erro ao excluir loja: " . $conn->error;
        $conn->rollback(); // Desfaz a transação em caso de erro
        exit();
    }

    $sqlExcluirPerfilUsuario = "DELETE FROM usuarios WHERE id = $usuario_id";
    if ($conn->query($sqlExcluirPerfilUsuario)) {
        echo "Perfil excluído com sucesso!";
        $conn->commit(); // Confirma a transação se tudo estiver correto
        exit();
    } else {
        echo "Erro ao excluir perfil: " . $conn->error;
        $conn->rollback(); // Desfaz a transação em caso de erro
        exit();
    }
}

// Consulta SQL para obter informações do usuário
$sqlUsuario = "SELECT id, username, email, permissao, data_cadastro FROM usuarios WHERE id = $usuario_id";
$resultUsuario = $conn->query($sqlUsuario);

if ($resultUsuario->num_rows > 0) {
    $usuario = $resultUsuario->fetch_assoc();

    // Verificar se é vendedor e obter informações adicionais
    if ($usuario['permissao'] === 'vendedor') {
        $sqlLoja = "SELECT nome_loja FROM vendedores WHERE usuario_id = $usuario_id";
        $resultLoja = $conn->query($sqlLoja);

        if ($resultLoja->num_rows > 0) {
            $infoLoja = $resultLoja->fetch_assoc();
            $nomeLoja = $infoLoja['nome_loja'];
        } else {
            $nomeLoja = "N/A";
        }
    } else {
        $nomeLoja = "N/A";
    }
} else {
    // Se o usuário não for encontrado, redirecione ou exiba uma mensagem de erro
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <!-- Adicione os estilos CSS necessários aqui -->
</head>

<body>

    <h2>Editar Perfil</h2>

    <form method="post" action="">
        <label for="cargo">Nova Permissão:</label>
        <input type="text" id="cargo" name="novo_cargo" value="<?php echo $usuario['permissao']; ?>" required>

        <button type="submit">Atualizar Permissão</button>
    </form>

    <form method="post" action="">
        <button type="submit">Excluir Perfil</button>
    </form>

    <h3>Informações do Perfil:</h3>
    <p><strong>Nome:</strong> <?php echo $usuario['username']; ?></p>
    <p><strong>Email:</strong> <?php echo $usuario['email']; ?></p>
    <p><strong>Data de Criação:</strong> <?php echo $usuario['data_cadastro']; ?></p>
    
    <?php if ($usuario['permissao'] === 'vendedor'): ?>
        <p><strong>Nome da Loja:</strong> <?php echo $nomeLoja; ?></p>
    <?php endif; ?>

    <!-- Adicione outros elementos HTML conforme necessário -->

</body>

</html>
