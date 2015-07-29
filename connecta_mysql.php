<?php
/*
 * Connecta a la base de dades lbosch
 *
 */

mysql_connect("127.0.0.1","root","") or exit("error de connexió");
mysql_select_db("lbosch");

/*
 * SEGURETAT: impedeix als altres servidors que no siguin el localhost fer modificacions
 *
 */
if($_SERVER['SERVER_NAME']!='localhost') 
{
	if(isset($_GET['pass']) && $_GET['pass']=='bol729sh')
	{
		; //continua
	}
	else
		exit('ERROR. No tens permis per veure aquesta pagina. Escriu password a la url.');
}

?>
