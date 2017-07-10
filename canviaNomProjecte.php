<?php

/*
	CANVIA EL NOM D'UN PROJECTE
*/

//connectat a la base de dades
include 'connecta_mysql.php';

//ENTRADA: projecte i nou nom
$id=$_GET['id_projecte'];
$nom=mysql_real_escape_string($_GET['nouNom']);

echo "Canviant el nom...";
mysql_query("UPDATE projectes SET nom='$nom' WHERE id=$id") or die('error');

//ves enrere si tot ha anat bé
header("location: projecte.php?id=$id");

?>
