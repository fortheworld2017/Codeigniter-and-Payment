<?php ob_start();
if (!session_id()) session_start();
if(!isset($_SESSION['adminid'])) header("location:index.php");
require_once('../Includes/AdminCommonIncludes.php');
require_once('../Controllers/UserController.php');
require_once('../Controllers/DomainController.php');
$domainControllerObj 	= 	new DomainController();
$userControllerObj 	= 	new UserController();

$cond = '';

if(isset($_GET['domain_id']) && $_GET['domain_id'])
{
	$domain_id = $_GET['domain_id'];
	$cond = " and id = ? "; 
	$domain_info = $domainControllerObj->getDomainInfo($cond, array($domain_id));
	if( is_array($domain_info) && count($domain_info) > 0 )
		$domain_name = $domain_info[0]->name;
	else
	{
		header("Location:assign_domain.php");
		die();
	}
}
else
{
	header("Location:assign_domain.php");
	die();
}

if(isset($_POST['row_id']) && $_POST['row_id'] != ''){
	$ids = implode(',',$_POST['row_id']);
	$res = $domainControllerObj->assignDomainUser($domain_id,$ids);
	header("Location:assign_domain_users.php?domain_id=".$domain_id."&cs=1&add=1");
	die();
}
if(isset($_GET['assignid']) && $_GET['assignid'] != ''){
	$res = $domainControllerObj->assignDomainUser($domain_id,$_GET['assignid']);
	header("Location:assign_domain_users.php?domain_id=".$domain_id."&cs=1&add=1");
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

$user_details = $userControllerObj->getUsersNotInDomain($domain_id);
$rows = $userControllerObj->getTotalRecordCount();
//echo "<br>++><pre>"; print_r($user_details); echo "</pre><++";
?>

<?php adminHeaderInclude();?>
	<table cellpadding="0" cellspacing="0" width="100%" border="0" align="center"  class="border_outer">
		<tr><td class="title">Select Users to Assign Domain</td></tr>
		<tr><td height="20"></td></tr>
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%"  class="border" align="center">				
				<tr><td>
					<form name="users_search_form" id="users_search_form" method="post" action="assign_domain_users.php?domain_id=<?php echo $domain_id;?>&cs=1">
					<table cellpadding="0" cellspacing="0" width="98%" align="center" class="filter">
						<tr><td height="10"></td></tr>
						<tr>
							<th width="10%" align="right">Domain</th>
							<th width="2%" align="center" valign="middle">:</th>
							<td width="27%" align="left"><?php echo $domain_name;?></td>
							<td colspan="5"></td>
						</tr>
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
				<?php if(isset($_GET['add']) && $_GET['add'] == 1){ ?>
					<tr><td align="left"><span style="padding-right:500px;" ><strong class="success_msg"><?php echo "Domain Assigned Successfully"; ?></strong></span></td></tr>
				<?php  }  ?>
				<tr><td align="right"><span style="padding-right:425px;"><?php //echo $msg; ?></span><span>No. of User(s)  : <?php echo $rows; ?></span></td></tr>
				<tr><td height="10"></td></tr>
				<form name="list_user_form" id="list_user_form" action="assign_domain_users.php?domain_id=<?php echo $domain_id;?>" method="post">
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
							<th align="center">Actions</th>
							
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
							
							<td width="2%" align="center"><a href="assign_domain_users.php?domain_id=<?php echo $domain_id;?>&assignid=<?php echo $value['id'];?>" title="Assign user"><img src="<?php echo ADMIN_IMAGE_PATH;?>add_icon.png" alt="Assign user"  title="Assign user" border="0" /></a></td>
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
					<div class="fleft">&nbsp;/&nbsp;<a href="#" onclick="document.forms.list_user_form.submit();" title="Assign" alt="Assign">Assign</a></div>
				</td></tr>
				<tr><td height="10"></td></tr>
				<td align="left" width="100%"><input type="Submit" class="button" value="Assign" title="Assign" alt="Assign" name="assign" tabindex="3" id="assign"/></td> 
				</form>
				<tr><td><?php pagingControl($rows,"assign_domain_users.php?domain_id=".$domain_id); ?></td></tr>
				<?php  } else { ?>
				<tr><td class="success_msg" align="center"><strong>No Users Found</strong></td></tr> 
				<?php } ?>
				<tr><td height="20"></td></tr>
			</table>
		</td></tr>
	</table>
<?php adminFooterInclude();?>
