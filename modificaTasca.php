<?php
/*
	MODIFICA SI ESTA ACABADA O NO UNA TASCA
*/

//connecta
include 'connecta_mysql.php';

//entrada
$id=$_GET['id'];
$acabada=$_GET['acabada']; //0 ò 1

//executa
echo "Modificant tasca...";

mysql_query("UPDATE tasques SET acabada=$acabada WHERE id=$id") or die('error');

echo "ok";

?>
