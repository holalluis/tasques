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
		echo " <span style=color:#aaa>&#9474;</span> ";
	}
?>
<div style="
	padding:1em 0;
	margin:0;
	background:#fafafa;
	box-shadow: 0 1px 2px rgba(0,0,0,.1);
	">
	<?php 
		creaLink("index.php",			"Tasques");
		creaLink("pla.php",				"Pla setmanal");
		creaLink("deadlines.php",		"Dates límit");
		creaLink("periodiques.php",		"Tasques periòdiques");
		creaLink("imprimibleMenu.php",	"Imprimir");
		creaLink("historic.php",		"Historic");
	?>
</div>
