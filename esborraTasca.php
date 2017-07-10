<?php
/*
	ESBORRA UNA TASCA DE LA BASE DE DADES
*/

//connecta
include 'connecta_mysql.php';

//entrada
	$id=$_GET['id'];
	$no_historic = isset($_GET['no_historic']) ? $_GET['no_historic'] : false;

//afegir a historic "tasques acabades"
if(!$no_historic)
{
	$res=mysql_query("	
						SELECT 	descripcio AS tasca,projectes.nom AS projecte ,arees.nom AS area
						FROM 	tasques,projectes,arees 
						WHERE 	tasques.id=$id AND projectes.id=tasques.id_projecte AND projectes.id_area=arees.id
					") or die(mysql_error());
	$row=mysql_fetch_assoc($res);
	$tasca	  = mysql_real_escape_string($row['tasca']);
	$projecte = $row['projecte'];
	$area	  = $row['area'];

	mysql_query("INSERT INTO acabades (tasca,projecte,area) VALUES ('$tasca','$projecte','$area')") or exit(mysql_error());
}


echo "Esborrant tasca...";

//esborra si està en el pla setmanal
mysql_query("DELETE FROM pla_setmanal WHERE id_tasca=$id") or exit(mysql_error());

//esborra si hi ha deadlines
mysql_query("DELETE FROM deadlines WHERE id_tasca=$id") or exit(mysql_error());

//esborra la tasca en si
mysql_query("DELETE FROM tasques WHERE id=$id") or exit(mysql_error());

echo "ok";

?>
