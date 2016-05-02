<?php 
$dbhost = "koo2dzw5dy.database.windows.net";
$db = "SenaQuiz";
$user = "TSI";
$password = "SistemasInternet123";
$dsn = "Driver={SQL Server};Server=$dbhost;Port=1433;Database=$db;";
$connect = odbc_connect($dsn,
						$user,
						$password);
?>