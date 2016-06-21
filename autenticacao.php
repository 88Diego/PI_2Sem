<?php
//está é a pagina que faz a autentic~ção dos dados passados pelo usuario na pagina de login
include('session.php');

$usuario = $_POST['username'];//email do usuario passado na pagina de login
$senha   = $_POST['password'];//senha passada na pagina de login

include('conexao.php');


$query = "SELECT codProfessor, nome, tipo, email FROM professor WHERE email = '$usuario' AND senha = HASHBYTES('SHA1', '$senha' )";
//query que faz a consulta no banco de acordo com os dados passados na pagina de login


$consulta  = odbc_exec($connect, $query);//função de consulta no banco de dados utilizando a query
$resultado = odbc_num_rows($consulta);//resultado da consulta no banco

if ($resultado > 0) {//se a consulta retornar algum resultado valido o processo dara continuidade
    $resultado = odbc_fetch_array($consulta);//variavel que armazena os dados da consulta no banco de dados
    
    $_SESSION['Logado']        = true;
    $_SESSION['showMenu']      = true;
    $_SESSION['codProfessor']  = $resultado['codProfessor'];
    $_SESSION['nomeProfessor'] = $resultado['nome'];
    $_SESSION['tipoProfessor'] = $resultado['tipo'];
    
    $_SESSION['msgError'] = NULL;
    //os dados da consulta no banco são armazenados nas variaveis de sessão para garantir a autenticação em todas as paginas
    
    header('Location:admin.php');
} else {
   	
    $_SESSION['msgError'] = "Login inválido.";
    header('Location:index.php');
    //caso a consulta no banco não retorne nenhum resultado valido é passada uma mensagem de erro ao usuario e o acesso é impedido
}


?>