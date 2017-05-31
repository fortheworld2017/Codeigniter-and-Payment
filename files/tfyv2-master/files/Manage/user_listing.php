<?php ob_start();
if (!session_id()) session_start();
if(!isset($_SESSION['adminid'])) header("location:index.php");
require_once('../Includes/AdminCommonIncludes.php');
require_once('../Controllers/UserController.php');
$userControllerObj 	= 	new UserController();
$cond = '';
if(isset($_POST['row_id']) && $_POST['row_id'] != ''){
	$ids = implode(',',$_POST['row_id']);
	$res = $userControllerObj->deleteUser($ids);
	header("Location:user_listing.php?cs=1&del=1");
	die();
}
if(isset($_GET['deleteid']) && $_GET['deleteid'] != ''){
	$res = $userControllerObj->deleteUser($_GET['deleteid']);
	header("Location:user_listing.php?cs=1&del=1");
	die();
}
if(isset($_GET['cs']) && $_GET['cs'] == '1')
{
	destroyPagingControlsVariables();
	unset($_SESSION['ses_filter_userName']);
	unset($_SESSION['ses_filter_email']);
	unset($_SESSION['orderBy']);
	unset($_SESSION['orderType']);
}
if(isset($_POST['search']) && $_POST['search'] != '')
{
	destroyPagingControlsVariables();
	$_SESSION['ses_filter_userName']	=	$_POST['ses_filter_userName'];
	$_SESSION['ses_filter_email']		=	$_POST['ses_filter_email'];
}
if(isset($_POST['sortBy']) && $_POST['sortBy'] != '')
{
	$_SESSION['orderBy']	= 	$_POST['orderBy'];
	$_SESSION['orderType']	= 	$_POST['orderType'];
}
setPagingControlValues('id',ADMIN_PER_PAGE_LIMIT);
$user_details = $userControllerObj->getUserDetails();
$rows = $userControllerObj->getTotalRecordCount();
//echo "<br>++><pre>"; print_r($user_details); echo "</pre><++";
?>

<?php adminHeaderInclude();?>
	<table cellpadding="0" cellspacing="0" width="100%" border="0" align="center"  class="border_outer">
		<tr><td class="title">User List</td></tr>
		<tr><td height="20"></td></tr>
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%"  class="border" align="center">				
				<tr><td>
					<form name="users_search_form" id="users_search_form" method="post" action="user_listing.php?cs=1">
					<table cellpadding="0" cellspacing="0" width="98%" align="center" class="filter">
						<tr><td height="10"></td></tr>
						<tr>
							<th width="10%" align="right">User Name</th>
							<th width="2%" align="center" valign="middle">:</th>
							<td width="27%" align="left"><input type="text" class="w230" name="ses_filter_userName" id="ses_filter_userName" tabindex="1" value="<?php if(isset($_SESSION['ses_filter_userName']) && $_SESSION['ses_filter_userName'] != '') echo unEscapeSpecialCharacters($_SESSION['ses_filter_userName']) ;?>" ></td>
							<th width="5%" align="right">Email Id</th>
							<th width="2%" align="center" valign="middle">:</th>
							<td width="27%" align="left"><input type="text" class="w230" name="ses_filter_email" id="ses_filter_email" tabindex="1" value="<?php if(isset($_SESSION['ses_filter_email']) && $_SESSION['ses_filter_email'] != '') echo unEscapeSpecialCharacters($_SESSION['ses_filter_email']) ;?>" ></td>
							<td align="left" width="15%"><input type="Submit" class="button" value="Search" title="Search" alt="Search" name="search" tabindex="3" id="search"/></td>
							<td></td>
						</tr>
					</table>
					</form>
				</td></tr>				
			</table>
		</td></tr>
		<tr height="50">
			<td align="right"><div id="add_link"><a href="edit_user.php?add=1" title="Add User" class="add_stoc"><img src="<?php  echo ADMIN_IMAGE_PATH."add_icon.png";  ?>"> Add User</a></div></td>
		</tr>
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%" align="center">
				<?php if(is_array($user_details) && count($user_details) > 0) { ?> 
				<?php if(isset($_GET['del']) && $_GET['del'] == 1){ ?>
					<tr><td align="right"><span style="padding-right:500px;color:#ff0000" ><strong class="success_msg" style="color:#ff0000;"><?php echo "User Detail Deleted Successfully"; ?></strong></span></td></tr>
				<?php } else if(isset($_GET['edit']) && $_GET['edit'] == 1){ ?>
					<tr><td align="right"><span style="padding-right:500px;color:#ff0000" ><strong class="success_msg" style=""><?php echo "User Detail Updated Successfully"; ?></strong></span></td></tr>
				<?php  } else if(isset($_GET['add']) && $_GET['add'] == 1){ ?>
					<tr><td align="right"><span style="padding-right:500px;color:#ff0000" ><strong class="success_msg" style=""><?php echo "User Added Successfully"; ?></strong></span></td></tr>
				<?php  }  ?>
				<tr><td align="right"><span style="padding-right:425px;"><?php //echo $msg; ?></span><span>No. of User(s)  : <?php echo $rows; ?></span></td></tr>
				<tr><td height="10"></td></tr>
				<form name="list_user_form" id="list_user_form" action="user_listing.php" method="post" onsubmit="return confirmDelete(this);" >
					<input type="hidden" id="orderBy" value="id" name="orderBy">
					<input type="hidden" id="orderType" value="desc" name="orderType">
				<tr><td> 
					 <table cellpadding="0" cellspacing="1" width="100%" class="listTable">
						<tr>
							<th width="2%" align="center"><input type="checkbox" id="titlecheckbox" name="titlecheckbox" onclick="check('list_user_form')" ></th>
							<th width="2%" align="center">#</th>
							<th width="20%" align="left">User Name</th>
							<th width="20%" align="left">First Name</th>
							<th width="20%" align="left">Company</th>
							<th width="10%" align="left">Telephone</th>
							<th width="45%" align="left">Email Id</th>
							<th colspan="3" align="center">Actions</th>
							
						</tr>
						<?php if(isset($user_details) && is_array($user_details) && count($user_details)>0){
							foreach($user_details as $key => $value) { 
								$value = (array)$value; ?>
						<tr class="<?php if($key%2==0) echo 'colorRow1'; else echo 'colorRow2';?>">
							<td align="center"><input type="checkbox" name="row_id[]" id="row_id" value="<?php echo $value['id'];?>"></td>
							<td align="center"><?php echo (($_SESSION['curpage'] - 1) * ($_SESSION['perpage']))+$key+1;?></td>
							<td align="left"><?php echo ucfirst(unEscapeSpecialCharacters($value['username'])); ?></td>
							<td align="left"><?php echo unEscapeSpecialCharacters($value['firstName']); ?></td>
							<td align="left"><?php echo unEscapeSpecialCharacters($value['company']); ?></td>
							<td align="left"><?php echo unEscapeSpecialCharacters($value['telephone']); ?></td>
							<td align="left"><?php echo unEscapeSpecialCharacters($value['email']); ?></td>
							
							<td width="2%" align="center"><a href="view_user.php?id=<?php echo $value['id'];?>" title="View user"><img src="<?php echo ADMIN_IMAGE_PATH;?>view.png" width="18" height="18" alt="View user" title="View user" border="0" /></a></td> 
							<td width="2%" align="center"><a href="edit_user.php?id=<?php echo $value['id'];?>&edit=1" title="Edit user"><img src="<?php echo ADMIN_IMAGE_PATH;?>edit.gif" alt="Edit user"  title="Edit user" border="0" /></a></td>
							<td width="2%" align="center"><a onclick="return confirm('Are you sure to delete?');" href="user_listing.php?deleteid=<?php echo $value['id'];?>" title="Delete user"><img src="<?php echo ADMIN_IMAGE_PATH;?>delete.gif" alt="Delete user"  title="Delete user" border="0" /></a></td>
						</tr>
						<?php }  } ?>
					</table> 
				</td></tr>
				<tr><td height="10"></td></tr>
				<tr><td>
					<div style="width: 72px;float:left;">
						<div id="checklist" class="fleft" style="display: block;text-align:right;"><a href="#" onclick="linkcheck('list_user_form','1')" title="Check All" alt="Check All">Check All</a></div>&nbsp;
						<div class="relative"><div id="unchecklist" class="absolute un_check" style="display: none;"><a href="#"  onclick="linkcheck('list_user_form','0')" title="Uncheck All" alt="Uncheck All">Uncheck All</a></div></div>
					</div>
					<div class="fleft">&nbsp;/&nbsp;<a class="delete" href="#" onclick="confirmDelete(document.forms.list_user_form,'Users');" title="Delete" alt="Delete">Delete</a></div>
				</td></tr> 
				</form>
				<tr><td><?php pagingControl($rows,"user_listing.php"); ?></td></tr>
				<?php  } else { ?>
				<tr><td class="success_msg" align="center"><strong>No Users Found</strong></td></tr> 
				<?php } ?>
				<tr><td height="20"></td></tr>
			</table>
		</td></tr>
	</table>
<?php adminFooterInclude();?>
