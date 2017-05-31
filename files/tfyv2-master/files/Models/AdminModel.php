<?php class AdminModel extends Model
{
	function checklogin($userinfo)
	{
		$sql = " select id, username, password, emailAddress from admin where username=? "
			  ." and password = ? ";
		$bindParams = array($userinfo['username'], md5($userinfo['password']));
		$result = $this->sqlQueryArray($sql, $bindParams);
		
		if(count($result) == 0) 
			return false;
		else 
			return $result;
	}
	function getAdminDetail()
	{
		$sql = "select id, username, password, emailAddress from admin";
		$result = $this->sqlQueryArray($sql);
		
		if(count($result) == 0) 
			return false;
		else 
			return $result;
	}
	function updatePassword($username,$password,$admin_id)
	{
		$sql = " update admin set password = ?, username = ? where id = ? ";
		$bindParams = array(escapeSpecialCharacters(md5($password)),
							$username,
							$admin_id);
		$this->updateInto($sql, $bindParams);
	}
}?>