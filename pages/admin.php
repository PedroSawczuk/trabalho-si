<?php
session_start();

// Inclua o arquivo de conexão
include '../dados/conexao.php';

// Adicione o código de autenticação e verificação de admin aqui
$usuarioAutenticado = isset($_SESSION['usuario_id']);

if ($usuarioAutenticado) {
    // Use prepared statement para evitar SQL injection
    $usuario_id = $_SESSION['usuario_id'];
    $consulta = "SELECT permissao FROM usuarios WHERE id = ?";

    try {
        $stmt = $conn->prepare($consulta);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if (!$resultado) {
            throw new Exception("Erro ao executar a consulta: " . $stmt->error);
        }

        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $permissao = $row['permissao'];

            // Lógica para verificar se o usuário é admin
            $usuarioAdmin = ($permissao === 'admin');
        } else {
            // Trate o caso em que não há informações sobre a permissão do usuário
            // Pode ser um erro ou um estado não esperado
            // Você pode redirecionar o usuário ou tomar outras medidas necessárias
            header("Location: ../acesso_negado.php");
            exit();
        }

        // Fechar o statement após o uso
        $stmt->close();
    } catch (Exception $e) {
        die("Erro: " . $e->getMessage());
    }
} else {
    // Se o usuário não estiver autenticado, redirecione para a página de acesso negado
    header("Location: ../acesso_negado.php");
    exit();
}

// Se o usuário não for admin, redirecione para a página de acesso negado
if (!$usuarioAdmin) {
    header("Location: ../acesso_negado.php");
    exit();
}

// Consulta SQL para obter informações sobre usuários
$sqlUsuarios = "SELECT id, username, email, data_cadastro FROM usuarios";
$resultUsuarios = $conn->query($sqlUsuarios);

// Consulta SQL para obter informações sobre lojas
$sqlLojas = "SELECT id, nome_loja, categorias FROM vendedores";
$resultLojas = $conn->query($sqlLojas);
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Administração</title>

    <!-- Adicione o link para os estilos do Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

    <h2>Administração</h2>

    <h3>Usuários</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Data de Cadastro</th>
                <th>Ações</th> <!-- Nova coluna para ações -->
            </tr>
        </thead>
        <tbody>
            <?php while ($usuario = $resultUsuarios->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $usuario['username']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td><?php echo $usuario['data_cadastro']; ?></td>
                    <td>
                        <a href="editar_perfil.php?usuario_id=<?php echo $usuario['id']; ?>" class="btn btn-primary">Editar Perfil</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h3>Lojas</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome da Loja</th>
                <th>Categoria</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop através das lojas -->
            <?php while ($loja = $resultLojas->fetch_assoc()) : ?>
                <tr>
                    <!-- Ajuste: Verifica se os índices estão definidos antes de acessar -->
                    <td><?php echo isset($loja['nome_loja']) ? $loja['nome_loja'] : 'N/A'; ?></td>
                    <td><?php echo isset($loja['categorias']) ? $loja['categorias'] : 'N/A'; ?></td>
                </tr>
            <?php endwhile; ?>

            <!-- Ajuste: Exibe uma mensagem caso não haja lojas -->
            <?php if ($resultLojas->num_rows == 0) : ?>
                <tr>
                    <td colspan="2">Nenhuma loja encontrada</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Adicione o link para os scripts do Bootstrap (JQuery e Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>

<?php
// Fechar a conexão
$conn->close();
?>