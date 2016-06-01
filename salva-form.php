<?php

include('session.php');

include('conexao.php');

// INSERT INTO QUESTAO (textoQuestao, codAssunto, codImagem, codTipoQuestao, codProfessor, ativo, dificuldade )
// VALUES (
// 'Teste 4',
// '1',
// NULL,
// 'A',
// '1',
// '1',
// '1'
// )

if( $_FILES['imagem']['size'] > 0 ){
	
	$fileName = $_FILES['imagem']['name'];
	$tmpName  = $_FILES['imagem']['tmp_name'];
	$fileSize = $_FILES['imagem']['size'];
	$fileType = $_FILES['imagem']['type'];

	

	$fp = fopen( $tmpName, 'r' );
	$content = fread( $fp, filesize( $tmpName ) );
	fclose( $fp );

	$queryImg = "INSERT INTO imagem (tituloImagem, bitmapImagem) VALUES (? , ?)";
	
	$paramsImg = array ($fileName, $content);
	$prepImg = odbc_prepare($connect, $queryImg );
	$resultImg = odbc_execute($prepImg, $paramsImg );

	$queryQuestao = "INSERT INTO QUESTAO (textoQuestao, codAssunto, codImagem, codTipoQuestao, codProfessor, ativo, dificuldade ) VALUES (?,?, IDENT_CURRENT( 'IMAGEM' ), ?, ?, ?, ?)";	
	$paramsQuestao = array ($_POST['txQuestao'], $_POST['codAssunto'], $_POST['codTipoQuestao'], $_SESSION['codProfessor'], $_POST['ativo'], $_POST['dificuldade']);
	$prepQuestao = odbc_prepare($connect, $queryQuestao);
	$resultQuestao = odbc_execute($prepQuestao, $paramsQuestao);	
		
	
} else{



	$queryQuestao = "INSERT INTO QUESTAO (textoQuestao, codAssunto, codTipoQuestao, codProfessor, ativo, dificuldade ) VALUES (?, ?, ?, ?, ?, ?)";		
	$paramsQuestao = array ($_POST['txQuestao'], $_POST['codAssunto'], $_POST['codTipoQuestao'], $_SESSION['codProfessor'], 1, $_POST['dificuldade']);
	$prepQuestao = odbc_prepare($connect, $queryQuestao);
	$resultQuestao = odbc_execute($prepQuestao, $paramsQuestao);

	$resultCodQuestaoScope = odbc_exec($connect, "SELECT IDENT_CURRENT('Questao') codQuestao");

	$codQuestao = odbc_fetch_array($resultCodQuestaoScope);

	print_r($codQuestao);



	// echo 'txQuestao: ';
	// echo $_POST['txQuestao'];
	// echo '<br/>';
	// echo 'codAssunto: ';
	// echo $_POST['codAssunto'];
	// echo '<br/>';
	// echo 'codTipoQuestao: ';
	// echo $_POST['codTipoQuestao'];
	// echo '<br/>';
	// echo 'codProfessor: ';
	// echo $_SESSION['codProfessor'];
	// echo '<br/>';
	// echo 'dificuldade: ';
	// echo $_POST['dificuldade'];




	// PRINT_R($_POST);

	// PRINT_R($_SESSION['codQuestao']);


	$i = 0;
	foreach ($_POST['alternativas'] as $key => $value) {	
		$i++;
		
		if($key == $i-1){

			print_r('i: '.$i.' value: '.$value.'<br/>');	
			
			$queryAlternativa = "INSERT INTO ALTERNATIVA (codQuestao, codAlternativa, textoAlternativa, correta) VALUES (?, ?, ?, ?)";

			if($_POST['opcao_certa'] == $i || $_POST['opcao_certa'] == "corretas"){
				$paramsAlternativa = array ($codQuestao, $i, $value, 1);	
			} else{
				$paramsAlternativa = array ($codQuestao, $i, $value, 0);
			}
			
			$prepAlternativa = odbc_prepare($connect, $queryAlternativa);
			$resultAlternativa = odbc_execute($prepAlternativa, $paramsAlternativa);
		}

	}
	
}

?>
