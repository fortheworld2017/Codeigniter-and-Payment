<?php class Model extends Database
{
	function Model()
	{
		global $globalDbManager;
		$this->dbConnect = $globalDbManager->dbConnect;
	}
}?>