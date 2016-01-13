<?php

/*
	ESBORRA UNA TASCA ACABADA
*/

//connecta
include 'connecta_mysql.php';

//entrada: id de la tasca acabada
$id=$_GET['id'];

//executa 
echo "Esborrant tasca acabada ...";

//esborra el projecte
mysql_query("DELETE FROM acabades WHERE id=$id") or exit('error');

//torna enrere
header("location: ".$_SERVER['HTTP_REFERER']);

?>
