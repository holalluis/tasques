<?php

/*
	CANVIA EL NOM D'UNA ÀREA
*/

//connectat a la base de dades
include 'connecta_mysql.php';

//ENTRADA: projecte i nou nom
$id=$_GET['id_area'];
$nouNom=mysql_real_escape_string($_GET['nouNom']);

echo "Canviant el nom...";
mysql_query("UPDATE arees SET nom='$nouNom' WHERE id=$id") or die('error');

//ves enrere si tot ha anat bé
header("location: editaArees.php");

?>
