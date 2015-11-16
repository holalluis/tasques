<?php

/* modifica un projecte (id) canvia el camp "en_espera" (boolea) */

//ENTRADA: projecte id 
$id=$_GET['id'];

//connecta a la base de dades
include 'connecta_mysql.php';

//Canviant en_espera
mysql_query("UPDATE projectes SET en_espera=NOT(en_espera) WHERE id=$id") or die('error');

echo "ok";

//ves enrere si tot ha anat bé
header("location: ".$_SERVER['HTTP_REFERER']);

?>
