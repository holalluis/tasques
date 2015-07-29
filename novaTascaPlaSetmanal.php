<?php
/*
	ENVIA UNA TASCA AL PLA SETMANAL
*/

//connecta
include 'connecta_mysql.php';

//entrada
$id_tasca=$_GET['id_tasca'];
$dia=$_GET['dia'];

//executa
echo "Enviant tasca al pla setmanal...";
$sql ="INSERT INTO pla_setmanal (id_tasca,dia) ";
$sql.="VALUES ($id_tasca,'$dia')";
mysql_query($sql) or exit('error');

echo "ok";

?>
