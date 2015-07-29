<?php
	function freq($n)
	//Retorna la frequencia (string) de la tasca repetitiva
	//funcio necessaria a "pla.php" i "periodiques.php"
	{
		switch($n)
		{
			case 0: $f="Dies Laborables";break;
			case 1: $f="Cada Dilluns";break;
			case 2: $f="Cada Dimarts";break;
			case 3: $f="Cada Dimecres";break;
			case 4: $f="Cada Dijous";break;
			case 5: $f="Cada Divendres";break;
			case 6: $f="Cada Dissabte";break;
			case 7: $f="Cada Diumenge";break;
			default: $f="error";break;
		}
		return $f;
	}

	function espaiador()
	//crea un espaiador per la taula de tasques periodiques
	//funcio necessaria a "pla.php" i "periodiques.php"
	{
		echo "<tr>
			<td colspan=3 
				style='border:none;
					background-color:#eee;
					border-radius:0;
					padding:0.4em'>";
	}
?>

