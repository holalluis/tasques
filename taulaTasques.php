<div align=left>
<!-- fragment dins la pagina index.php -->
<?php
	//connecta
	include 'connecta_mysql.php';

	//troba tots els PROJECTES que no estan en espera
	$sql="SELECT * FROM projectes ORDER BY id DESC";
	$result=mysql_query($sql) or die(mysql_error());

	//executa el bucle per cada projecte
	while($row=mysql_fetch_array($result))
	{
		$id			= $row['id'];
		$area		= $row['id_area'];
		$nom		= $row['nom'];
		$en_espera  = $row['en_espera'];

		//crea un nou <div> 
		echo "<div class=projecte id=$id area=$area en_espera='$en_espera' style='display:none;box-shadow:0 4px 3px -3px rgba(0,0,0,0.1);'>";

		//taula de tasques
		echo "<table cellpadding=3 style='margin:0em;width:100%'>";

		//primera fila: nom
		echo "<tr><td colspan=3><a href='projecte.php?id=$id'>$nom</a> &verbar; ";

		//si esta en espera, marca-ho i segueix mostrant tasques
		if($en_espera)
		{
			//si esta en espera no mostris totes les tasques
			echo "<code style=color:#aaa>Pausat</code>
				<button onclick=window.location='toggleEnEsperaProjecte.php?id=$id' title='Activar projecte'>&#9654;</button>
			</table></div>";
			continue;
		}
		else
		//si no esta en espera, marca'l com a actiu i mostra el botó de pausa
		{
			echo "<code>Actiu</code>
				<button onclick=window.location='toggleEnEsperaProjecte.php?id=$id' 
					title='Pausar projecte'>
					&#8545;
				</button>";
		}

		//tasques del projecte 
		$sql="SELECT * FROM tasques WHERE id_projecte=$id ORDER BY id ASC";
		$res=mysql_query($sql);
		while($roww=mysql_fetch_array($res))
		{
			$acabada=$roww['acabada'];
			$id_task=$roww['id'];

			//marca en verd si la tasca esta acabada
			if($acabada==1) echo "<tr class=tasca id=tasca$id_task acabada>"; 
			else 			echo "<tr class=tasca id=tasca$id_task >";

			//descripcio
			echo "<td>";
			echo $roww['descripcio'];

			//checkbox per tasca acabada
			echo "<td align=center width=1>";
			if($acabada==1)
			{
				echo "<input type=checkbox onclick=modificaTasca($id_task,0,this) checked=true>";
			}
			else
			{
				echo "<input type=checkbox onclick=modificaTasca($id_task,1,this)>";
			}

			//botó esborrar
			echo "<td align=center width=1> <button 
							onclick=esborraTasca($id_task)
							style='background-color:#e50;font-size:10px' >
							Esborra</button>";
		}
		//formulari nova tasca
		echo "<tr><td colspan=2>
				<form action=novaTasca.php method=get id=form_nt_pr_$id >";

		//input hidden amb el valor de l'id projecte
		echo "<input name=id_projecte value=$id style=display:none>";

		//input nova tasca
		echo "<input 	name=descripcio 
						placeholder='Nova tasca' 
						autocomplete=off 
						style='border:1px solid #ccc;padding:0.2em;' 
						required ";
		//donar focus a <input> nova tasca si es el projecte ressaltat
		//treure ressaltat al treure focus del <input>
		if(isset($_GET['ressalta']) && $_GET['ressalta']==$id)
		{
			echo "id=focus onblur=ressalta_off($id) ";
		}
		echo ">";

		//submit nova tasca
		echo "<td><button type=submit style=font-size:10px>Ok</button>";

		//input hidden amb la seguent url a anar despres d'insertar una nova tasca
		echo "<tr style=display:none><td><input name=url_seguent value='index.php?area=$area&ressalta=$id'>";

		echo "</form>";
		echo "</table>";
		echo "</div>";
	}
?>
</div>
