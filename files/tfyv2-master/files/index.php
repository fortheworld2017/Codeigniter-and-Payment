<?php ob_start();
if (!session_id())
 session_start();
if ((isset($_GET['page'])) && ($_GET['page'] != '')) {
	//if($_SERVER['REMOTE_ADDR'] == '172.21.4.135') { echo "<pre>Line : ".__LINE__."<br>FILE : ".__FILE__."<br>"; print_r($_GET); echo "</pre>"; }
	if($_GET['page'] != 'saveInvoice')
		require_once('Includes/CommonIncludes.php');
	if(isset($_GET['shorturl'])){
		require_once('Includes/CommonIncludes.php');
	}
	if(file_exists('Views/'.$_GET['page'].'.php'))
	{
		require_once('Views/'.$_GET['page'].'.php');
	}
	else
	{
		header('Location: '.SITE_PATH.'home');die();
	}
}
else {
	require_once('Includes/CommonIncludes.php');
	header('Location: '.SITE_PATH.'home'); die();
}
?>