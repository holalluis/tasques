<?php
/*
	run "git pull" to update the app
*/

	//the command (windows)
	$command='"C:\Program Files (x86)\Git\bin"\git pull';

	//show command
	echo "<h2>Executing: '".str_replace('"','',$command)."'</h2>";
?>

<hr><div><code>
<?php 
	//execute command
	$result=exec($command);

	//show output
	echo $result;

	//show warning if command fails
	if($result=="")
	{
		?>
		<h4>Error. Make sure you have <a href=https://git-scm.com/>git</a> installed in your computer</h4>
		<?php
	}
?></code></div><hr>

<button onclick="window.location='index.php'">Go to main page</button>
