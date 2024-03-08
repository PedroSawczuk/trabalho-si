<?php
$servername = "localhost:3300"; 
$database = "trabalho_si";
$username = "root";
$password = "alunoifro";
$conn = new mysqli($servername, $username, $password, $database);


// Verificar a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


