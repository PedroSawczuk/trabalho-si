<?php
session_start();

// Adicione o código de autenticação aqui (pode ser verificação de sessão, cookies, etc.)
$usuarioAutenticado = isset($_SESSION['usuario_id']);

// Se o usuário estiver autenticado, obtenha a permissão do banco de dados
if ($usuarioAutenticado) {
    // Inclua o arquivo de conexão para obter as informações necessárias
    require_once "dados/conexao.php";

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

            // Lógica para verificar se o usuário é vendedor
            $usuarioVendedor = ($permissao === 'vendedor');

            // Lógica para verificar se o usuário é admin
            $usuarioAdmin = ($permissao === 'admin');
        } else {
            // Trate o caso em que não há informações sobre a permissão do usuário
            // Pode ser um erro ou um estado não esperado
            // Você pode redirecionar o usuário ou tomar outras medidas necessárias
        }

        // Fechar o statement após o uso
        $stmt->close();
    } catch (Exception $e) {
        die("Erro: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI - Trabalho</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #3498db;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin: 0;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        a.button-header {
            text-decoration: none;
            color: #fff;
            background-color: #e74c3c;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a.button-header:hover {
            background-color: #c0392b;
        }

        nav {
            background-color: #333;
            padding: 10px 0;
            text-align: center;
        }

        .nav-link {
            text-decoration: none;
            color: #fff;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav-link:hover {
            background-color: #555;
        }
    </style>
</head>

<body>

    <header>
        <div class="header-container">
            <h1>Segurança da Informação</h1>
            <?php if ($usuarioAutenticado) : ?>
                <a class="button-header" href="logout.php">Sair</a>
            <?php else : ?>
                <a class="button-header" href="conta/login.php">Entrar</a>
            <?php endif; ?>
        </div>
    </header>

    <nav>
        <a href="index.php" class="nav-link">Home</a>

        <a href="<?php echo ($usuarioAutenticado) ? 'vendedor/minha_loja.php' : 'conta/login.php'; ?>" class="nav-link">
            Minha Loja
        </a>

        <a href="<?php echo ($usuarioAutenticado) ? 'vendedor/criar_vendedor.php' : 'conta/login.php'; ?>" class="nav-link">
            Seja um Vendedor
        </a>

        <a href="pages/admin.php" class="nav-link">Admin</a>


        <a href="produtos.php" class="nav-link">Produtos</a>
    </nav>

    <div class="container mt-5">
        <h2>Detalhes do Produto</h2>

        <?php
        // Verifique se o ID do produto foi passado via parâmetro GET
        if (isset($_GET['id'])) {
            $produto_id = $_GET['id'];

            // Consulta para obter informações do produto específico
            $consultaProduto = "SELECT * FROM produtos WHERE id = ?";

            try {
                $stmt = $conn->prepare($consultaProduto);
                $stmt->bind_param("i", $produto_id);
                $stmt->execute();
                $resultado = $stmt->get_result();

                if ($resultado->num_rows > 0) {
                    $produto = $resultado->fetch_assoc();

                    // Exibir informações do produto
                    echo '<p><strong>Nome:</strong> ' . $produto['nome'] . '</p>';
                    echo '<p><strong>Valor:</strong> ' . $produto['valor'] . '</p>';

                    // Verifica se o campo 'preco' existe antes de exibi-lo
                    if (isset($produto['preco'])) {
                        echo '<p><strong>Preço:</strong> ' . $produto['preco'] . '</p>';
                    }

                    // Verifica se o campo 'vendedor' existe antes de exibi-lo
                    if (isset($produto['vendedor'])) {
                        echo '<p><strong>Vendedor:</strong> ' . $produto['vendedor'] . '</p>';
                    }
                } else {
                    echo '<p>Produto não encontrado.</p>';
                }

                // Fechar o statement após o uso
                $stmt->close();
            } catch (Exception $e) {
                die("Erro: " . $e->getMessage());
            }
        } else {
            echo '<p>ID do produto não especificado.</p>';
        }
        ?>

    </div>

</body>

</html>