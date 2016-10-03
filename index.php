<?php include'connecta_mysql.php'?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Tasques</title>
	<link rel=stylesheet href='estils.css'>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<script src="js/index.js"></script>
	<style>
		.menu * {vertical-align:middle}
	</style>
</head><body><center>
<!--menu--><?php include "menu.php"?>

<!--titol, menú nou projecte i àrees-->
<table cellpadding=0 style=margin:2px><tr>
	<td>
		<!--titol-->
		<h2 style="cursor:pointer;margin-right:4em" onclick="window.location=window.location.pathname">
			Tasques (<?php echo mysql_num_rows(mysql_query("SELECT 1 FROM tasques")) ?>)
		</h2>
	<td class=menu>
		<form action="nouProjecte.php" method=get style="display:inline-block">
			<!-- selecciona area pel nou projecte: SEMPRE OCULT, ja que es selecciona sol (fx mostraArea()) -->
			<select name=area id=area_select style=display:none>
				<?php
					$res=mysql_query("SELECT * FROM arees");
					while($row=mysql_fetch_array($res))
					{
						$area_id=$row['id'];
						$area_nom=$row['nom'];
						echo "<option value=$area_id>$area_nom</option>";
					}
				?>
			</select>
			<input name=nom placeholder="Nou projecte" 
				autocomplete=off required 
				style="padding:0.5em;border:1px solid #ccc"><!--
			--><button type=submit style="height:2.28em;border-radius:0;margin-left:-1px">OK</button> 
		</form>
	<td class=menu>
		<!--arees-->
		<span title="Una àrea és un conjunt de projectes"> Àrea </span> 
		<?php
			$res=mysql_query("SELECT * FROM arees");
			$n_arees=mysql_num_rows($res);
			$i_area=1;
			while($row=mysql_fetch_array($res))
			{
				$area_nom=$row['nom'];
				$area_id=$row['id'];
				switch($i_area)
				{
					case 1:$classe_boto_area="esquerre";break;
					case $n_arees:$classe_boto_area="dreta";break;
					default:$classe_boto_area="";break;
				}
				echo "<button 
						class='boto_area $classe_boto_area' 
						id=boto_area$area_id 
						onclick=mostraArea($area_id) 
						>$area_nom</button>";
				$i_area++;
			}
		?>
		<!--editar arees-->
		<a title="Configuració" style="font-size:25px;border:1px solid #ccc;border-radius:0.4em" href="editaArees.php">&#9998;</a>
	<td class=menu>
		<!--show legend-->
		<a style="font-size:14px;border:1px solid;padding:0.5em;border-radius:0.4em" href=# onclick=llegenda()>Veure Llegenda</a>
</table>

<!--legend-->
<div id=llegenda title=Llegenda style=display:none>
	<style>
		#llegenda span {border:1px solid #ccc;padding:0.3em}
		#llegenda table {margin:0;padding:0;font-size:12px}
	</style>
	<table> <tr>
			<th>Llegenda &emsp;&emsp;
			<td><span style="background:white"		> Projecte 			   </span>
			<td><span style="background:lightblue"	> Tasca				   </span>
			<td><span style="background:#af0"		> En espera      </span>
			<td><span style="background:orange;border-radius:0.3em;font-weight:bold"	    > Tasca programada (dia de la setmana)    </span>
			<td><span style="background:#f78181;border-radius:0.3em;font-weight:bold"	> Data límit (dies que falten) </span>
	</table>
</div>

<!--tasques--><?php include 'taulaTasques.php'?>
<!--fi pagina--><?php include 'footer.php'?>

<!--ressalta visualment les tasques del pla setmanal i deadlines-->
<script>
<?php
	//TASQUES QUE SON DINS DEL PLA SETMANAL
	$res=mysql_query("SELECT * FROM pla_setmanal");
	while($row=mysql_fetch_array($res))
	{
		echo "tascaProgramada(".$row['id_tasca'].",".$row['dia'].");\n";
	}

	//TASQUES QUE TENEN DATA LIMIT 
	$res=mysql_query("SELECT id,id_tasca,deadline FROM deadlines");
	while($row=mysql_fetch_array($res))
	{
		echo "tascaDeadline(".$row['id_tasca'].",'".$row['deadline']."',".$row['id'].");\n";
	}

	/* Processa arguments GET "ressalta" i "area" */

	//argument index.php?area=a, mostra area, sino, mostra la que té id més petita
	$area=isset($_GET['area']) ? $_GET['area'] : current(mysql_fetch_array(mysql_query("SELECT MIN(id) FROM arees")));
	echo "mostraArea($area);"; 

	//argument index.php?ressalta=p, ressalta el projecte especificat
	if(isset($_GET['ressalta'])) echo "ressalta(".$_GET['ressalta'].");"; 
?>
</script>
