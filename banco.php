<?php

include('session.php');

$usuario = $_POST['username'];
$senha = $_POST['password'];

$dbhost = "koo2dzw5dy.database.windows.net";
$db = "SenaQuiz";
$user = "TSI";
$password = "SistemasInternet123";
$dsn = "Driver={SQL Server};Server=$dbhost;Port=1433;Database=$db;";

$connect = odbc_connect($dsn,
						$user,
						$password);


$query = 
		"SELECT 
			codProfessor, nome, tipo, email 
		FROM 
			professor 
		WHERE 
			email = '$usuario' 
		AND 
			senha = HASHBYTES('SHA1', '$senha' )";

// $query2 = "SELECT codProfessor, nome, tipo, email FROM professor WHERE email= '?' ";
// $preparado = odbc_prepare($connect, $query);
// $consulta2 = odbc_execute($preparado, array ( $usuario ));
// odbc_result_all($consulta2);


$consulta = odbc_exec($connect,$query);
$resultado = odbc_num_rows($consulta);	

if( $resultado > 0 ){
	$resultado = odbc_fetch_array($consulta);
	print_r($resultado);

	$_SESSION['showMenu'] = true;
	$_SESSION['codProfessor'] = $resultado['codProfessor'];
	$_SESSION['nomeProfessor'] = $resultado['nome'];
	$_SESSION['tipoProfessor'] = $resultado['tipo'];

	$_SESSION['msgError'] = NULL;

	header('Location:admin.php');	
}
else {
	$_SESSION['msgError'] = "Login inválido.";
	session_destroy();	
	header('Location:index.php');		
}


?>