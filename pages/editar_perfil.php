<?php
// Incluir conexão com o banco de dados
include_once '../dados/conexao.php';

// Verificar se o parâmetro 'usuario_id' foi enviado via GET
if (isset($_GET['usuario_id']) && !empty($_GET['usuario_id'])) {
    $usuario_id = $_GET['usuario_id'];

    // Consultar dados do usuário pelo ID
    $queryUsuario = "SELECT * FROM usuarios WHERE id = $usuario_id";
    $resultUsuario = $conn->query($queryUsuario);

    if ($resultUsuario->num_rows > 0) {
        $usuario = $resultUsuario->fetch_assoc();
    } else {
        echo "Usuário não encontrado.";
        exit;
    }
} else {
    echo "ID do usuário não especificado.";
    exit;
}

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter os dados do formulário
    $novoNome = $_POST['nome'];
    $novoEmail = $_POST['email'];
    $novaPermissao = $_POST['permissao'];

    // Atualizar os dados do usuário no banco de dados
    $queryUpdate = "UPDATE usuarios SET username = '$novoNome', email = '$novoEmail', permissao = '$novaPermissao' WHERE id = $usuario_id";
    if ($conn->query($queryUpdate) === TRUE) {
        // Redirecionar de volta para a página admin.php após a atualização
        header("Location: admin.php");
        exit;
    } else {
        echo "Erro ao atualizar o perfil: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <button><a href="admin.php" class="btn btn-danger">Cancelar</a></button>

    <div class="container">
        <h2 class="mt-5">Editar Perfil</h2>
        <form class="mt-4" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?usuario_id=' . $usuario_id; ?>">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" name="nome" value="<?php echo $usuario['username']; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo $usuario['email']; ?>">
            </div>
            <div class="form-group">
                <label for="permissao">Permissão:</label>
                <select class="form-control" name="permissao">
                    <option value="Cliente" <?php if ($usuario['permissao'] == 'Cliente') echo 'selected="selected"'; ?>>Cliente</option>
                    <option value="Vendedor" <?php if ($usuario['permissao'] == 'Vendedor') echo 'selected="selected"'; ?>>Vendedor</option>
                    <option value="Admin" <?php if ($usuario['permissao'] == 'Admin') echo 'selected="selected"'; ?>>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Fazer Mudanças</button>
        </form>
    </div>

    <!-- Adicione a referência ao Bootstrap JS (opcional, se necessário para funcionalidades específicas do Bootstrap) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>