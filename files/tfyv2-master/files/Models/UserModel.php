<?php 
class UserModel extends Model
{
	function addUser($signup_arr)
	{
		$sql = " insert into user set		username 			=	?,
											password			=	?,
											firstName			=	?,
											surName				=	?,
											company				=	?,
											
											telephone			=	?,
											mobile				=	?,
											website				=	?,
											profileImage		=	?,
											profileImageName	=	?,
											
											streetName			=	?,
											city				=	?,
											state				=	?,
											zipCode				=	?,
											country				=	?,
											
											billingStatus		=	?,
											billingStreetName	=	?,
											billingCity			=	?,
											billingState		=	?,
											billingZipCode		=	?,
											billingCountry		=	?,
											email				=	? ";
		
		$bindParams = array(
						escapeSpecialCharacters($signup_arr['userName']),
						MD5($signup_arr['password']),
						escapeSpecialCharacters($signup_arr['firstName']),
						escapeSpecialCharacters($signup_arr['surName']),
						escapeSpecialCharacters($signup_arr['company']),
						
						escapeSpecialCharacters($signup_arr['telephone']),
						escapeSpecialCharacters($signup_arr['mobile']),
						escapeSpecialCharacters($signup_arr['website']),
						escapeSpecialCharacters($signup_arr['image_extension']),
						escapeSpecialCharacters($signup_arr['image_name']),
						
						escapeSpecialCharacters($signup_arr['streetName']),
						escapeSpecialCharacters($signup_arr['city']),
						escapeSpecialCharacters($signup_arr['state']),
						escapeSpecialCharacters($signup_arr['zipCode']),
						escapeSpecialCharacters($signup_arr['country']),
						
						$signup_arr['billingStatus'],
						escapeSpecialCharacters($signup_arr['billingStreetName']),
						escapeSpecialCharacters($signup_arr['billingCity']),
						escapeSpecialCharacters($signup_arr['billingState']),
						escapeSpecialCharacters($signup_arr['billingZipCode']),
						escapeSpecialCharacters($signup_arr['billingCountry']),
						escapeSpecialCharacters($signup_arr['email']));
		
		$result 	= $this->insertInto($sql, $bindParams);
		$insertedId = $this->sqlInsertId();
		return $insertedId;
	}
	function updateUser($update_array,$id){
		
		$sql = "update `user` set 	username 			=	?,
									firstName			=	?,
									surName				=	?,
									company				=	?,
									
									telephone			=	?,
									mobile				=	?,
									website				=	?,
									profileImage		=	?,
									profileImageName	=	?,
									
									streetName			=	?,
									city				=	?,
									state				=	?,
									zipCode				=	?,
									country				=	?,
									
									billingStreetName	=	?,
									billingCity			=	?,
									billingState		=	?,
									billingZipCode		=	?,
									billingCountry		=	?,
									email				=	? ";
		
		$bindParams = array(
						escapeSpecialCharacters($update_array['userName']),
						escapeSpecialCharacters($update_array['firstName']),
						escapeSpecialCharacters($update_array['surName']),
						escapeSpecialCharacters($update_array['company']),
						
						escapeSpecialCharacters($update_array['telephone']),
						escapeSpecialCharacters($update_array['mobile']),
						escapeSpecialCharacters($update_array['website']),
						escapeSpecialCharacters($update_array['image_extension']),
						escapeSpecialCharacters($update_array['image_name']),
						
						escapeSpecialCharacters($update_array['streetName']),
						escapeSpecialCharacters($update_array['city']),
						escapeSpecialCharacters($update_array['state']),
						escapeSpecialCharacters($update_array['zipCode']),
						escapeSpecialCharacters($update_array['country']),
						
						escapeSpecialCharacters($update_array['billingStreetName']),
						escapeSpecialCharacters($update_array['billingCity']),
						escapeSpecialCharacters($update_array['billingState']),
						escapeSpecialCharacters($update_array['billingZipCode']),
						escapeSpecialCharacters($update_array['billingCountry']),
						escapeSpecialCharacters($update_array['email']));
						
		if (isset($update_array['newPassword']) && $update_array['newPassword'] !='')
		{
			$sql .= ', password = ? ';
			$bindParams[] = MD5($update_array['newPassword']);
		}
		
		$sql .= " where id = ? ";
		$bindParams[] = $id;
						
		$this->updateInto($sql, $bindParams);
	}
	//Get user Account Information
	function getUserInfo($cond, $bindParams = NULL)
	{
		$sql	= " select * from user where 1 ".$cond;
		$result = $this->sqlQueryArray($sql, $bindParams);
		if(count($result) == 0)
			return false;
		else 
			return $result;
	}
	//	Start: Check User Email is exist
	function checkUserNameExist($email){
		$cond = '';
		$bindParams = array();
		
		$sql	= " select id, username, password, email from user where email = ? ".$cond;
		$bindParams[] = $email;
		
		if(isset($_SESSION['tac_data']['user_id']) && $_SESSION['tac_data']['user_id'] != '')
		{
			$cond = " and id != ? ";
			$sql .= $cond;
			$bindParams[] = $_SESSION['tac_data']['user_id'];
		}
		$result = $this->sqlQueryArray($sql, $bindParams);
		
		if(count($result) == 0)
			return false;
		else 
			return $result;
	}
	function updateUserAccount($cond, $id, $bindParams = NULL){
		if($bindParams == NULL)
			$bindParams = array();
		$cond 	= 	rtrim($cond,',');
		$sql 	= 	"update `user` set $cond	where id = ? ";
		$bindParams[] = $id;
		$this->updateInto($sql, $bindParams);
	}
	function deleteUser($ids){
		$sql 	= "delete from `user` where id in(?)";
		$result = $this->deleteInto($sql, array($ids));
		return $result;
	}
	function getUserDetails($cond, $bindParams = NULL)
	{
		$where			=	'';
		$sorting_clause = 	'';
		$limit_clause 	= 	'';
		if(!is_array($bindParams))
			$bindParams = array();
		if(isset($cond) && $cond != '')
			$where = $cond;
		
		if(isset($_SESSION['curpage']))
			$limit_clause = ' LIMIT '.(($_SESSION['curpage'] - 1) * ($_SESSION['perpage'])) . ', '. $_SESSION['perpage'];
		if(isset($_SESSION['orderby']) && isset($_SESSION['ordertype']))
			$sorting_clause	.=	' ORDER BY ' . $_SESSION['orderby'] . ' ' . $_SESSION['ordertype'];
		
		if(isset($_SESSION['ses_filter_userName']) && $_SESSION['ses_filter_userName'] !='')
		{
			$where        .= ' and username  LIKE CONCAT("%",?,"%") ';
			$bindParams[]  = $_SESSION['ses_filter_userName'];
		}
		if(isset($_SESSION['ses_filter_email']) && $_SESSION['ses_filter_email'] !='')
		{
			$where        .= ' and email  LIKE CONCAT("%",?,"%") ';
			$bindParams[]  = $_SESSION['ses_filter_email'];
		}
		
		$sql	= " select SQL_CALC_FOUND_ROWS * from user where 1 ".$where.$sorting_clause.$limit_clause;
		$result = $this->sqlQueryArray($sql, $bindParams);
		if(count($result) == 0)
			return false;
		else 
			return $result;
	}
	function getUsersNotInDomain($domain_id)
	{
		$userDomainQuery = "select fkUserId from userDomains where fkDomainId = ? ";
		$cond = " and id not in (".$userDomainQuery.") ";
		return $this->getUserDetails($cond, array($domain_id));
	}
	function getTotalRecordCount()
	{
		$result = $this->sqlCalcFoundRows();
		return $result;
	}
	/*---------------------------------------------------------------------------------------------------------*/
	//Begin: Change Password
	function changepassword($password,$email){
		if( $email!='')
		{
			$sql = " update user set password = ? where email = ? ";
			$bindParams = array(MD5($password), $email);
			$this->updateInto($sql, $bindParams);
		}
	}
	
	//	Start: Check User Email and password is exist
	function selectEmaiPass($email,$password){
		$sql	= " select id, username, password, email from user where email = ? and  password = ? ";
		$bindParams = array($email, MD5($password));
		
		$result = $this->sqlQueryArray($sql, $bindParams);
		
		if(count($result) == 0)
			return false;
		else 
			return $result;
	}
}
?>
