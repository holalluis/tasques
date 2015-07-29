<?php
/*
	CREA UNA NOVA AREA A LA BASE DE DADES
*/

//connecta
include 'connecta_mysql.php';

//entrada
$nom=mysql_real_escape_string($_GET['nom']);

//check entrada
if($nom=='') die("nom erroni");

//executa
echo "Creant nova area...";
$sql ="INSERT INTO arees (id,nom) VALUES (NULL,'$nom') ";
mysql_query($sql) or exit('error');

header("location: editaArees.php");

?>
