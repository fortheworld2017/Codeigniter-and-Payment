<?php 
class CardDetailsController extends Controller 
{
	function getTotalRecordCount()
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->getTotalRecordCount();
	}
	function checkExist($fields, $condition, $bindParams = null)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->checkExist($fields, $condition, $bindParams);
	}
	function insertCardDetails($post_array,$shorturl)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->insertCardDetails($post_array,$shorturl);
	}
	function updateCardDetails($post_array,$card_id)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->updateCardDetails($post_array,$card_id);
	}
	function getData($fields, $tableName, $condition, $bindParams = NULL)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->getData($fields, $tableName, $condition, $bindParams);
	}
	function getCardList($fields, $condition, $orderBy, $bindParams = NULL)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->getCardList($fields, $condition, $orderBy, $bindParams);
	}
	function deleteCard($cardid)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->deleteCard($cardid);
	}
	function updateCardAdmin($cond,$where, $bindParams = NULL)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->updateCardAdmin($cond,$where, $bindParams);
	}
	function updateShortUrl($card_id, $shorturl)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->updateShortUrl($card_id, $shorturl);
	}
	function getCardDetails($fields, $condition, $orderBy, $bindParams = NULL)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->getCardDetails($fields, $condition, $orderBy, $bindParams);
	}
	function updateCardDesignDetails($post_array)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->updateCardDesignDetails($post_array);
	}
	function updateStickerDesignDetails($post_array, $stick_img_name, $sticker_ext)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->updateStickerDesignDetails($post_array, $stick_img_name, $sticker_ext);
	}
	function updateTagDesignDetails($post_array)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->updateTagDesignDetails($post_array);
	}
	function insertRecentActivityDetails($card_id, $activity, $cardName)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->insertRecentActivityDetails($card_id, $activity, $cardName);
	}
	function getRecentActivityDetails()
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->getRecentActivityDetails();
	}
	function getExistGroupList($chkoutStatus)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->getExistGroupList($chkoutStatus);
	}
	function getOrdersDetail($condition, $bindParams = NULL)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->getOrdersDetail($condition, $bindParams);
	}
	function insertDomainDetails($card_id,$domain_name,$shorturl)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->insertDomainDetails($card_id,$domain_name,$shorturl);
	}
	function checkCardDomain($domain_name,$shorturl)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->checkCardDomain($domain_name,$shorturl);
	}
	function getCardDomain($shorturl)
	{
		if(!isset($this->CardDetailsModelObj))
		$this->loadModel('CardDetailsModel','CardDetailsModelObj');
		if($this->CardDetailsModelObj)
		return $this->CardDetailsModelObj->getCardDomain($shorturl);
	}
}
?>
