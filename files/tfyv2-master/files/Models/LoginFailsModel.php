<?php 
class LoginFailsModel extends Model
{
	function getBlockedIPsDetails()
	{
		$where			=	'';
		$sorting_clause = 	'';
		$limit_clause 	= 	'';
		$bindParams     =   array();
		
		if(isset($_SESSION['curpage']))
			$limit_clause = ' LIMIT '.(($_SESSION['curpage'] - 1) * ($_SESSION['perpage'])) . ', '. $_SESSION['perpage'];
		if(isset($_SESSION['orderby']) && isset($_SESSION['ordertype']))
			$sorting_clause	.=	' ORDER BY ' . $_SESSION['orderby'] . ' ' . $_SESSION['ordertype'];
		if(isset($_SESSION['ses_filter_ip']))
		{
			$where       .= ' and ip  LIKE CONCAT("%", ?, "%") ';
			$bindParams[] = $_SESSION['ses_filter_ip'];
		}
		
		$sql	= " select SQL_CALC_FOUND_ROWS * from blockedIPs where 1 ".$where.$sorting_clause.$limit_clause;
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
	
	function deleteBlockedIPs($ids)
	{
		$sql 	= "delete from `blockedIPs` where id in (?) ";
		$result = $this->deleteInto($sql, array($ids));
		return $result;
	}
	
	function isIpBlocked_($ip)
	{
		/*$sql	= " select max(attempts) as max_attempts from ( "
				. "   select count(1) as attempts from loginFails where ip = '".$ip."' "
				. "      and attempted > Date_sub(Now(), Interval ".LOGIN_FAILS_TIMEOUT_MIN." Minute ) "
				. "    group by page "
				. " ) as attemptsPerPage ";
		*/
		$sql	= " select 1 as blocked from blockedIPs where ip = ? "
				. "    and lastAttempt > Date_sub(Now(), Interval ".LOGIN_FAILS_TIMEOUT_MIN." Minute ) "
				. "  group by page ";
		$result = $this->sqlQueryArray($sql, array($ip));
		
		
		if( count($result) == 0 || !$result[0]->blocked )
			return false;
		else
			return true;
	}
	
	function isIpBlockedInPage_($ip, $page)
	{
		$sql	= " select count(1) as attempts from loginFails where ip = ? "
				. "    and attempted > Date_sub(Now(), Interval ".LOGIN_FAILS_TIMEOUT_MIN." Minute ) "
				. "    and page = ? ";
		$bindParams = array($ip, $page);
		$result = $this->sqlQueryArray($sql, $bindParams);
		
		
		if( count($result) == 0 || $result[0]->attempts < MAX_LOGIN_FAILS )
			return false;
		else
			return true;
	}
		
	function isIpBlocked($ip, $checkAdminIps)
	{
		$adminIPs = array('110.175.83.214',
						  '27.124.58.83',
						  '14.200.158.34');
		
		if( $checkAdminIps && in_array($ip, $adminIPs) )
			return false;
		else
			return $this->isIpBlocked_($ip);
	}
	
	function insertLoginFail($ip, $login, $page)
	{
		$this->clearLoginFails_($ip, $page);
		
		$sql 	= " insert into `loginFails`(ip, login, attempted, page) "
		        . " values (?, ?, NOW(), ?) ";
		$bindParams = array($ip, $login, $page);
		$result = $this->insertInto($sql, $bindParams);
		
		if ($this->isIpBlockedInPage_($ip, $page))
			$this->insertBlockedIp_($ip, $page);
		
		return $result;
	}
	
	function clearLoginFails_($ip, $page)
	{
		$sql 	= " delete from `loginFails` where ip = ? "
				. " and page = ? "
				 ." and attempted < Date_sub(Now(), Interval ".LOGIN_FAILS_TIMEOUT_MIN." Minute)";
		$bindParams = array($ip, $page);
		$result = $this->deleteInto($sql, $bindParams);
		
		return $result;
	}
	
	function insertBlockedIp_($ip, $page)
	{
		$sql 	= " insert into `blockedIPs`(ip, lastAttempt, page) "
		        . " values (?, NOW(), ?) ";
		$bindParams = array($ip, $page);
		$result = $this->insertInto($sql, $bindParams);
		
		return $result;
	}
	
	function getRemainingDelay($ip)
	{
		/*$sql 	= " select time_to_sec(timediff(now(), oldestAttempt))/60 as oldestAttemptMin from ( "
				. "   select min(attempted) as oldestAttempt from `loginFails` where ip = '".$ip."' "
				. "   and attempted > Date_sub(Now(), Interval ".LOGIN_FAILS_TIMEOUT_MIN." Minute) "
				. " ) as minAttempted ";
		*/
		$sql 	= " select time_to_sec(timediff(now(), delayFrameStart))/60 as delayFrameMin from ( "
				. "   select max(lastAttempt) as delayFrameStart from `blockedIPs` where ip = ? "
				. "   and lastAttempt > Date_sub(Now(), Interval ".LOGIN_FAILS_TIMEOUT_MIN." Minute) "
				. " ) as maxLastAttempt ";
		$result = $this->sqlQueryArray($sql, array($ip));
		
		if(count($result) == 0)
			$remaining_delay = '0';
		else
		{
			$roundedDiff = round(LOGIN_FAILS_TIMEOUT_MIN - $result[0]->delayFrameMin);
			if($roundedDiff == 0)
				$remaining_delay = 'less than 1 minute';
			else
				$remaining_delay = 'approximately '.$roundedDiff.' minute(s)';
		}
		

		return $remaining_delay;
	}
}
?>	