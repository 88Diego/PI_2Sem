<?php

session_start();

if (isset($_GET['logout']) && $_GET['logout'] == "1") {
    
    session_destroy();
    header('Location: index.php');
    exit;
    
}

// include('integracao/loginFunc.php');

// lidaBasicAuthentication('../../portal/naoautorizado.php');

if (!isset($_SESSION['codProfessor'])) {
    
    $_SESSION['msgError'] = "Login inválido.";
    header('Location:index.php');
}


?>

