<?php 
class LoginFailsController extends Controller 
{
	private function loadLoginFailsModel()
	{
		if(!isset($this->LoginFailsObj))
			$this->loadModel('LoginFailsModel','LoginFailsModelObj');
		return $this->LoginFailsModelObj;
	}
	
	function getBlockedIPsDetails()
	{
		if($this->loadLoginFailsModel())
			return $this->LoginFailsModelObj->getBlockedIPsDetails();
	}
	
	function getTotalRecordCount()
	{
		if($this->loadLoginFailsModel())
			return $this->LoginFailsModelObj->getTotalRecordCount();
	}
	
	function deleteBlockedIPs($ids)
	{
		if($this->loadLoginFailsModel())
			return $this->LoginFailsModelObj->deleteBlockedIPs($ids);
	}
	
	function isIpBlocked($ip, $admin_page = false)
	{
		if($this->loadLoginFailsModel())
			return $this->LoginFailsModelObj->isIpBlocked($ip, $admin_page);
	}
	
	function insertLoginFail($ip, $login, $page)
	{
		if($this->loadLoginFailsModel())
			return $this->LoginFailsModelObj->insertLoginFail($ip,$login,$page);
	}
	
	function getRemainingDelay($ip)
	{
		if($this->loadLoginFailsModel())
			return $this->LoginFailsModelObj->getRemainingDelay($ip);
	}
}
?>
