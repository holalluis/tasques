<?php

/*
	Mou una tasca del pla setmanal al dia següent
*/

//connecta a la base de dades
include 'connecta_mysql.php';

//ENTRADA: tasca del pla setmanal
$id=$_GET['id'];

//Canviant dia del pla setmanal...";
mysql_query("UPDATE pla_setmanal SET dia=dia+1 WHERE id=$id") or die('error');

echo "ok";

//ves enrere si tot ha anat bé
header("location: pla.php");

?>
