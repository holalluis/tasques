<?php
/*
	ESBORRA UNA TASCA DE LA BASE DE DADES
*/

//connecta
include 'connecta_mysql.php';

//entrada
$id=$_GET['id'];

echo "Esborrant tasca...";

//esborra les tasques del pla setmanal
mysql_query("DELETE FROM pla_setmanal WHERE id_tasca=$id") or exit('error');

//esborra els deadlines
mysql_query("DELETE FROM deadlines WHERE id_tasca=$id") or exit('error');

//esborra la tasca
mysql_query("DELETE FROM tasques WHERE id=$id") or exit('error');

echo "ok";

?>
