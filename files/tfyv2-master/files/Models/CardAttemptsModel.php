<?php 
class CardAttemptsModel extends Model
{
	function getCardAttemptsDetails()
	{
		$where			=	'';
		$sorting_clause = 	'';
		$limit_clause 	= 	'';
		$bindParams		=   array();
		
		if(isset($_SESSION['curpage']))
			$limit_clause = ' LIMIT '.(($_SESSION['curpage'] - 1) * ($_SESSION['perpage'])) . ', '. $_SESSION['perpage'];
		if(isset($_SESSION['orderby']) && isset($_SESSION['ordertype']))
			$sorting_clause	.=	' ORDER BY ' . $_SESSION['orderby'] . ' ' . $_SESSION['ordertype'];
		if(isset($_SESSION['ses_filter_ip']))
		{
			$where .= ' and ip LIKE CONCAT("%", ?, "%") ';
			$bindParams[] = $_SESSION['ses_filter_ip'];
		}
		
		$sql	= " select SQL_CALC_FOUND_ROWS * from cardAttempts where 1 ".$where.$sorting_clause.$limit_clause;
		$result = $this->sqlQueryArray($sql, $bindParams);
		if(count($result) == 0)
			return false;
		else 
			return $result;
	}
	
	function getTotalRecordCount()
	{
		$result = $this->sqlCalcFoundRows();
		return $result;
	}
	
	function deleteCardAttempts($ids){
		$sql 	= "delete from `cardAttempts` where id in (?) ";
		$result = $this->deleteInto($sql, array($ids));
		return $result;
	}
	
	/*function getCardAttemptsInfo($cond)
	{
		$sql	= " select * from cardAttempts where 1 ".$cond;
		$result = $this->sqlQueryArray($sql);
		if(count($result) == 0)
			return false;
		else 
			return $result;
	}*/
	
	function isIpBlocked_($ip)
	{
		$sql	= " select attempts from cardAttempts where ip = ? ";
		$result = $this->sqlQueryArray($sql, array($ip));
		
		if( count($result) == 0 || $result[0]->attempts < MAX_CARD_ATTEMPTS )
			return false;
		else
			return true;
	}
	
	function isIpBlocked($ip, $admin_page)
	{
		$adminIPs = array('110.175.83.214',
						  '27.124.58.83',
						  '14.200.158.34');
		
		if( $admin_page && in_array($ip, $adminIPs) )
			return false;
		else
			return $this->isIpBlocked_($ip);
	}
	
	function updateCardAttemptsCount($ip)
	{
		if($this->checkExist($ip))
		{
			$sql 	= " update `cardAttempts` set attempts = attempts + 1, lastAttempt=NOW() where ip = ? ";
			$result = $this->updateInto($sql, array($ip));
		}
		else
		{
			$sql 	= " insert into `cardAttempts`(ip,attempts,lastAttempt) values (?, 1, NOW()) ";
			$result = $this->insertInto($sql, array($ip));
		}
		return $result;
	}
	
	function clearCardAttempts($ip)
	{
		$sql 	= " delete from `cardAttempts` where ip = ? ";
		$result = $this->deleteInto($sql, array($ip));
		return $result;
	}
	
	function checkExist($ip)
	{
		$sql	= " select 1 from cardAttempts where ip = ? ";
		$result = $this->sqlQueryArray($sql, array($ip));
		
		if(count($result) == 0)
			return false;
		else
			return true;
	}
}
?>