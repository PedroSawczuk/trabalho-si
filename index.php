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
    <title>Minha Página</title>
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

        <?php if ($usuarioAutenticado) : ?>
            <?php if ($usuarioVendedor) : ?>
                <a href="vendedor/minha_loja.php" class="nav-link">Minha Loja</a>
            <?php else : ?>
                <a href="vendedor/criar_vendedor.php" class="nav-link">Seja um Vendedor</a>
            <?php endif; ?>
        <?php endif; ?>


        <?php if ($usuarioAdmin) : ?>
            <a href="pages/admin.php" class="nav-link">Admin</a>
        <?php endif; ?> 


        <a href="produtos.php" class="nav-link">Produtos</a>
    </nav>


</body>

</html>