<?php include 'connecta_mysql.php' ?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<title>Edita àrees</title>
	<link rel=stylesheet href='estils.css'>
	<script>
		function esborraArea(area)
		//Esborra una area amb tots els seus projectes i tasques
		{
			var confirma1 = confirm("Tots els projectes i les tasques seran esborrats. Continuar?");
			if(confirma1)
			{
				window.location="esborraArea.php?id="+area;
			}
		}

		function novaArea()
		//Crea una nova area
		{
			var nom = prompt("Escriu el nom de la nova àrea");
			if (nom)
			{
				window.location = "novaArea.php?nom="+nom;
			}
		}

		function editaNom(element,area)
		{
			//modifica el comportament onclick del titol
			element.setAttribute('onclick','')
			//crea nou element <input>
			var input=document.createElement('input')
			//guarda el contingut del titol
			var contingut=element.innerHTML
			//omple el input
			input.value=contingut
			//si apreta enter...
			input.setAttribute('onkeydown','if(event.which==13)guarda('+area+')')
			//esborra el titol
			element.innerHTML=''
			//posa l'element input dins el titol
			element.appendChild(input)
			input.select()
			input.focus()
			input.id='nouNom_area'+area
			//crea boto guardar
			var boto=document.createElement('button')
			boto.innerHTML='Guardar canvis'
			boto.setAttribute('onclick','guarda('+area+')')
			element.appendChild(boto)
		}

		function guarda(area)
		{
			var nouNom=encodeURIComponent(document.getElementById('nouNom_area'+area).value)
			window.location='canviaNomArea.php?id_area='+area+'&nouNom='+nouNom
		}
	</script>
</head><body><center>
<?php include 'menu.php' ?>

<h2>Configuració àrees</h2>

<div>Click sobre una àrea per canviar el nom</div>

<button onclick=novaArea() style="margin:4px;padding:0.7em">+Nova àrea</button>

<!--arees-->
<table border=1 cellpadding=10 style=margin:1em>
	<tr><th>Àrea<th>Projectes<th>Accions
	<?php
		$res=mysql_query("SELECT * FROM arees");
		while($row=mysql_fetch_array($res))
		{
			$nom_area=$row['nom'];
			$id_area=$row['id'];
			echo "<tr>";
			echo "<td onclick=editaNom(this,$id_area)>$nom_area";

			//compta el numero de projectes que té cada àrea
			echo "<td>".mysql_num_rows(mysql_query("SELECT 1 FROM projectes WHERE id_area=$id_area"));
			echo "<td><button style=background-color:#f77 onclick=esborraArea($id_area)>Esborra</button>";
		}
	?>
</table>
