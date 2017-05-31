<?php 
class StaticContentController extends Controller
{
	//Begin: Get StaticContent details
	function getContentdetail($editid)
	{
		if (!isset($this->StaticContentModelObj))
			$this->loadModel('StaticContentModel', 'StaticContentModelObj');
		if ($this->StaticContentModelObj)
			return $this->StaticContentModelObj->getContentdetail($editid);
	}
	//End: Get StaticContent details
	//Begin: Update StaticContent details
	function updateStaticContent($postarray,$editid)
	{
		if (!isset($this->StaticContentModelObj))
			$this->loadModel('StaticContentModel', 'StaticContentModelObj');
		if ($this->StaticContentModelObj)
			return $this->StaticContentModelObj->updateStaticContent($postarray,$editid);
	}
	//End: Update StaticContent details
}
?>