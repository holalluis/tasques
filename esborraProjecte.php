<?php

/*
	ESBORRA UN PROJECTE DE LA BASE DE DADES
*/

//connecta a la base de dades
include 'connecta_mysql.php';

//entrada: id del projecte
$id=$_GET['id'];

//executa (esborra tasques i projecte)
echo "Esborrant projecte...";

//quina area es?
$id_area=current(mysql_fetch_array(mysql_query("SELECT id_area FROM projectes WHERE id=$id")));

//deadlines i tasques del pla setmanal 
$result = mysql_query("SELECT id FROM tasques WHERE id_projecte=$id") or exit('error');
while($row=mysql_fetch_array($result))
{
	$id_tasca = $row['id'];
	mysql_query("DELETE FROM pla_setmanal WHERE id_tasca=$id_tasca") or exit('error');
	mysql_query("DELETE FROM deadlines    WHERE id_tasca=$id_tasca") or exit('error');
}

//esborra les tasques
mysql_query("DELETE FROM tasques WHERE id_projecte=$id") 	or exit('error');

//esborra el projecte
mysql_query("DELETE FROM projectes WHERE id=$id") 		or exit('error');

//torna enrere
header("location: index.php?area=$id_area");

?>
