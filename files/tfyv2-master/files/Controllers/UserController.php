<?php 
class UserController extends Controller 
{
	function addUser($signup_arr)
	{
		if(!isset($this->UserModelObj))
		$this->loadModel('UserModel','UserModelObj');
		if($this->UserModelObj)
		return $this->UserModelObj->addUser($signup_arr);
	}
	
	function checkUserNameExist($email)
	{
		if(!isset($this->UserModelObj))
		$this->loadModel('UserModel','UserModelObj');
		if($this->UserModelObj)
		return $this->UserModelObj->checkUserNameExist($email);
	}
	
	function changepassword($password,$email)
	{
		if(!isset($this->UserModelObj))
		$this->loadModel('UserModel','UserModelObj');
		if($this->UserModelObj)
		return $this->UserModelObj->changepassword($password,$email);
	}
	
	function selectEmaiPass($email,$password)
	{
		if(!isset($this->UserModelObj))
		$this->loadModel('UserModel','UserModelObj');
		if($this->UserModelObj)
		return $this->UserModelObj->selectEmaiPass($email,$password);
	}
	function getUserInfo($cond, $bindParams = NULL)
	{
		if(!isset($this->UserModelObj))
		$this->loadModel('UserModel','UserModelObj');
		if($this->UserModelObj)
		return $this->UserModelObj->getUserInfo($cond, $bindParams);
	}
	function updateUser($update_array,$id)
	{
		if(!isset($this->UserModelObj))
		$this->loadModel('UserModel','UserModelObj');
		if($this->UserModelObj)
		return $this->UserModelObj->updateUser($update_array,$id);
	}
	//getTotalRecordCount
	function getTotalRecordCount()
	{
		if(!isset($this->UserModelObj))
		$this->loadModel('UserModel','UserModelObj');
		if($this->UserModelObj)
		return $this->UserModelObj->getTotalRecordCount();
	}
	function getUserDetails($cond, $bindParams = NULL)
	{
		if(!isset($this->UserModelObj))
		$this->loadModel('UserModel','UserModelObj');
		if($this->UserModelObj)
		return $this->UserModelObj->getUserDetails($cond, $bindParams = NULL);
	}
	function getUsersNotInDomain($domain_id)
	{
		if(!isset($this->UserModelObj))
		$this->loadModel('UserModel','UserModelObj');
		if($this->UserModelObj)
		return $this->UserModelObj->getUsersNotInDomain($domain_id);
	}
	function deleteUser($ids)
	{
		if(!isset($this->UserModelObj))
		$this->loadModel('UserModel','UserModelObj');
		if($this->UserModelObj)
		return $this->UserModelObj->deleteUser($ids);
	}
	function updateUserAccount($cond, $id, $bindParams = NULL)
	{
		if(!isset($this->UserModelObj))
		$this->loadModel('UserModel','UserModelObj');
		if($this->UserModelObj)
		return $this->UserModelObj->updateUserAccount($cond, $id, $bindParams);
	}
}
?>
