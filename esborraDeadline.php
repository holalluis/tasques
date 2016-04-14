<?php

/*
	ESBORRA UNA DEADLINE
*/

//connecta a la base de dades
include 'connecta_mysql.php';

//entrada: id de la deadline
$id=$_GET['id'];

//executa 
echo "Esborrant deadline $id...";

mysql_query("DELETE FROM deadlines WHERE id=$id") 	or exit('error');

echo "ok";

//torna enrere
header("location: ".$_SERVER['HTTP_REFERER']);

?>
