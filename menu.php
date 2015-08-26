<!--navegacio-->
<?php
	function creaLink($url,$contingut)
	{
		if($_SERVER['PHP_SELF']=="/tasques/$url")
		{
			echo "<a style=cursor:pointer>$contingut</a>";
		}
		else 
			echo "<a href='$url'>$contingut</a>";
		echo " | ";
	}
?>
<div>
	<?php 
		creaLink("index.php",			"Tasques (".mysql_num_rows(mysql_query("SELECT 1 FROM tasques")).")");
		creaLink("pla.php",				"Pla Setmanal (".mysql_num_rows(mysql_query("SELECT 1 FROM pla_setmanal")).")");
		creaLink("deadlines.php",		"Dates Límit (".mysql_num_rows(mysql_query("SELECT 1 FROM deadlines")).")");
		creaLink("periodiques.php",		"Tasques Periòdiques");
		creaLink("imprimibleMenu.php",	"Imprimir");
	?>
</div>
