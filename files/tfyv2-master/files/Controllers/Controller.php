<?php class Controller
{
	function loadModel($model_class, $model_obj)
	{
		if ((stristr($_SERVER['REQUEST_URI'], '/Manage/')) || (strstr($_SERVER['REQUEST_URI'], '/Models/'))) {  
		//Admin side 
			require_once('../Models/'.$model_class.'.php');
		}
		else //Client side
			require_once('Models/'.$model_class.'.php');
		if (class_exists($model_class))
		{
			$this->$model_obj =  new $model_class;
			return true;
		}
		else
			return false;
	}
}?>