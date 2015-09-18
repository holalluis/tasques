<?php include 'connecta_mysql.php' ?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<title>Tasques | Pla setmanal</title>
	<link rel=stylesheet href='estils.css'>
	<style>
		th,td {
			border-radius:0.2em;
			border:1px solid #ccc;
			font-size:12px;
		}
		th{
			font-size:13px;
		}
		tr.tasca > td, tr.tasca>th{
			background-color:orange;
			border:none;
		}
		tr[acabada] > td, tr[acabada] > th{
			background-color:#af0;
		}
		#periodiques, #alertes {
			display:inline-block;
			vertical-align:top;
			margin:1em;
		}
	</style>
	<script>
		function init()
		{
			ressaltaDiaActual()
		}
		function estatTascaPeriodica(estat,id)
		//seteja un cookie que marqui la tasca com a completada
		{
			//color tasca completada
			var nouColor = estat ? '#af0' : 'lightblue';
			document.getElementById('periodica'+id).style.backgroundColor=nouColor

			//esborra el cookie si la tasca no està completada
			if(estat==false)
			{
				console.log("esborrant cookie periodica"+id)
				document.cookie="periodica"+id+"=false; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
				return
			}

			/*
				Cas on es crea un cookie que dura fins avui a mitjanit
			*/
			var dema = new Date()
			//seteja la hora a les 00:00:00 i suma un dia
			dema.setHours(0)
			dema.setMinutes(0-dema.getTimezoneOffset())
			dema.setSeconds(0)
			dema.setDate(dema.getDate()+1)
			var expires = "expires="+dema.toGMTString();
			var coo = "periodica"+id+"="+estat+"; "+expires+"; path=/";
			document.cookie=coo
		}
		function esborraDelPlaSetmanal(id)
		{
			window.location="esborraDelPlaSetmanal.php?id="+id
		}

		function ressaltaDiaActual()
		//ressalta el dia actual. es podria fer des de php
		{
			var avui = (new Date()).getDay()-1;
			var avuis = document.getElementsByClassName('dia_'+avui);
			for(i=0;i<avuis.length;i++)
			{
				avuis[i].style.border='1px solid #000';
				avuis[i].style.backgroundColor='#f8fa58';
				avuis[i].textContent+=" (AVUI)"
			}
			var dema = (new Date()).getDay();
			var demas = document.getElementsByClassName('dia_'+dema);
			for(i=0;i<demas.length;i++)
			{
				demas[i].textContent+=" (DEMÀ)"
			}
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

		function mouAlDiaSeguent(id)
		{
			window.location="mouTascaAlDiaSeguent.php?id="+id
		}

		function mouAlDiaAnterior(id)
		{
			window.location="mouTascaAlDiaAnterior.php?id="+id
		}
	</script>
</head><body onload=init()><center>
<?php include 'menu.php' ?>

<!--titol-->
<h2> 
	Tasques per aquesta setmana (<?php echo mysql_num_rows(mysql_query("SELECT 1 FROM pla_setmanal")) ?>)
</h2>

<?php
	function espai()
	{
		echo "<tr><td colspan=5 style=border:none;padding:0.4em;background-color:#ddd>";
	}
?>

<!--tasques programades per aquesta setmana-->
<table cellpadding=5>
	<tr> <th>Dia <th>Tasca <th>Projecte <th>Completada <th>Opcions
	<tr> <?php
			//totes les tasques del pla setmanal amb tota la seva info associada
			$res=mysql_query("	SELECT 
									pla_setmanal.id 		AS id,
									pla_setmanal.id_tasca 	AS id_tasca,
									pla_setmanal.dia		AS dia,
									tasques.descripcio		AS descripcio,
									tasques.id_projecte		AS id_projecte,
									tasques.acabada			AS acabada,
									projectes.nom			AS nom_projecte,
									arees.id				AS id_area,
									arees.nom				AS nom_area
								FROM 	
									pla_setmanal,tasques,projectes,arees
								WHERE
									pla_setmanal.id_tasca=tasques.id AND
									tasques.id_projecte=projectes.id AND
									projectes.id_area=arees.id
								ORDER BY dia ASC
								");
			$da=0;
			while($row=mysql_fetch_array($res))
			{
				$id=		  $row['id'];
				$id_tasca=	  $row['id_tasca'];
				$dia=		  $row['dia'];
				$des=		  $row['descripcio'];
				$pro=		  $row['id_projecte'];
				$acabada=	  $row['acabada'];
				$nomProjecte= $row['nom_projecte'];
				$id_area=	  $row['id_area'];
				$nomArea=	  $row['nom_area'];

				//posa un espai si el dia anterior és diferent
				if($da!=$dia) espai();

				//marca en verd si la tasca esta acabada
				if($acabada==1) echo "<tr id=$id_tasca class=tasca acabada=true>"; 
				else 			echo "<tr id=$id_tasca class=tasca>";

				//dia
				switch($dia)
				{
					case 0: $dia_nom="Dilluns";   break;
					case 1: $dia_nom="Dimarts";   break;
					case 2: $dia_nom="Dimecres";  break;
					case 3: $dia_nom="Dijous"; 	  break;
					case 4: $dia_nom="Divendres"; break;
					case 5: $dia_nom="Dissabte";  break;
					case 6: $dia_nom="Diumenge";  break;
				}
				echo "<th class=dia_$dia align=left>$dia_nom";

				//Descripcio de la tasca
				echo "<td>$des";

				//Projecte
				echo "<td align=center> <a href='projecte.php?id=$pro' title='Àrea: $nomArea'>$nomProjecte</a>";

				//Botó per Marcar la tasca completada
				echo "<td align=center>";
				if($acabada==1)
					echo "<input type=checkbox onclick=modificaTasca($id_tasca,0,this) checked=true>";
				else
					echo "<input type=checkbox onclick=modificaTasca($id_tasca,1,this)>";

				//Accions botons: moure tasca al dia següent i anterior, esborrar
				echo "<td align=center>";

				//botons per moure tasques al dia anterior o el seguent
				if($dia!=0)
				{
					//no es poden passar tasques abans de dilluns
					echo "<button 
								onclick=mouAlDiaAnterior($id)
								style=font-size:10px 
								title='Mou al dia anterior'
								>&uarr;
							</button>";
				}
				if($dia!=6)
				{
					//no es poden passar tasques més enllà de diumenge
					echo "	<button 
								onclick=mouAlDiaSeguent($id)
								style=font-size:10px 
								title='Mou al dia següent'
								>&darr;
							</button>";
				}

				//botó esborrar
				echo " 	<button	onclick=esborraDelPlaSetmanal($id_tasca)
								style='font-size:10px;background-color:#e50' 
								title='Esborra del pla setmanal'
								>X
						</button> ";


				//dia anterior
				$da=$dia;
			}
			espai();
		?>
</table>

<!--periodiques i alertes-->
<div style=margin:1em>
	<!--periodiques-->
	<?php include 'funcions.php' ?>
	<table id=periodiques cellpadding=5>
		<tr><th colspan=3 style=background:yellow>Tasques Periòdiques AVUI
		<tr><th>Tasca<th>Freqüència<th>Completada
		<?php
			$dia=date('w'); //0:diumenge, 1:dilluns, 2:dimarts 
			$res=mysql_query("SELECT * FROM periodiques WHERE freq=$dia OR freq=0 ORDER BY freq ASC");
			while($row=mysql_fetch_array($res))
			{
				$id=$row['id'];
				$nom=$row['nom'];
				$freq=$row['freq'];

				//comprova si la tasca està completada
				if(isset($_COOKIE["periodica$id"]) && $_COOKIE["periodica$id"]=="true")
				{
					$checked=$_COOKIE["periodica$id"];
					$color="#af0";
				}
				else
				{
					$checked="false";
					$color="lightblue";
				}

				echo "<tr style=background-color:$color id=periodica$id>";
				echo "<td>$nom";
				echo "<td>".freq($freq);

				echo "<td align=center>";
				if($checked=="true")
					echo "<input checked type=checkbox onchange=estatTascaPeriodica(this.checked,$id)>";
				else	
					echo "<input type=checkbox onchange=estatTascaPeriodica(this.checked,$id)>";
			}
		?>
	</table>

	<!--alertes-->
	<?php include 'alertes.php' ?>
</div>

<script>
	function tascaDeadline(id)
	//posa un quadrat vermell a la tasca per marcar que té deadline
	{
		document.getElementById(id).childNodes[1].innerHTML+=' <span style=font-size:25px;color:red;margin:0>&#9632</span>'
	}

	//marca les tasques que tenen data limit
	<?php
		$res=mysql_query("	
							SELECT 	deadlines.id_tasca AS id
							FROM 	deadlines,pla_setmanal
							WHERE 	deadlines.id_tasca=pla_setmanal.id_tasca
						");
		while($row=mysql_fetch_array($res)) 
			echo "tascaDeadline(".$row['id'].");\n";
	?>
</script>
