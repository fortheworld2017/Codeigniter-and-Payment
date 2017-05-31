<?php ERROR_REPORTING(E_ALL);
require_once('../Controllers/Controller.php');
require_once('../Models/Config/database.php');
require_once('../Models/Config/db_config.php');

global $globalDbManager;
$globalDbManager = new Database();
$globalDbManager->dbConnect = $globalDbManager->connect($dbConfig['hostName'], $dbConfig['userName'], $dbConfig['passWord'], $dbConfig['dataBase']);

require_once('../Models/Model.php');
require_once('../Models/Config/cfg.constants.php');
require_once('../Includes/CommonFunctions.php');?>