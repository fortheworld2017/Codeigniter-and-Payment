<?php class MonitorModel extends Model
{
	function checkExists($post_array)
	{
		$sql = "select id from `monitorClicks` where fkCardDetailsId = ? and fkUserId = ? ";
		$bindParams = array($post_array['card_id'], $post_array['user_id']);
		$result = $this->sqlQueryArray($sql, $bindParams);
		return $result;
	}
	function insertClickDetails($post_array)
	{
		$field = "`".$post_array['name']."` = 1";
		$sql = "insert into `monitorClicks` set		fkUserId		=	?,
													fkCardDetailsId	=	?,
													shortUrl		=	?, ".$field;
		$bindParams = array($post_array['user_id'],
							$post_array['card_id'],
							$post_array['short_url']);
		$result 	= $this->insertInto($sql, $bindParams);
		$insertedId = $this->sqlInsertId();
		return $insertedId;
	}
	function updateClickcount($post_array)
	{
		$field	= $post_array['name'];
		$sql	= "update `monitorClicks` set $field = $field+1 where fkCardDetailsId = ? and fkUserId = ? ";
		$bindParams = array($post_array['card_id'], $post_array['user_id']);
		$result	= $this->updateInto($sql, $bindParams);
		return $result;
	}
	function getTotalRecordCount()
	{
		$result = $this->sqlCalcFoundRows();
		return $result;
	}
	function insertBrowserDetails($browser_array)
	{
		$sql = "insert into `siteVisit` set	fkUserId		=	?,
											fkCardDetailsId	=	?,
											shortUrl		=	?,
											browser			=	?,
											browserName		=	?,
											browsedDate		=	now()";
		
		$bindParams = array($browser_array['user_id'],
							$browser_array['card_id'],
							$browser_array['shortUrl'],
							$browser_array['browser'],
							$browser_array['browser_name']);
		
		$result 	= $this->insertInto($sql, $bindParams);
		$insertedId = $this->sqlInsertId();
		return $insertedId;
	}
	function getSiteVisitDetail($field,$condition, $bindParams = NULL)
	{
		$sql = "select ".$field."  from `siteVisit` where 1 ".$condition;
		$result = $this->sqlQueryArray($sql, $bindParams);
		if(count($result) == 0) return false;
		else return $result;
	}
	function getexitClickDetails($field, $condition, $bindParams = NULL)
	{
		$sql = "select ".$field." from `monitorClicks` where 1 ".$condition;
		$result = $this->sqlQueryArray($sql, $bindParams);
		if(count($result) == 0) return false;
		else return $result;
	}
	function getInteractionDetails()
	{
		$sql = "SELECT count(st.id) as points, cd.company, ct.cardType FROM `siteVisit` as st left join `cardDetails` as cd on(st.fkCardDetailsId = cd.id) left join cardTemplate as ct on (ct.id = cd.fkCardTemplateId) WHERE st.fkUserId = ? group by st.shortUrl order by points desc";
		$result = $this->sqlQueryArray($sql, array($_SESSION['tac_data']['user_id']));
		if(count($result) == 0) return false;
		else return $result;
	}
	function getSubBusinessCard($fields,$condition, $bindParams = NULL)
	{
		$sql = "SELECT ".$fields." FROM `cardGroups` as cg  LEFT JOIN `group` as g on (cg.fkGroupId = g.id)  WHERE ".$condition." GROUP BY (g.id) ORDER BY g.id";
		$result = $this->sqlQueryArray($sql, $bindParams);
		if(count($result) == 0)
			return false;
		else
			return $result;
	}
	function getCardNameByGroup($fields,$condition, $bindParams = NULL)
	{
		$sql = "SELECT ".$fields." from `cardDetails` as cd left join `cardGroups` as cg on (cg.fkCardTemplateId = cd.fkCardTemplateId) left join `group` as g on (g.id = cg.fkGroupId) WHERE ".$condition;
		echo '<br>'.$sql;
		$result = $this->sqlQueryArray($sql, $bindParams);
		if(count($result) == 0)
			return false;
		else
			return $result;
	}
	function getMonitorDetail($field,$condition, $bindParams = NULL)
	{
		$sql = "select ".$field."  from `siteVisit` where 1 ".$condition;
		echo '<br>---'.$sql;
		$result = $this->sqlQueryArray($sql, $bindParams);
		if(count($result) == 0) return false;
		else return $result;
	}
}
?>