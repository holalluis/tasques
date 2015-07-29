<?php
/*
	CREA UN NOU PROJECTE A LA BASE DE DADES
*/

//connecta
include 'connecta_mysql.php';

//entrada
$nom=mysql_real_escape_string($_GET['nom']);
$id_area=$_GET['area'];

//check entrada
if($nom=='') die("nom erroni");

//executa
echo "Creant nou projecte...";
$sql ="INSERT INTO projectes (id,nom,id_area) ";
$sql.="VALUES (NULL,'$nom',$id_area)";
mysql_query($sql) or exit('error');

//busca la id del nou projecte
$sql="SELECT MAX(id) FROM projectes";
$result=mysql_query($sql) or exit('erroooor');
$row=mysql_fetch_array($result);
$nou=$row['MAX(id)'];

//torna a la pagina inicial ressaltant el nou projecte creat
header("location: index.php?ressalta=$nou&area=$id_area");

?>
