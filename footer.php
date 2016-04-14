<style>
	#footer {
		clear: both;
		height: 3em;
		font-size:12px;
		margin:1em 0 0 0;
		padding:1em;
		margin-top:10em;
		border-top:1px solid #eee;
	}
</style>
<div id=footer>
	<!--nom del servidor: si sóc jo dirà localhost-->
	Servidor: <b><?php echo $_SERVER['SERVER_NAME']; ?></b>
	| <a href='update.php'>Update</a>
	| <a href="mailto:lbosch@icra.cat">Report a problem / Request new feature</a>
</div>
