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
    <!-- Adicionando CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0Z1d9vrScQmbxC3VrJfEqKRBK2KnUe4rNE6K+CwYxAl/Y+2QPk60sYyh0Sc5b" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <form action="processa_formulario.php" method="GET">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>

    <!-- Adicionando JavaScript do Bootstrap (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+EsOIjizsH/8F8N7pKxF4OeLrjIZnE4heB+tFfs" crossorigin="anonymous"></script>
</body>

</html>