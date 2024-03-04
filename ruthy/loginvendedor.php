<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Vendedor</title>
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

    .login-container {
        text-align: center;
        background-color: #ffffff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        max-width: 300px;
        width: 100%;
    }

    .login-container h2 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .login-form {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 20px;
    }

    .login-form input {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #000000;
        border-radius: 5px;
    }

    .login-form button {
        width: 100%;
        padding: 10px;
        background-color: #000000;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .register-link {
        font-size: 14px;
    }

    .register-link a {
        color: #000000;
        text-decoration: none;
    }
</style>
</head>
<body>

<div class="login-container">
    <h2>Seja um Vendedor</h2>
    <form class="login-form">
        <input type="email" placeholder="E-mail">
        <input type="password" placeholder="Senha">
        <button type="submit">Login</button>
    </form>
    <div class="register-link">
        <p>Ainda não tem conta? <a href="cadastre-se.html">Cadastre-se</a></p>
    </div>
</div>

</body>
</html>
