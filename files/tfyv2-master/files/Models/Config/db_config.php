<?php
/**
 * MySQL server connection information
 * 
 * This file has configuration information to establish connection to the MySQL server
 *	- hostName = mysql server to connect
 *  - userName = database username to login
 *  - passWord = database password to login
 *  - dataBase = database name
 */
if ($_SERVER['HTTP_HOST'] == $_SERVER['TFY_TEST_IP_ADDR']){ // Local
	$dbConfig['hostName'] = 'localhost';
	$dbConfig['userName'] = 'root';
	$dbConfig['passWord'] = 'dbpass';
	$dbConfig['dataBase'] = 'tactify';
}
else
{
	$dbConfig['hostName'] = 'aa1ctdglt33e33u.ctjbugikat2m.us-west-2.rds.amazonaws.com';
	//$dbConfig['hostName'] = 'tactify.db.8558485.hostedresource.com';
	$dbConfig['userName'] = 'tactify';
	$dbConfig['passWord'] = 'T1a2c3t4i5f6Y';
	$dbConfig['dataBase'] = 'tactify'; 
	
	//phpmyadmin: https://sg2nlsmysqladm1.secureserver.net/grid50/167/index.php?uniqueDnsEntry=tactify.db.8558485.hostedresource.com
}
?>
