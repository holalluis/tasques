<?php
/*
	CREA UNA NOVA TASCA DINS UN PROJECTE
*/

//connecta
include 'connecta_mysql.php';

//entrada
$id_projecte=$_GET['id_projecte'];
$descripcio=ucfirst(mysql_real_escape_string($_GET['descripcio']));
$url_seguent=$_GET['url_seguent'];

//si descripcio esta en blanc
if($descripcio=='')
	exit("<script>alert('Descriu la tasca');window.history.go(-1)</script>");

//executa
echo "Creant nova tasca...";
$sql ="INSERT INTO tasques (id,id_projecte,descripcio) ";
$sql.="VALUES (NULL,$id_projecte,'$descripcio')";
mysql_query($sql) or exit('error');

//torna a la pagina que diu la variable $url_seguent
header("location: $url_seguent");
?>
