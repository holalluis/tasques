<?php

/*
	ESBORRA UNA AREA DE LA BASE DE DADES
*/

//connecta a la base de dades
include 'connecta_mysql.php';

//entrada: id de la area 
$id=$_GET['id'];

//executa (esborra tasques i projecte)
echo "Esborrant area...";

//recorre tots els projectes de l'area
$res=mysql_query("SELECT id FROM projectes WHERE id_area=$id");
while($row=mysql_fetch_array($res))
{
	$id_projecte = $row['id'];
	//recorre totes les tasques del projecte i
	$ress=mysql_query("SELECT id FROM tasques WHERE id_projecte=$id_projecte");
	while($roww=mysql_fetch_array($ress))
	{
		$id_tasca = $roww['id'];
		mysql_query("DELETE FROM pla_setmanal WHERE id_tasca=$id_tasca") or exit('error');
		mysql_query("DELETE FROM deadlines    WHERE id_tasca=$id_tasca") or exit('error');
	}
	mysql_query("DELETE FROM tasques WHERE id_projecte=$id_projecte") or exit('error esborrant tasques');
}

//esborra projectes de l'area
mysql_query("DELETE FROM projectes WHERE id_area=$id") 	or exit('error');

//esborra area 
mysql_query("DELETE FROM arees WHERE id=$id") 		or exit('error');

//torna enrere
header("location: editaArees.php");

?>
