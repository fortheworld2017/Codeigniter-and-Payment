<?php 
class CardGroupsModel extends Model
{
	function insertGroup($groupName)
	{
		$sql = " insert into `group` set groupName = ?, modifiedDate = now() ";
		$result 	= $this->insertInto($sql, array($groupName));
		$insertedId = $this->sqlInsertId();
		return $insertedId;
	}
	function insertCardGroupsDetail($template_id, $group_id)
	{
		$sql = " insert into `cardGroups` set fkUserId         = ?,
											  fkCardTemplateId = ?,
											  fkGroupId        = ? ";
		$bindParams = array( $_SESSION['tac_data']['user_id'], 
							 $template_id, 
							 $group_id );
							 
		$result	= $this->insertInto($sql, $bindParams);
		return $result;
	}
	function insertMultipleCardGroups($groups_arr)
	{
		$fields = '';
		$bindParams = array();
		foreach ($groups_arr as $group_row){
			$fields .= "(?,?,?),";
			$bindParams[] = $group_row['user_id'];
			$bindParams[] = $group_row['template_id'];
			$bindParams[] = $group_row['group_id'];
		}
		$fields = trim($fields);
		$fields	=	rtrim($fields, ',');
		
		$sql = "insert into `cardGroups`(fkUserId,fkCardTemplateId,fkGroupId) values ".$fields;
		$result	= $this->insertInto($sql, $bindParams);
		
		return $result;	
	}
	function getCardGroups($tempId)
	{
		$sql = "select * from `cardGroups` where fkCardTemplateId = ? and fkUserId = ? group by fkGroupId ";
		$bindParams = array($tempId, $_SESSION['tac_data']['user_id']);
		$result = $this->sqlQueryArray($sql, $bindParams);
		return $result;
	}
	function deleteCardGroups($tempId)
	{
		$sql = "delete from `cardGroups` where fkCardTemplateId = ? and fkUserId = ? ";
		$bindParams = array($tempId, $_SESSION['tac_data']['user_id']);
		$result = $this->deleteInto($sql);
		return $result;
	}
	function getGroups()
	{
		$sql = "select g.groupName, cg.id, cg.fkGroupId from `group` as g left join `cardGroups` as cg on (g.id = cg.fkGroupId) where cg.fkUserId = ? group by(fkGroupId) ";
		$result = $this->sqlQueryArray($sql, array($_SESSION['tac_data']['user_id']));
		if(count($result) == 0)
			return false;
		else
			return $result;
	}
}
?>
