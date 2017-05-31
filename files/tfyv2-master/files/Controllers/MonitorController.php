<?php 
class MonitorController extends Controller {
	function checkExists($post_array)
	{
		if(!isset($this->MonitorModelObj))
		$this->loadModel('MonitorModel','MonitorModelObj');
		if($this->MonitorModelObj)
		return $this->MonitorModelObj->checkExists($post_array);
	}
	function insertClickDetails($post_array)
	{
		if(!isset($this->MonitorModelObj))
		$this->loadModel('MonitorModel','MonitorModelObj');
		if($this->MonitorModelObj)
		return $this->MonitorModelObj->insertClickDetails($post_array);
	}
	function updateClickcount($post_array)
	{
		if(!isset($this->MonitorModelObj))
		$this->loadModel('MonitorModel','MonitorModelObj');
		if($this->MonitorModelObj)
		return $this->MonitorModelObj->updateClickcount($post_array);
	}
	function getTotalRecordCount()
	{
		if(!isset($this->MonitorModelObj))
		$this->loadModel('MonitorModel','MonitorModelObj');
		if($this->MonitorModelObj)
		return $this->MonitorModelObj->getTotalRecordCount();
	}
	function insertBrowserDetails($browser_array)
	{
		if(!isset($this->MonitorModelObj))
		$this->loadModel('MonitorModel','MonitorModelObj');
		if($this->MonitorModelObj)
		return $this->MonitorModelObj->insertBrowserDetails($browser_array);
	}
	function getSiteVisitDetail($field,$condition, $bindParams = NULL)
	{
		if(!isset($this->MonitorModelObj))
		$this->loadModel('MonitorModel','MonitorModelObj');
		if($this->MonitorModelObj)
		return $this->MonitorModelObj->getSiteVisitDetail($field,$condition, $bindParams);
	}
	function getexitClickDetails($field,$condition, $bindParams = NULL)
	{
		if(!isset($this->MonitorModelObj))
		$this->loadModel('MonitorModel','MonitorModelObj');
		if($this->MonitorModelObj)
		return $this->MonitorModelObj->getexitClickDetails($field,$condition, $bindParams);
	}
	function getInteractionDetails()
	{
		if(!isset($this->MonitorModelObj))
		$this->loadModel('MonitorModel','MonitorModelObj');
		if($this->MonitorModelObj)
		return $this->MonitorModelObj->getInteractionDetails();
	}
	function getSubBusinessCard($fields,$condition, $bindParams = NULL)
	{
		if(!isset($this->MonitorModelObj))
		$this->loadModel('MonitorModel','MonitorModelObj');
		if($this->MonitorModelObj)
		return $this->MonitorModelObj->getSubBusinessCard($fields, $condition, $bindParams);
	}
	function getCardNameByGroup($fields,$condition, $bindParams = NULL)
	{
		if(!isset($this->MonitorModelObj))
		$this->loadModel('MonitorModel','MonitorModelObj');
		if($this->MonitorModelObj)
		return $this->MonitorModelObj->getCardNameByGroup($fields, $condition, $bindParams);
	}
	function getMonitorDetail($field,$condition, $bindParams = NULL)
	{
		if(!isset($this->MonitorModelObj))
		$this->loadModel('MonitorModel','MonitorModelObj');
		if($this->MonitorModelObj)
		return $this->MonitorModelObj->getMonitorDetail($field, $condition, $bindParams);
	}
}
?>