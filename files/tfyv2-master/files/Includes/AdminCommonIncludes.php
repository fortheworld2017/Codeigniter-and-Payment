<?php ERROR_REPORTING(E_ALL);
require_once('../Controllers/Controller.php');
require_once('../Models/Config/database.php');
require_once('../Models/Config/db_config.php');
require_once('../Models/Config/cfg.constants.php');
global $globalDbManager;
$globalDbManager = new Database();
$globalDbManager->dbConnect = $globalDbManager->connect($dbConfig['hostName'], $dbConfig['userName'], $dbConfig['passWord'], $dbConfig['dataBase']);

require_once(ABS_PATH.'WebResources/AWS/aws-autoloader.php');
use Aws\S3\S3Client;

$client = S3Client::factory(array(
    'key'    => $_SERVER['AWS_ACCESS_KEY_ID'],
    'secret' => $_SERVER['AWS_SECRET_KEY']
));
;
// Register the stream wrapper from an S3Client object
$client->registerStreamWrapper();

require_once('../Models/Model.php');
require_once('../Includes/CommonFunctions.php');
require_once('../Includes/AdminTemplates.php');
?>