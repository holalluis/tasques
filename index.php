<?php include 'connecta_mysql.php' ?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Tasques</title>
	<link rel=stylesheet href='estils.css'>
	<script src="js/index.js"></script>
</head><body><center>

<?php include "menu.php" ?>

<!--titol, menú nou projecte i àrees-->
<table style=margin:1em cellpadding=0><tr>
	<td>
		<!--titol-->
		<h2 style=margin-right:4em>
			Tasques (<?php echo mysql_num_rows(mysql_query("SELECT 1 FROM tasques")) ?>)
		</h2>
	<td class=menu>
		<form action="nouProjecte.php" method=get style="display:inline-block">
			<input name=nom placeholder="Nou projecte" 
				autocomplete=off required 
				style="padding:0.5em;border:1px solid #ccc"
			>
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
			<button type=submit>OK</button> 
		</form>
	<td class=menu>
		<!--arees-->
		<span title="Una àrea és un conjunt de projectes">Àrea</span> 
		<?php
			$res=mysql_query("SELECT * FROM arees");
			while($row=mysql_fetch_array($res))
			{
				$area_nom=$row['nom'];
				$area_id=$row['id'];
				echo "<button 
						class=boto_area 
						id=boto_area$area_id 
						onclick=mostraArea($area_id) 
						>$area_nom</button> ";
			}
		?>
		| <a href="editaArees.php">Configuració</a>
		| <a href=# onclick=llegenda()>Llegenda</a>
</table>

<!--llegenda-->
<div id=llegenda
	 title=Llegenda
	 style="display:none;font-size:12px;background-color:#eee;border:1px solid #ccc">
	<table style="margin:0px;padding:0px">
		<tr>
			<td><span style=font-size:20px;color:white>&#9632</span>Projecte 
			<td><span style=font-size:20px;color:lightblue>&#9632</span>Tasca 
			<td><span style=font-size:20px;color:orange>&#9632</span>Tasca al pla setmanal
			<td><span style=font-size:20px;color:red>&#9632</span>Tasca amb data límit
			<td><span style=font-size:20px;color:#af0>&#9632</span>Tasca completada
	</table>
</div>

<!--Taula de projectes i tasques-->
<?php include 'taulaTasques.php' ?>

<!--nom del servidor: si sóc jo dirà localhost-->
<div style=font-size:12px;margin:1em>
	Servidor: <b><?php echo $_SERVER['SERVER_NAME']; ?></b>
</div>

<!-- fi pagina: scripts javascript depenent dels arguments GET "ressalta" i "area" -->
<script>
<?php
	//RESSALTA EN COLOR LES TASQUES QUE SON DINS DEL PLA SETMANAL
	$res=mysql_query("SELECT id_tasca FROM pla_setmanal");
	while($row=mysql_fetch_array($res))
	{
		$id_tasca=$row['id_tasca'];
		echo "document.getElementById('tasca'+$id_tasca).style.backgroundColor='orange';";
	}

	//RESSALTA EN COLOR LES TASQUES QUE TENEN DATA LIMIT 
	$res=mysql_query("SELECT id_tasca FROM deadlines");
	while($row=mysql_fetch_array($res))
	{
		$id_tasca=$row['id_tasca'];
		echo "document.getElementById('tasca'+$id_tasca).childNodes[0].innerHTML+=' <span style=font-size:25px;color:red;margin:0>&#9632</span>';";
	}
?>
</script>

<?php 
	//si es demana una index.php?area=, mostra-la, sino, mostra la que té id més petita
	if(isset($_GET['area']))
	{
		$area=$_GET['area'];
	}
	else
	{
		$res=mysql_query("SELECT MIN(id) FROM arees") or exit('error');
		$row=mysql_fetch_array($res);
		$area=$row['MIN(id)'];
	}
	echo "<script>mostraArea($area)</script>"; 

	//si l'argument index.php?ressalta= està present a la url, ressalta el projecte especificat
	if(isset($_GET['ressalta'])) 
	{
		echo "<script> ressalta(".$_GET['ressalta'].") </script>"; 
	}
?>

