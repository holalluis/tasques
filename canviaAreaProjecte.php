<?php

/*
	CANVIA EL CAMP AREA D'UN PROJECTE
*/

//connecta a la base de dades
include 'connecta_mysql.php';

//ENTRADA: id projecte (int) i nova id_area (int)
$id=$_GET['id_projecte'];
$novaArea=$_GET['novaArea'];

echo "Canviant area...";
mysql_query("UPDATE projectes SET id_area=$novaArea WHERE id=$id") or die('error');

//ves enrere si tot ha anat bé
header("location: index.php?area=$novaArea&ressalta=$id");

?>
