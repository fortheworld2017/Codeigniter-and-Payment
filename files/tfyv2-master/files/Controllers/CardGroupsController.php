<?php 
class CardGroupsController extends Controller 
{
	function insertGroup($groupName)
	{
		if(!isset($this->CardGroupsModelObj))
		$this->loadModel('CardGroupsModel','CardGroupsModelObj');
		if($this->CardGroupsModelObj)
		return $this->CardGroupsModelObj->insertGroup($groupName);
	}
	function insertCardGroupsDetail($card_id, $group_id)
	{
		if(!isset($this->CardGroupsModelObj))
		$this->loadModel('CardGroupsModel','CardGroupsModelObj');
		if($this->CardGroupsModelObj)
		return $this->CardGroupsModelObj->insertCardGroupsDetail($card_id, $group_id);
	}
	function insertMultipleCardGroups($fields)
	{
		if(!isset($this->CardGroupsModelObj))
		$this->loadModel('CardGroupsModel','CardGroupsModelObj');
		if($this->CardGroupsModelObj)
		return $this->CardGroupsModelObj->insertMultipleCardGroups($fields);
	}
	function getCardGroups($tempId)
	{
		if(!isset($this->CardGroupsModelObj))
		$this->loadModel('CardGroupsModel','CardGroupsModelObj');
		if($this->CardGroupsModelObj)
		return $this->CardGroupsModelObj->getCardGroups($tempId);
	}
	function deleteCardGroups($tempId)
	{
		if(!isset($this->CardGroupsModelObj))
		$this->loadModel('CardGroupsModel','CardGroupsModelObj');
		if($this->CardGroupsModelObj)
		return $this->CardGroupsModelObj->deleteCardGroups($tempId);
	}
	function getGroups()
	{
		if(!isset($this->CardGroupsModelObj))
		$this->loadModel('CardGroupsModel','CardGroupsModelObj');
		if($this->CardGroupsModelObj)
		return $this->CardGroupsModelObj->getGroups();
	}
}
?>
