<?php  ob_start();
	if (!session_id()) session_start();
	if(!$_SESSION['adminid'] )
			header("location:index.php");
	require ("../Includes/AdminCommonIncludes.php");
	require ("../Controllers/AdminController.php");
	$adminControllerObj = new AdminController();
	if($_SERVER['REMOTE_ADDR'] == '172.21.4.195'){
		//echo'<pre>session';print_r($_SESSION);echo'</pre>';
	} 
	$msg 		= '';
	$class  	= '';
	$pwd    	= '';
	$user   	= '';
	$username 	= $_SESSION['adminusername'];
	$email 	  	= $_SESSION['emailAddress'];
	
	if(isset($_POST['passwordSubmit']) && $_POST['passwordSubmit']!='')
	{
		if(isset($_POST['old_password']) &&  $_POST['old_password'] != '')
		{
			if($_SESSION['adminpassword'] == $_POST['old_password'] )
			{
				$_POST['old_password'] = $_SESSION['adminpassword'];
				if($_POST['new_password'] == $_POST['confirm_password'] )
				{
					$pwd = escapeSpecialCharacters($_POST['new_password']);
				}
			}
			else
			{
				header("Location:change_password.php?cs=1&msg=2");
				die();
			}
		}
		else
		{
			$pwd = $_SESSION['adminpassword'];
		}
		$updateId = $adminControllerObj->updatePassword($_SESSION['adminusername'],$pwd,$_SESSION['adminid']);
		$_SESSION['adminpassword'] = $pwd;
		header("Location:change_password.php?cs=1&msg=1");
		die();
	}	
	if(isset($_GET['msg']) && $_GET['msg'] == '1') {
		$class = "success_msg";
		$msg = '<strong>Account Updated Successfully&nbsp;</strong>';
	}
	else if(isset($_GET['msg']) && $_GET['msg'] == '2') {
		$class = "error_msg";
		$msg = '*&nbsp;Old Password is incorrect';
	}
	adminHeaderInclude();?>
	<table cellpadding="0" cellspacing="0" width="100%" class="border_outer">
		<tr><td class="title">Change Password</td></tr>
		<tr><td height="20"></td></tr>
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%" class="border" align="center">						
				<tr><td>
					<form name="change_password_form" id="change_password_form" method="post" action="" enctype="multipart/form-data">
						<table cellpadding="0" cellspacing="0" width="95%" align="center" class="filter">
							<tr><td colspan="2"></td></td><td ><div id="validate_msg_container"  class="<?php echo $class; ?>" ><?php echo $msg; ?></div></td></tr>
							<tr><td height="7"></td></tr>
							<tr>
								<th align="left" valign="top" width="15%">User Name</th>
								<th align="center" valign="top" width="5%">:</th>
								<td align="left"><input readonly="true" type="text" class="w230" tabindex="1" name="name" id="name" value="<?php echo $username; ?>" maxlength="30"/>
									<div id="name_msg_container"><div id="name_msg" class="error_msg"></div></div>
								</td>
							</tr>
							<tr><td height="7"></td></tr>
							<tr>
								<th align="left" valign="top">Email</th>
								<th align="center" valign="top">:</th>
								<td><input  type="text" class="w230" tabindex="2" name="email" id="email" value="<?php echo $email; ?>" maxlength="100"  />
								<div id="email_msg_container"><div id="email_msg" class="error_msg"></div></div></td>
							</tr>
							<tr><td height="7"></td></tr>
							<tr>
								<th align="left" valign="top">Old Password</th>
								<th align="center" valign="top">:</th>
								<td align="left"><input type="password" tabindex="3" onpaste="return false;" name="old_password" id="old_password" value="" maxlength="30" class="w230"  />
								<div id="old_password_msg_container"><div id="old_password_msg" class="error_msg"></div></div></td>
							</tr>
							<tr><td height="7"></td></tr>
							<tr>
								<th align="left" valign="top">New Password</th>
								<th align="center" valign="top">:</th>
								<td align="left"><input  type="password" tabindex="4" onpaste="return false;" name="new_password" id="new_password" value="" maxlength="30" class="w230"  />
								<input type="hidden" id="imageval_2" name="imageval_2" value="">
								<div id="new_password_msg_container"><div id="new_password_msg" class="error_msg"></div></div></td>
							</tr>
							<tr><td height="7"></td></tr>
							<tr>
								<th align="left" valign="top">Confirm Password</th>
								<th align="center" valign="top">:</th>
								<td align="left"><input   type="password" tabindex="5" onpaste="return false;" name="confirm_password" id="confirm_password" value="" maxlength="30" class="w230" />
								<input type="hidden" id="imageval_3" name="imageval_3" value="">
								<div id="confirm_password_msg_container"><div id="confirm_password_msg" class="error_msg"></div></div></td>
							</tr>
							<tr><td height="7"></td></tr>
							<tr>
								<td colspan="2">&nbsp;</td></td>	
								<td>
								<input type="hidden" id="errorFlag" name="errorFlag" value="0">
								<input type="Submit" class="button" value="Submit" title="Submit" alt="Submit" name="passwordSubmit" id="passwordSubmit" /></td>
							</tr>
					</table>
					</form>
				</td>
				</tr>
			</table>
		</td></tr>
		<tr><td height="20"></td></tr>
	</table>
<?php adminFooterInclude();?>
