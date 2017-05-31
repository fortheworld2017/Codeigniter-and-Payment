<?php 
class CardAttemptsController extends Controller 
{
	private function loadCardAttemptsModel()
	{
		if(!isset($this->CardAttemptsObj))
			$this->loadModel('CardAttemptsModel','CardAttemptsModelObj');
		return $this->CardAttemptsModelObj;
	}
	
	function getCardAttemptsFunction()
	{
		if($this->loadCardAttemptsModel())
			return $this->CardAttemptsModelObj->getCardAttemptsFunction();
	}

	function getCardAttemptsDetails()
	{
		if($this->loadCardAttemptsModel())
			return $this->CardAttemptsModelObj->getCardAttemptsDetails();
	}
	
	function getTotalRecordCount()
	{
		if($this->loadCardAttemptsModel())
			return $this->CardAttemptsModelObj->getTotalRecordCount();
	}
	
	function deleteCardAttempts($ids)
	{
		if($this->loadCardAttemptsModel())
			return $this->CardAttemptsModelObj->deleteCardAttempts($ids);
	}

	function isIpBlocked($ip, $admin_page = false)
	{
		if($this->loadCardAttemptsModel())
			return $this->CardAttemptsModelObj->isIpBlocked($ip, $admin_page);
	}
	
	function updateCardAttemptsCount($ip)
	{
		if($this->loadCardAttemptsModel())
			return $this->CardAttemptsModelObj->updateCardAttemptsCount($ip);
	}
	
	function clearCardAttempts($ip)
	{
		if($this->loadCardAttemptsModel())
			return $this->CardAttemptsModelObj->clearCardAttempts($ip);
	}
}
?>
