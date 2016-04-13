<?php

/*
	ESBORRA UNA TASCA DEL PLA SETMANAL 
*/

//connecta a la base de dades
include 'connecta_mysql.php';

//entrada: id de la tasca del pla setmanal
$id=$_GET['id'];

//executa (esborra tasques i projecte)
echo "Esborrant tasca del pla setmanal...";

mysql_query("DELETE FROM pla_setmanal WHERE id_tasca=$id") 	or exit('error');

echo "ok";

//torna enrere
header("location: ".$_SERVER['HTTP_REFERER']);

?>
