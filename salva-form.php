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

$str = "imagem=&txQuestao=&assunto=0&tipoQuestao=a&dificuldade=f&ativo=1&alternativas0=&alternativas1=&alternativas2=&alternativas3=";

$params = array();
parse_str($str, $params);


print_r($params['assunto']);

?>