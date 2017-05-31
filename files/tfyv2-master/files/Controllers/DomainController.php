<?php 
class DomainController extends Controller 
{
	function getDomainDetails()
	{
		if(!isset($this->DomainModelObj))
		$this->loadModel('DomainModel','DomainModelObj');
		if($this->DomainModelObj)
		return $this->DomainModelObj->getDomainDetails();
	}
	
	function getTotalRecordCount()
	{
		if(!isset($this->DomainModelObj))
		$this->loadModel('DomainModel','DomainModelObj');
		if($this->DomainModelObj)
		return $this->DomainModelObj->getTotalRecordCount();
	}
	function deleteDomain($ids)
	{
		if(!isset($this->DomainModelObj))
		$this->loadModel('DomainModel','DomainModelObj');
		if($this->DomainModelObj)
		return $this->DomainModelObj->deleteDomain($ids);
	}
	function deleteUserDomain($user_id,$ids)
	{
		if(!isset($this->DomainModelObj))
		$this->loadModel('DomainModel','DomainModelObj');
		if($this->DomainModelObj)
		return $this->DomainModelObj->deleteUserDomain($user_id,$ids);
	}
	function assignDomainUser($domain_id,$ids)
	{
		if(!isset($this->DomainModelObj))
		$this->loadModel('DomainModel','DomainModelObj');
		if($this->DomainModelObj)
		return $this->DomainModelObj->assignDomainUser($domain_id,$ids);
	}
	function getDomainInfo($cond, $bindParams = null)
	{
		if(!isset($this->DomainModelObj))
		$this->loadModel('DomainModel','DomainModelObj');
		if($this->DomainModelObj)
		return $this->DomainModelObj->getDomainInfo($cond, $bindParams);
	}
	function getUserDomainInfo($user_id)
	{
		if(!isset($this->DomainModelObj))
		$this->loadModel('DomainModel','DomainModelObj');
		if($this->DomainModelObj)
		return $this->DomainModelObj->getUserDomainInfo($user_id);
	}
	function addDomain($domain_arr)
	{
		if(!isset($this->DomainModelObj))
		$this->loadModel('DomainModel','DomainModelObj');
		if($this->DomainModelObj)
		return $this->DomainModelObj->addDomain($domain_arr);
	}
	function updateUser($update_array,$id)
	{
		if(!isset($this->DomainModelObj))
		$this->loadModel('DomainModel','DomainModelObj');
		if($this->DomainModelObj)
		return $this->DomainModelObj->updateUser($update_array,$id);
	}
	function checkExist($fields, $condition, $bindParams = null)
	{
		if(!isset($this->DomainModelObj))
		$this->loadModel('DomainModel','DomainModelObj');
		if($this->DomainModelObj)
		return $this->DomainModelObj->checkExist($fields, $condition, $bindParams);
	}
	function checkDomainExist($fields, $condition, $bindParams = null)
	{
		if(!isset($this->DomainModelObj))
		$this->loadModel('DomainModel','DomainModelObj');
		if($this->DomainModelObj)
		return $this->DomainModelObj->checkDomainExist($fields, $condition, $bindParams);
	}
}
?>
