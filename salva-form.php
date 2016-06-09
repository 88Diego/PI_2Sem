<div id="textos">
Questão Salva
</div>
<?php

// include('session.php');

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

	if(isset($_GET['codquestao']) && $_GET['codquestao'] != ""){

		$queryQuestao = "SELECT * FROM questao LEFT JOIN imagem ON (questao.codImagem = imagem.codImagem) WHERE codQuestao = ".$_GET['codquestao']."";
		$questao = odbc_exec( $connect, $queryQuestao );
		$linhasQuestao = odbc_fetch_array( $questao );
		$idImagem = $linhasQuestao['codImagem'];



		$queryImg = "UPDATE IMAGEM SET tituloImagem = ?, bitmapImagem = ? WHERE codImagem = ".$idImagem."";
		
		$paramsImg = array ($fileName, $content);
		$prepImg = odbc_prepare($connect, $queryImg );
		$resultImg = odbc_execute($prepImg, $paramsImg );

		$queryQuestao = "UPDATE questao SET textoQuestao = '".$_POST['txQuestao']."', codAssunto = ".$_POST['codAssunto'].", codTipoQuestao = '".$_POST['codTipoQuestao']."', codProfessor = ".$_SESSION['codProfessor'].", ativo = 1, dificuldade = '".$_POST['dificuldade']."' WHERE codQuestao = ".$_GET['codquestao']."";


		$resultQuestao = odbc_exec($connect, $queryQuestao);	


	} else{
		$queryImg = "INSERT INTO imagem (tituloImagem, bitmapImagem) VALUES (? , ?)";
		
		$paramsImg = array ($fileName, $content);
		$prepImg = odbc_prepare($connect, $queryImg );
		$resultImg = odbc_execute($prepImg, $paramsImg );

		$queryQuestao = "INSERT INTO QUESTAO (textoQuestao, codAssunto, codImagem, codTipoQuestao, codProfessor, ativo, dificuldade ) VALUES (?,?, IDENT_CURRENT( 'IMAGEM' ), ?, ?, ?, ?)";	
		$paramsQuestao = array ($_POST['txQuestao'], $_POST['codAssunto'], $_POST['codTipoQuestao'], $_SESSION['codProfessor'], 1, $_POST['dificuldade']);
		$prepQuestao = odbc_prepare($connect, $queryQuestao);
		$resultQuestao = odbc_execute($prepQuestao, $paramsQuestao);	
	}
		
	
} else{


	if(isset($_GET['codquestao']) && $_GET['codquestao'] != ""){
		$queryQuestao = "UPDATE questao SET textoQuestao = '".$_POST['txQuestao']."', codAssunto = ".$_POST['codAssunto'].", codTipoQuestao = '".$_POST['codTipoQuestao']."', codProfessor = ".$_SESSION['codProfessor'].", ativo = 1, dificuldade = '".$_POST['dificuldade']."' WHERE codQuestao = ".$_GET['codquestao']."";


		$resultQuestao = odbc_exec($connect, $queryQuestao);	
	}

	 else{
		$queryQuestao = "INSERT INTO QUESTAO (textoQuestao, codAssunto, codTipoQuestao, codProfessor, ativo, dificuldade ) VALUES (?, ?, ?, ?, ?, ?)";	
		$paramsQuestao = array ($_POST['txQuestao'], $_POST['codAssunto'], $_POST['codTipoQuestao'], $_SESSION['codProfessor'], 1, $_POST['dificuldade']);
		$prepQuestao = odbc_prepare($connect, $queryQuestao);
		$resultQuestao = odbc_execute($prepQuestao, $paramsQuestao);		
		$resultCodQuestaoScope = odbc_exec($connect, "SELECT IDENT_CURRENT('Questao') codQuestao");
	}

	// $codQuestao = odbc_fetch_array($resultCodQuestaoScope);

	// print_r($codQuestao['codQuestao']);



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


	$i = 1;
	
	foreach ($_POST['alternativas'] as $key => $value) {	
			

			if(isset($_GET['codquestao'])){
				$queryAlternativa = "UPDATE ALTERNATIVA SET textoAlternativa = ?, correta = ? WHERE codQuestao = ".$_GET['codquestao']." and codAlternativa = ?";
			} else{
				$queryAlternativa = "INSERT INTO ALTERNATIVA (codQuestao, codAlternativa, textoAlternativa, correta) VALUES (?, ?, ?, ?)";
			}
			


			if($_POST['opcao_certa'] == $i){
				echo "---------------Correta-----------<br/>";
				if(isset($_GET['codquestao'])){
					$paramsAlternativa = array ($value, 1, $i);		
				} else{
					$paramsAlternativa = array ($_GET['codquestao'], $i, $value, 1);	
				}
			} else {
				echo "---------------Incorreta-----------<br/>";
				if(isset($_GET['codquestao'])){
					$paramsAlternativa = array ($value, 0, $i);
				}else{
					$paramsAlternativa = array ($_GET['codquestao'], $i, $value, 0);
				}
			}
			
			$prepAlternativa = odbc_prepare($connect, $queryAlternativa);
			$resultAlternativa = odbc_execute($prepAlternativa, $paramsAlternativa);
			$i++;
	}
	
}

?>
