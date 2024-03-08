<?php
// Inicie a sessão
session_start();

// Inclua o arquivo de conexão
require_once "dados/conexao.php";

// Verifica se foi feita uma pesquisa
if (isset($_GET['pesquisa'])) {
    // Limpeza da entrada da pesquisa para evitar injeção de SQL
    $termo_pesquisa = mysqli_real_escape_string($conn, $_GET['pesquisa']);
    
    // Consulta SQL para recuperar apenas os produtos que correspondem à pesquisa
    $consultaProdutos = "SELECT * FROM produtos WHERE nome LIKE '%$termo_pesquisa%'";
    $resultadoProdutos = $conn->query($consultaProdutos);
} else {
    // Consulta para obter informações dos produtos
    $consultaProdutos = "SELECT * FROM produtos";
    $resultadoProdutos = $conn->query($consultaProdutos);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
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

        #produtos {
            text-align: center;
            margin: 20px;
        }

        .produto-card {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
        }

        .produto-card img {
            max-width: 100%;
            max-height: 200px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<header>
    <div class="header-container">
        <h1>Segurança da Informação</h1>
        <?php if (isset($_SESSION['usuario_id'])) : ?>
            <a class="button-header" href="logout.php">Sair</a>
        <?php else : ?>
            <a class="button-header" href="conta/login.php">Entrar</a>
        <?php endif; ?>
    </div>
</header>

<nav>
    <a href="index.php" class="nav-link">Home</a>
    <a href="<?php echo (isset($_SESSION['usuario_id'])) ? 'vendedor/minha_loja.php' : 'conta/login.php'; ?>" class="nav-link">Minha Loja</a>
    <a href="<?php echo (isset($_SESSION['usuario_id'])) ? 'vendedor/criar_vendedor.php' : 'conta/login.php'; ?>" class="nav-link">Seja um Vendedor</a>
    <a href="pages/admin.php" class="nav-link">Admin</a>
    <a href="produtos.php" class="nav-link">Produtos</a>
</nav>

<section id="produtos">
    <h2>Produtos Disponíveis</h2>
    
    <!-- Formulário de pesquisa -->
    <form method="GET" action="produtos.php">
        <input type="text" name="pesquisa" placeholder="Pesquisar produtos...">
        <button type="submit">Pesquisar</button>
    </form>

    <?php
    if ($resultadoProdutos->num_rows > 0) {
        while ($produto = $resultadoProdutos->fetch_assoc()) {
            echo '<div class="produto-card">';
            
            echo '<p><strong> ' . $produto['nome'] . '</strong></p>';
            echo '<p><strong> ' . 'R$' . $produto['valor'] . '</strong></p>';
            
            echo '</div>';
        }
    } else {
        echo '<p>Nenhum produto disponível.</p>';
    }
    ?>
</section>
</body>

</html>