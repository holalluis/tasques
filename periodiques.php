<?php include 'connecta_mysql.php' ?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<title>Tasques periòdiques</title>
	<link rel=stylesheet href='estils.css'>
	<style>
		th,td{border:1px solid #ccc;font-size:12px}
	</style>
	<script>
		function esborra(id)
		{
			window.location="esborraTascaPeriodica.php?id="+id
		}
	</script>
</head><body><center>
<?php include 'menu.php' ?>
<?php include 'funcions.php' ?>

<!--titol-->
<h2>Tasques periòdiques (<?php echo mysql_num_rows(mysql_query("SELECT 1 FROM periodiques"))?>)</h2>
<h4>Apareixen al pla setmanal</h4>

<!--taula de tasques periodiques-->
<table cellpadding=5>
	<tr><th>Tasca			<th>Freqüència &darr;		<th>Opcions
	<?php
		$result=mysql_query("SELECT * FROM periodiques ORDER BY freq ASC");
		$fa=0; //freq anterior
		while($row=mysql_fetch_array($result))
		{
			$id=$row['id'];
			$nom=$row['nom'];
			$freq=$row['freq'];

			//posa un color de fila diferent segons la freqüència de la tasca
			$color="lightblue";

			//posa un espai si la frequencia és diferent de l'anterior
			if($fa!=$freq) espaiador();

			echo "<tr style=background-color:$color;>";
			echo "<td>$nom";
			echo "<td>".freq($freq);
			echo "<td align=center><button onclick=esborra($id)>Esborra</button>";
			$fa=$freq;
		}
	?>
	<?php espaiador() ?>
	<tr><td>
		<form action=novaTascaPeriodica.php method=GET>
			<input name=nom placeholder="Nova tasca periòdica" required autocomplete=off>
			<td><select name=freq>
				<option value=0><?php echo freq(0) ?>
				<option value=1><?php echo freq(1) ?>
				<option value=2><?php echo freq(2) ?>
				<option value=3><?php echo freq(3) ?>
				<option value=4><?php echo freq(4) ?>
				<option value=5><?php echo freq(5) ?>
				<option value=6><?php echo freq(6) ?>
				<option value=7><?php echo freq(7) ?>
			</select>
		<td align=center><button type=submit>ok</button>
		</form>
</table>
