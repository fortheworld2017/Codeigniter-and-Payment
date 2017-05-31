<?php 
class AdminController extends Controller {
	function checkLogin($login_info)
	{
		if(!isset($this->AdminModelObj))
		$this->loadModel('AdminModel','AdminModelObj');
		if($this->AdminModelObj)
		return $this->AdminModelObj->checkLogin($login_info);
	}
	
	function getAdminDetail()
	{
		if(!isset($this->AdminModelObj))
		$this->loadModel('AdminModel','AdminModelObj');
		if($this->AdminModelObj)
		return $this->AdminModelObj->getAdminDetail();
	}
	function updatePassword($username,$password,$admin_id)
	{
		if(!isset($this->AdminModelObj))
		$this->loadModel('AdminModel','AdminModelObj');
		if($this->AdminModelObj)
		return $this->AdminModelObj->updatePassword($username,$password,$admin_id);
	}
}?>