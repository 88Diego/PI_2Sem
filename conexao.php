<?php
//pagina que armazena os dados de conexão com o banco de dados
$dbhost   = "koo2dzw5dy.database.windows.net";//endereço do banco de dados
$db       = "SenaQuiz";//nome do banco
$user     = "TSI";//usuario do banco
$password = "SistemasInternet123";//senha de acesso ao banco
$dsn      = "Driver={SQL Server};Server=$dbhost;Port=1433;Database=$db;";//dados de conexão com o banco
$connect  = odbc_connect($dsn, $user, $password);//função de conexão com o banco
?>