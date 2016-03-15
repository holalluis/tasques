<?php
/*
	run "git pull" to update the app
*/
//build shell command
$command='"C:\Program Files (x86)\Git\bin"\git pull';
echo "<h2>Executing: '$command'</h2>";
?>
<hr><div><code><?php passthru($command)?></code></div>
<button onclick="window.location='index.php'">Go to main page</button>
