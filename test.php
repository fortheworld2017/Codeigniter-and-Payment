<?php
if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS']==""){
	$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	header("Location: $redirect");
}
echo ' this is test php file from Vincent';
?>