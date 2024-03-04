<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastre-se</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #ffffff;
        color: #000000;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .form-container {
        text-align: center;
        background-color: #ffffff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        max-width: 300px;
        width: 100%;
    }

    .form-container h2 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .form {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 20px;
    }

    .form input {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #000000;
        border-radius: 5px;
    }

    .form button {
        width: 100%;
        padding: 10px;
        background-color: #000000;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .login-link {
        font-size: 14px;
    }

    .login-link a {
        color: #000000;
        text-decoration: none;
    }
</style>
</head>
<body>

<div class="form-container">
    <h2>Criar conta</h2>
    <form class="form" id="signup-form">
        <input type="text" placeholder="Nome">
        <input type="email" placeholder="E-mail">
        <input type="password" id="password" placeholder="Senha">
        <input type="password" id="confirm-password" placeholder="Confirme a Senha">
        <button type="submit">Cadastrar</button>
    </form>
    <div class="register-link">
        <p>já tem uma conta? <a href="logincliente.html">faça Login</a></p>
    </div>
</div>

<script>
    document.getElementById("signup-form").addEventListener("submit", function(event) {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm-password").value;

        if (password !== confirmPassword) {
            alert("As senhas não correspondem!");
            event.preventDefault(); // Evita que o formulário seja enviado
        }
    });
</script>

</body>
</html>
