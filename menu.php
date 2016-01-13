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
		echo " &#9474; ";
		//echo " \ ";
	}
?>
<div style="padding:1em 0 0 0">
	<?php 
		echo "&#9776; "; //"burger" symbol
		creaLink("index.php",			"Tasques");
		creaLink("pla.php",				"Pla setmanal");
		creaLink("deadlines.php",		"Dates límit");
		creaLink("periodiques.php",		"Tasques periòdiques");
		creaLink("imprimibleMenu.php",	"Imprimir");
		creaLink("historic.php",		"Historic");
	?>
</div>

<hr>
