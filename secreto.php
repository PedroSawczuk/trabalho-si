<?php
// Verifica se os campos foram preenchidos
if (isset($_GET['nome']) && isset($_GET['email']) && isset($_GET['idade'])) {
    $nome = $_GET['nome'];
    $email = $_GET['email'];


    // Exibe os dados recebidos
    echo "<p>Nome: $nome</p>";
    echo "<p>Email: $email</p>";
} else {
    echo "<p>Por favor, preencha todos os campos do formulário.</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário GET com Bootstrap</title>
    <!-- Adicionando Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <form action="processa_formulario.php" method="GET">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>

    <!-- Adicionando Bootstrap JS (opcional, caso necessite de funcionalidades JavaScript do Bootstrap) -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</body>

</html>