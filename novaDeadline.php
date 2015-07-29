<?php
/*
	NOVA DEADLINE
*/

//connecta
include 'connecta_mysql.php';

//entrada
$id_tasca=$_GET['id_tasca'];
$deadline=$_GET['deadline'];

//executa
echo "Nova deadline...";
$sql ="INSERT INTO deadlines 	(id  , id_tasca,  deadline) 
					VALUES 		(NULL,$id_tasca,'$deadline')";

mysql_query($sql) or exit('error');

echo "ok";

?>
