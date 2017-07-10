<?php
/*
	ESBORRA UNA TASCA PERIODICA DE LA BASE DE DADES
*/

//connecta
include 'connecta_mysql.php';

//entrada
$id=$_GET['id'];

echo "Esborrant tasca...";

//esborra les tasques del pla setmanal
mysql_query("DELETE FROM periodiques WHERE id=$id") or exit('error');

echo "ok";

header("Location: periodiques.php");

?>
