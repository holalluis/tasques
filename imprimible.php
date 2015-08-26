<?php
	//entrada
	$area=$_GET['area'];
	//connecta
	include 'connecta_mysql.php';
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Tasques</title>
	<style>
		body{
			font-family:Arial;
			font-size:12px;
			height:210mm; 
			width:297mm; 
			margin:3px;
		}
		td,th{
			height:20px;
			vertical-align:middle;
			overflow-y:hidden;
		}
		table{
			border-collapse:collapse;
			width:100%;
			margin:0;
		}
	</style>
</head><body><center>
<?php include "menu.php" ?>
<!--titol-->
<h3 style=margin:0.1em>
	<?php echo current(mysql_fetch_array(mysql_query("SELECT nom FROM arees WHERE id=$area"))) ?>
</h3>

<table><tr>
	<?php
	//troba tots els PROJECTES de l'area  
	$sql="SELECT * FROM projectes WHERE id_area=$area ORDER BY id DESC";
	$result=mysql_query($sql);
	$projectes=0;
	while($row=mysql_fetch_array($result))
	{
		$id=$row['id'];
		$nom=$row['nom'];

		//nova fila?
		if($projectes%5==0)echo "<tr>";

		//nom projecte
		echo "<td style=padding:0;width:10%><table border=1>";
		echo "<tr><th style=background:lightblue>$nom"; 
		//recorre tasques
		$sql="SELECT * FROM tasques WHERE id_projecte=$id ORDER BY id ASC";
		$res=mysql_query($sql);
		$fila=0; //comptador de files
		while($roww=mysql_fetch_array($res))
		{
			//descripcio tasca
			echo "<tr><td>".$roww['descripcio'];
			$fila++;
		}
		while($fila<10)
		{
			echo "<tr><td style=color:white>I";
			$fila++;
		}
		echo "</table>"; //fi taula tasques
		$projectes++;
	}
	?>
</table>
