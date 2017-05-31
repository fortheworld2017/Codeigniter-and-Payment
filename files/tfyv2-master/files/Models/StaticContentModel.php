<?php 
class StaticContentModel extends Model
{
	//Begin: Get StaticContent details
	function getContentdetail($editid)
	{
		$where_clause		= '';
		$bindParams			= array();
		if($editid!='')
		{
			$where_clause	=	" and id = ? ";
			$bindParams[]	=	$editid;
		}
		
		$sql	=	"select  * from staticContent where 1 $where_clause";
		$result = 	$this->sqlQueryArray($sql, $bindParams);
		if (count($result) == 0) return false;
		return $result;
	}
	//End: Get StaticContent details
	//Begin: Update StaticContent details
	function updateStaticContent($postarray,$editid)
	{
		$sql = "update staticContent SET heading  = ?,
								         content  =	?
										 WHERE id = ?";
		$bindParams = array($postarray['heading'],
							$postarray['Content'],
							$editid);
		$this->updateInto($sql,$bindParams);
	}
	//End: Update StaticContent details
}
?>