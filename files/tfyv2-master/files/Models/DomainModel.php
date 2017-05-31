<?php 
class DomainModel extends Model
{
	function getDomainDetails()
	{
		$where			=	'';
		$sorting_clause = 	'';
		$limit_clause 	= 	'';
		$bindParams     =   array();
		if(isset($_SESSION['curpage']))
			$limit_clause = ' LIMIT '.(($_SESSION['curpage'] - 1) * ($_SESSION['perpage'])) . ', '. $_SESSION['perpage'];
		if(isset($_SESSION['orderby']) && isset($_SESSION['ordertype']))
			$sorting_clause	.=	' ORDER BY ' . $_SESSION['orderby'] . ' ' . $_SESSION['ordertype'];
		
		if(isset($_SESSION['ses_filter_domianName']) && $_SESSION['ses_filter_domianName'] !='')
		{
			$where .= ' and name  LIKE CONCAT("%", ?, "%") ';
			$bindParams[] = $_SESSION['ses_filter_domianName'];
		}
		$sql	= " select SQL_CALC_FOUND_ROWS * from domain where 1 ".$where.$sorting_clause.$limit_clause;
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
	function deleteDomain($ids){
		$sql 	= "delete from `domain` where id in (?)";
		$result = $this->deleteInto($sql, array($ids));
		return $result;
	}
	function deleteUserDomain($user_id,$ids){
		$sql 	= "delete from `userDomains` where fkUserId = ? and fkDomainId in (?)";
		$bindParams = array($user_id, $ids);
		$result = $this->deleteInto($sql, $bindParams);
		
		return $result;
	}
	function assignDomainUser($domain_id,$ids){
		$ids_array = explode(",", $ids);
		$insertedId = array();
		
		foreach($ids_array as $key => $user_id)
		{
			$sql 	= "insert into userDomains set fkUserId   = ?, 
												   fkDomainId = ? ";
			$bindParams = array( $user_id, 
								 $domain_id);
			$result 	= $this->insertInto($sql, $bindParams);
			$insertedId[] = $this->sqlInsertId();
		}
		return $insertedId;
	}
	function getDomainInfo($cond, $bindParams = null)
	{
		$sql	= " select * from domain where 1 ".$cond;
		$result = $this->sqlQueryArray($sql, $bindParams);
		
		if(count($result) == 0)
			return false;
		else 
			return $result;
	}
	function getUserDomainInfo($user_id)
	{
		$userDomainQuery = "select fkDomainId from userDomains where fkUserId = ? ";
		$cond = " and id in (".$userDomainQuery.") ";

		return $this->getDomainInfo($cond, array($user_id));
	}
	function addDomain($domain_arr)
	{
		$sql = " insert into domain set	name = ? ";
		$result 	= $this->insertInto($sql, array($domain_arr['domainName']));
		$insertedId = $this->sqlInsertId();
		return $insertedId;
	}
	function updateUser($update_array,$id){
			$sql = "update `domain` set name = ? where id   = ? ";
			$bindParams = array($update_array['domainName'], $id);
			$this->updateInto($sql);
	}
	function checkExist($fields, $condition, $bindParams = null)
	{
		$sql = "select ".$fields. " from `domain` where 1 and ".$condition;
		$result = $this->sqlQueryArray($sql, $bindParams);
		if(count($result) == 0)
			return false;
		else
			return $result;
	}
	function checkDomainExist($fields, $condition, $bindParams = null)
	{
		$sql = "select ".$fields. " from `domainDetails` as dd left join `domain` as d on(d.name = dd.domainName) where 1 and ".$condition;
		$result = $this->sqlQueryArray($sql, $bindParams);
		if(count($result) == 0)
			return false;
		else
			return $result;
	}
}
?>
