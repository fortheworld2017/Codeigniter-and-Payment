<?php 
class CardTemplateController extends Controller 
{
	function insertCardTemplate($post_array)
	{
		if(!isset($this->CardTemplateModelObj))
		$this->loadModel('CardTemplateModel','CardTemplateModelObj');
		if($this->CardTemplateModelObj)
		return $this->CardTemplateModelObj->insertCardTemplate($post_array);
	}
	function getSelectedOptions($template_id)
	{
		if(!isset($this->CardTemplateModelObj))
		$this->loadModel('CardTemplateModel','CardTemplateModelObj');
		if($this->CardTemplateModelObj)
		return $this->CardTemplateModelObj->getSelectedOptions($template_id);
	}
	function updateCardTemplate($post_array,$template_id)
	{
		if(!isset($this->CardTemplateModelObj))
		$this->loadModel('CardTemplateModel','CardTemplateModelObj');
		if($this->CardTemplateModelObj)
		return $this->CardTemplateModelObj->updateCardTemplate($post_array,$template_id);
	}
	function getSelectedOptionsByCard($cardId)
	{
		if(!isset($this->CardTemplateModelObj))
		$this->loadModel('CardTemplateModel','CardTemplateModelObj');
		if($this->CardTemplateModelObj)
		return $this->CardTemplateModelObj->getSelectedOptionsByCard($cardId);
	}
}
?>
