<?php
/*
 * Connecta a base de dades tasques
 *
 */
mysql_connect("127.0.0.1","root","") or exit("error de connexió");
mysql_select_db("tasques");

/*
 * SEGURETAT: impedeix als altres servidors que no siguin el localhost fer modificacions
 *
 */
if($_SERVER['SERVER_NAME']!='localhost') 
{
	if($_SERVER['SERVER_NAME']=="192.168.103.74")
	{
		;//servidor public
	}
	else exit(' ERROR. No tens permis per veure aquesta pagina, no ets localhost');
}

?>
