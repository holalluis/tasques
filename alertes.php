<!--mòdul alertes dins el PLA SETMANAL-->
<style>
	#alertes td, #alertes th {
		border:1px solid #ccc;
		font-size:12px
	}
</style>

<table id=alertes cellpadding=5 style="box-shadow:0 4px 3px -3px rgba(0,0,0,0.1)">
	<?php
		//llista de deadlines amb menys de 7 dies
		$sql="	SELECT * 
				FROM deadlines,tasques,projectes
				WHERE 
					id_projecte = projectes.id AND
					deadlines.id_tasca = tasques.id AND
					deadline < DATE_ADD(NOW(), INTERVAL 7 DAY)
				ORDER BY deadline ASC";
		$res=mysql_query($sql) or die("error");
		
		echo "<tr><th colspan=3>ALERTES (".mysql_num_rows($res).")";
	?>
	<tr><th>Tasca<th>Projecte<th>Dies (Data Límit)
		<?php
			while($row=mysql_fetch_array($res))
			{
				$id_tasca 	 = $row['id_tasca'];
				$id_projecte = $row['id_projecte'];
				$nom		 = $row['nom'];
				$descr    	 = $row['descripcio'];
				$deadline	 = $row['deadline'];
				echo "<tr style='background:#f78181'>"; 
				echo "<td>$descr";
				echo "<td><a href=projecte.php?id=$id_projecte>$nom</a>";
				$falten = (strtotime($deadline)-strtotime(date("Y/m/d")))/(60*60*24);

				echo "<td align=center>
					<b style='font-size:".max((80/max($falten,1)),14)."px'>$falten</b> ($deadline)";
			}
		?>
</table>

