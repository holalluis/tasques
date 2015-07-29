<div>
<!-- fragment dins la pagina index.php -->
<?php
	//connecta
	include 'connecta_mysql.php';

	//troba tots els PROJECTES 
	$sql="SELECT * FROM projectes ORDER BY id DESC";
	$result=mysql_query($sql);

	//executa el bucle per cada projecte
	while($row=mysql_fetch_array($result))
	{
		$id=$row['id'];
		$area=$row['id_area'];
		$nom=$row['nom'];

		//crea un nou <div> 
		echo "<div class=projecte id=$id area=$area style=display:none>";

		//taula de tasques
		echo "<table cellpadding=3 style='margin:3px;width:100%'>";

		//primera fila: nom
		echo "<tr>
			<td colspan=3> <a href='projecte.php?id=$id'> $nom </a>";

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
			echo "<td align=center style=padding:0>";
			if($acabada==1)
			{
				echo "<input type=checkbox onclick=modificaTasca($id_task,0,this) checked=true>";
			}
			else
			{
				echo "<input type=checkbox onclick=modificaTasca($id_task,1,this)>";
			}

			//botó esborrar
			echo "<td> <button 
							onclick=esborraTasca($id_task)
							style='background-color:#e50;font-size:10px' >
							Esborra</button>";
		}
		//formulari nova tasca
		echo "<tr><td colspan=2 class=tasca>";
		echo "<form action=novaTasca.php method=get id=form_nt_pr_$id >";

		//input nova tasca
		echo "<input 	name=descripcio 
						placeholder='Nova tasca' 
						autocomplete=off 
						style='border:1px solid #ccc;padding:0.2em;width:95%' 
						required ";
		//donar focus a <input> nova tasca si es el projecte ressaltat
		//treure ressaltat al treure focus del <input>
		if(isset($_GET['ressalta']) && $_GET['ressalta']==$id)
		{
			echo "id=focus onblur=ressalta_off($id) ";
		}
		echo " >";

		//input hidden amb el valor de l'id projecte
		echo "<input name=id_projecte value=$id style=display:none>";

		//submit
		echo "<td class=tasca><button type=submit style='width:95%' >Ok</button>";

		//input hidden amb la seguent url a anar despres d'insertar una nova tasca
		echo "<tr style=display:none><td><input name=url_seguent value='index.php?area=$area&ressalta=$id'>";

		echo "</form>";
		echo "</table>";
		echo "</div>";	//fi div projecte
	}
?>
</div>
