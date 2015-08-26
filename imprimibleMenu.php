<?php include 'connecta_mysql.php' ?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Selecciona àrea</title>
	<link rel=stylesheet href='estils.css'>
</head><body><center>

<?php include "menu.php" ?>

<div style=margin:50px;font-size:30px>
Selecciona àrea:<br><br>
<table>
<?php
	$res=mysql_query("SELECT * FROM arees");
	while($row=mysql_fetch_array($res))
	{
		$nom=$row['nom'];
		$id=$row['id'];
		echo "<tr><td><button style=font-size:25px onclick=window.location='imprimible.php?area=$id'>$nom</button>";
	}
?>
</table>
</div>
