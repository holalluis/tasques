<?php include 'connecta_mysql.php' ?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Pàgina principal</title>
	<link rel=stylesheet href='estils.css'>
	<script>
		function esborraDeadline(id)
		{
			window.location="esborraDeadline.php?id="+id
		}
		function modificaTasca(id,acabada,input)
		{
			var sol = new XMLHttpRequest()
			sol.open('GET','modificaTasca.php?id='+id+'&acabada='+acabada,false)
			sol.send()
			//canvia el color de la tasca
			if(sol.responseText=="Modificant tasca...ok")
			{
				var tr = document.getElementById(id)
				if(acabada)
					tr.setAttribute('acabada', true)
				else
					tr.removeAttribute('acabada')
			}
			//canvia el comportament del boto input per modificar tasca (toggle)
			input.setAttribute('onclick','modificaTasca('+id+','+(acabada ? 0 : 1)+',this)')
		}
	</script>
	<style>
		th,td {
			border-radius:0.2em;
			border:1px solid #ccc;
		}
		th{
			font-size:13px;
		}
		tr.tasca > td{
			background-color:#f78181;
			border:none;
		}
		tr[acabada] > td, tr[acabada] > th{
			background-color:#af0;
		}
	</style>
</head><body><center>
<?php include 'menu.php' ?>
<h2> Dates límit (<?php echo mysql_num_rows(mysql_query("SELECT 1 FROM deadlines")) ?>) </h2>

<table cellpadding=5 style="box-shadow:0 4px 3px -3px rgba(0,0,0,0.1)">
	<tr>
		<th>Tasca
		<th>Projecte
		<th>Dies (Data Límit)
		<th>Completada
		<th>Opcions
	<?php
		$sql="SELECT 
					deadlines.id 			AS id_deadline,
					deadlines.id_tasca		AS id_tasca,
					deadlines.deadline		AS deadline,
					tasques.id_projecte		AS id_projecte,
					tasques.descripcio		AS descripcio,
					tasques.acabada			AS acabada,
					projectes.nom			AS nom_projecte
				FROM 
					deadlines,tasques,projectes 
				WHERE 
					deadlines.id_tasca=tasques.id AND
					tasques.id_projecte=projectes.id
				ORDER BY deadline ASC";
		$result = mysql_query($sql);
		while($row=mysql_fetch_array($result))
		{
			$id_deadline=	$row['id_deadline'];
			$id_tasca=		$row['id_tasca'];
			$deadline=		$row['deadline'];
			$id_projecte=	$row['id_projecte'];
			$descripcio=	$row['descripcio'];
			$acabada=		$row['acabada'];
			$nom_projecte=	$row['nom_projecte'];

			//marca en verd si la tasca esta acabada
			if($acabada==1) echo "<tr id=$id_tasca class=tasca acabada=true>"; 
			else 			echo "<tr id=$id_tasca class=tasca>";

			echo "<td>$descripcio";
			echo "<td><a href=projecte.php?id=$id_projecte>$nom_projecte</a>";

			//dies que falten
			$falten = (strtotime($deadline)-strtotime(date("Y/m/d")))/(60*60*24);
			echo "<td align=center>
				<b style='font-size:".max((80/max($falten,1)),14)."px'>$falten</b> ($deadline)";

			//botó per marcar la tasca completada
			echo "<td align=center>";
			if($acabada==1)
				echo "<input type=checkbox onclick=modificaTasca($id_tasca,0,this) checked=true>";
			else
				echo "<input type=checkbox onclick=modificaTasca($id_tasca,1,this)>";

			//accions: eliminar deadline
			echo "<td align=center>
					<button onclick=esborraDeadline($id_deadline)
						style='font-size:10px'
						>X</button>";
		}
	?>
</table>
