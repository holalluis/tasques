<?php include 'connecta_mysql.php' ?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<title>Tasques | Historic</title>
	<link rel=stylesheet href='estils.css'>
	<style>
		td,th{border:1px solid #ccc}
		td{font-size:12px}
	</style>
</head><body><center>
<!--menu--><?php include 'menu.php' ?>
<!--titol--><h2>Històric tasques acabades</h2>

<!--tasques programades per aquesta setmana-->
<table cellpadding=5>
	<tr> <th>Tasca <th>Projecte <th>Àrea <th>Data acabament<th>Opcions
	<tr> <?php
			//totes les tasques del pla setmanal amb tota la seva info associada
			$res=mysql_query("SELECT * FROM acabades ORDER BY acabada DESC") or die(mysql_error());
			while($row=mysql_fetch_assoc($res))
			{
				$id=	   $row['id'];
				$tasca=	   $row['tasca'];
				$projecte= $row['projecte'];
				$area=	   $row['area'];
				$acabada=  $row['acabada'];

				echo "<tr>
					<td>$tasca
					<td>$projecte
					<td>$area
					<td>$acabada
					";

				//esborra de les tasques acabades
				echo "<td> <button onclick=window.location='esborraAcabada.php?id=$id'>Esborra de l'històric</button>";
			}
		?>
</table>

<!--fi pagina--><?php include 'footer.php' ?>
