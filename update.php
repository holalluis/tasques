<?php
/*
	run "git pull" to update the app
*/

	//try this two commands
	$com1='"C:\Program Files (x86)\Git\bin"\git pull';
	$com2='"C:\Program Files\Git\bin"\git pull';

	//show command
	echo "<h2>Executing: git pull</h2>";
?>

<hr><div><code>
<?php 
	//try two commands $com1 and $com2
	$result=exec($com1);
	if($result=="") 
		$result=exec($com2);

	//show warning if command fails
	if($result=="")
	{
		?>
		<h4>ERROR. Make sure you have <a href=https://git-scm.com/>git</a> installed in the correct folder in your computer</h4>
		I've looked into the following locations without success:
		<ul>
			<?php
				echo "<li>$com1";
				echo "<li>$com2";
			?>
		</ul>
		<?php
	}
	else
	{
		echo "<b>Success</b><br>";
		echo $result;
	}


?></code></div><hr>

<button onclick="window.location='index.php'">Go to main page</button>
