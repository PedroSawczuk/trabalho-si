<?php
session_start();

// Limpar todas as variáveis de sessão
session_unset();

// Destruir a sessão
session_destroy();

// Redirecionar para a página de login após o logout
header("Location: index.php");
exit();
?>
