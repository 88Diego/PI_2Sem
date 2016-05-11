<?php

include('session.php');

$usuario = $_POST['username'];
$senha = $_POST['password'];

include('conexao.php');


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


// insert
// INSERT INTO Professor (nome, email, senha, idSenac, tipo )
// VALUES (
// 'Diego', 
// 'teste@teste.com',
// HASHBYTES('SHA1', 'diego' ),
// 'teste',
// 'A'
// )


$consulta = odbc_exec($connect,$query);
$resultado = odbc_num_rows($consulta);	

if( $resultado > 0 ){
	$resultado = odbc_fetch_array($consulta);

	$_SESSION['Logado'] = true;
	$_SESSION['showMenu'] = true;
	$_SESSION['codProfessor'] = $resultado['codProfessor'];
	$_SESSION['nomeProfessor'] = $resultado['nome'];
	$_SESSION['tipoProfessor'] = $resultado['tipo'];

	$_SESSION['msgError'] = NULL;

	header('Location:admin.php');	
}
else {
	// session_destroy();	
	$_SESSION['msgError'] = "Login inválido.";
	header('Location:index.php');		
}


?>