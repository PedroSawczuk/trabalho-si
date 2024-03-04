<?php
// dados/conexao.php
$servername = "localhost:3300"; // Corrigido o número da porta padrão do MySQL para 3306
$database = "trabalho_si";
$username = "root";
$password = "alunoifro";
$conn = new mysqli($servername, $username, $password, $database);


// Verificar a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


