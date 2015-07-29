<?php
/*
	CREA UNA NOVA TASCA PERIODICA
*/

//connecta
include 'connecta_mysql.php';

//entrada: nom i frequencia
$nom=mysql_real_escape_string($_GET['nom']);
$freq=$_GET['freq'];

//inserta
echo "Creant nova tasca periodica...";
$sql ="INSERT INTO periodiques (nom,freq) VALUES ('$nom',$freq)";
mysql_query($sql) or exit('error');

header("location: periodiques.php");

?>
