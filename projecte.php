<?php
	include 'connecta_mysql.php';
	//ENTRADA: id projecte
	$id=$_GET['id'];

	//agafa la info del projecte $id
	$sql="SELECT * FROM projectes WHERE id=$id";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$area=$row['id_area'];
?>
<!doctype html><html><head>
	<meta charset=utf-8 />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<title>Tasques | <?php echo $row['nom'] ?></title>
	<link rel=stylesheet href='estils.css'>
	<style> th{ border:1px solid #ccc; } </style>
	<script>
		//variable global: TODO posar on es fa servir
		var id=<?php echo $id ?>;

		function desprograma(id)
		{
			var sol = new XMLHttpRequest()
			sol.open('GET','esborraDelPlaSetmanal.php?id='+id,false)
			sol.send()
			window.location.reload()
		}

		function novaDeadline(tasca)
		//inserta una nova deadline a la base de dades (taula 'deadlines')
		{
			var dl = document.getElementById('deadline_'+tasca).value;
			if(dl=='')
			{
				alert('Data limit buida'); return;
			}
			//nova solicitud per crear una nova deadline
			var sol = new XMLHttpRequest()
			sol.open('GET','novaDeadline.php?id_tasca='+tasca+'&deadline='+dl,false)
			sol.send()
			window.location='deadlines.php'
		}

		function canviaArea()
		{
			var novaArea = document.getElementById('selectArea').value;
			window.location="canviaAreaProjecte.php?novaArea="+novaArea+"&id_projecte="+id;
		}

		function enviaTascaAPlaSetmanal(tasca)
		{
			var dia = document.getElementById('select_dia_pla_setmanal_tasca'+tasca).value;
			var sol = new XMLHttpRequest()
			sol.open('GET','novaTascaPlaSetmanal.php?id_tasca='+tasca+'&dia='+dia,false)
			sol.send()
			window.location.reload()
		}

		function calculaDiesDeadline(id,deadline)
		//posa un quadrat vermell a la tasca per marcar que té deadline
		{
			if(!document.getElementById('tasca'+id)) return

			//calcula els dies
			var dies = Math.ceil(parseInt(new Date(deadline) - new Date())/1000/60/60/24)

			//pinta els dies de vermell 
			document.getElementById('tasca'+id).childNodes[0].innerHTML+=" (<b style=color:red>"+dies+" dies</b>)"
		}
	</script>
	<script src="js/projecte.js"></script>
</head><body onload=document.getElementsByName('descripcio')[0].focus()><center>
<?php include 'menu.php' ?>

<!--titol editable-->
<h2 onclick=editable(this)><?php echo $row['nom'] ?></h2>

<!--tasques del projecte-->
<table cellpadding=7 style="margin:0 2em 0 2em;">
	<tr> <th colspan=3>Tasques <th>Programar al Pla Setmanal <th>Data Límit
	<?php
		//demana a la base de dades totes les tasques del projecte
		$sql="SELECT * FROM tasques WHERE id_projecte=$id";
		$res=mysql_query($sql);
		while($roww=mysql_fetch_array($res))
		{
			$acabada=$roww['acabada'];
			$id_task=$roww['id'];
			$descrip=$roww['descripcio'];

			if($acabada==1) 
				echo "<tr class=tasca id=tasca$id_task acabada>";
			else
				echo "<tr class=tasca id=tasca$id_task >";
				
			echo "<td>"; 

			//descripcio tasca
			echo "$descrip";

			//checkbox per marcar "tasca completada"
			echo "<td class=tasca align=center style=padding:0>";

			if($acabada==1)
				echo "<input type=checkbox onclick=modificaTasca($id_task,0,this) checked=true>";
			else
				echo "<input type=checkbox onclick=modificaTasca($id_task,1,this)>";

			//boto "Fet" que esborra la tasca
			echo "<td class=tasca>";
			echo "<button
					style='background-color:#e50;font-size:11px'
					onclick=esborraTasca($id_task)
					>Esborra
			</button>";

			//comprova si la tasca actual és dins al pla setmanal o no
			$es_al_pla_setmanal = mysql_num_rows(mysql_query("SELECT 1 FROM pla_setmanal WHERE id_tasca=$id_task"));
			echo "<td class=tasca align=center> ";
			if(!$es_al_pla_setmanal)
			{
				echo "<select id=select_dia_pla_setmanal_tasca$id_task class=w>
						<option value=0>Dilluns</option>
						<option value=1>Dimarts</option>
						<option value=2>Dimecres</option>
						<option value=3>Dijous</option>
						<option value=4>Divendres</option>
						<option value=5>Dissabte</option>
						<option value=6>Diumenge</option>
				</select> ";
				echo "<button onclick=enviaTascaAPlaSetmanal($id_task)>ok</button>";
			}else 
			{
				$ress=mysql_query("SELECT dia FROM pla_setmanal WHERE id_tasca=$id_task");
				$row=mysql_fetch_array($ress);
				switch(current($row))
				{
					case 0: $dia="Dilluns"; break;
					case 1: $dia="Dimarts"; break;
					case 2: $dia="Dimecres"; break;
					case 3: $dia="Dijous"; break;
					case 4: $dia="Divendres"; break;
					case 5: $dia="Dissabte"; break;
					case 6: $dia="Diumenge"; break;
				}
				echo "$dia ";
				echo "<button onclick=desprograma($id_task)>Desprograma</button>";
			}

			//comprova si la tasca actual és dins les deadlines o no
			$es_deadline = mysql_num_rows(mysql_query("SELECT 1 FROM deadlines WHERE id_tasca=$id_task"));
			echo "<td class=tasca align=center>";
			//botó nova deadline
			if(!$es_deadline)
			{
				echo "<input type=date id=deadline_$id_task> ";
				echo "<button onclick=novaDeadline($id_task)> ok </button>";
			}
			else 
			{
				echo current(mysql_fetch_array(mysql_query("SELECT deadline FROM deadlines WHERE id_tasca=$id_task")));
			}
		}
	?>
	<!--formulari nova tasca-->
	<tr class=tasca><td colspan=2>
	<form action=novaTasca.php method=get>
		<input 	name=descripcio 
				style='border:1px solid #ccc;padding:0.4em' 
				size=40 placeholder='Nova tasca' autocomplete=off required>
		<td>
			<button type=submit style="width:95%">OK</button>
			<input 	name=id_projecte 
					value=<?php echo $id ?> 
					style=display:none>
			<input 	name=url_seguent 
					value=projecte.php?id=<?php echo $id ?>
					style=display:none>
	</form>
</table>

<!--opcions del projecte-->
<table cellpadding=10 style=margin:1em>
	<tr><th rowspan=3 style=background:#ccc>Opcions
	<!--canvia AREA -->
	<tr><th>
		Àrea actual: 
		<select onchange=canviaArea() id=selectArea>
			<?php
				$area_actual = $row['id_area'];
				$res=mysql_query("SELECT * FROM arees");
				while($row=mysql_fetch_array($res))
				{
					$id_area = $row['id'];
					$nom_area = $row['nom'];

					if($id_area == $area_actual)
						echo "<option value=$id_area selected>$nom_area</option>";
					else
						echo "<option value=$id_area>$nom_area</option>";
				}
			?>
		</select>
	<!--boto esborra projecte -->
	<tr><th>
		<button style=background-color:#f77;padding:0.5em 
			onclick=esborraProjecte()>
			Esborra projecte
		</button>
</table>

<!--fi pagina--><?php include 'footer.php'?>

<script>
	/*
		modifica el select per enviar al pla setmanal seleccionant el dia de la setmana que som avui (0 a 6)
	*/
	var avui=(new Date()).getDay()

	//rectifica el dia fent que dilluns sigui el 0, no el diumenge
	avui==0? avui=6 : avui--

	//canvia el dia seleccionat al menu per enviar la tasca al pla setmanal
	var s = document.getElementsByClassName('w')
	for(var i=0;i<s.length;s[i++].value=avui); //manera hipster de canviar tots els selects de cop!!
</script>

<script>
<?php
	//RESSALTA EN COLOR LES TASQUES QUE SON DINS DEL PLA SETMANAL
	$res=mysql_query("	SELECT id_tasca, id_projecte
						FROM pla_setmanal, tasques
						WHERE tasques.id=id_tasca AND id_projecte=$id");
	while($row=mysql_fetch_array($res))
	{
		$id_tasca=$row['id_tasca'];
		echo "document.getElementById('tasca'+$id_tasca).style.backgroundColor='orange';\n";
	}

	//TASQUES QUE TENEN DATA LIMIT 
	$res=mysql_query("SELECT id_tasca,deadline FROM deadlines");
	while($row=mysql_fetch_array($res))
	{
		echo "calculaDiesDeadline(".$row['id_tasca'].",'".$row['deadline']."');\n";
	}
?>
</script>

