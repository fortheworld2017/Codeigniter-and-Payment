<?php ob_start();
if (!session_id()) session_start();
if(!isset($_SESSION['adminid'])) header("location:index.php");
require_once('../Includes/AdminCommonIncludes.php');
require_once('../Controllers/CardAttemptsController.php');
$cardAttemptsControllerObj 	= 	new CardAttemptsController();
$cond = '';
if(isset($_POST['row_id']) && $_POST['row_id'] != ''){
	$ids = implode(',',$_POST['row_id']);
	$res = $cardAttemptsControllerObj->deleteCardAttempts($ids);
	header("Location:card_attempts_listing.php?cs=1&del=1");
	die();
}
if(isset($_GET['deleteid']) && $_GET['deleteid'] != ''){
	$res = $cardAttemptsControllerObj->deleteCardAttempts($_GET['deleteid']);
	header("Location:card_attempts_listing.php?cs=1&del=1");
	die();
}
if(isset($_GET['cs']) && $_GET['cs'] == '1')
{
	destroyPagingControlsVariables();
	unset($_SESSION['ses_filter_ip']);
	unset($_SESSION['orderBy']);
	unset($_SESSION['orderType']);
}
if(isset($_POST['search']) && $_POST['search'] != '')
{
	destroyPagingControlsVariables();
	$_SESSION['ses_filter_ip']	=	$_POST['ses_filter_ip'];
}
if(isset($_POST['sortBy']) && $_POST['sortBy'] != '')
{
	$_SESSION['orderBy']	= 	$_POST['orderBy'];
	$_SESSION['orderType']	= 	$_POST['orderType'];
}
setPagingControlValues('id',ADMIN_PER_PAGE_LIMIT);
$card_attempts_details = $cardAttemptsControllerObj->getCardAttemptsDetails();
$rows = $cardAttemptsControllerObj->getTotalRecordCount();
?>

<?php adminHeaderInclude();?>
	<table cellpadding="0" cellspacing="0" width="100%" border="0" align="center"  class="border_outer">
		<tr><td class="title">Card Attempts per IP</td></tr>
		<tr><td height="20"></td></tr>
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%"  class="border" align="center">				
				<tr><td>
					<form name="card_attempts_search_form" id="card_attempts_search_form" method="post" action="card_attempts_listing.php">
					<table cellpadding="0" cellspacing="0" width="98%" align="center" class="filter">
						<tr><td height="10"></td></tr>
						<tr>
							<th width="10%" align="right">IP</th>
							<th width="2%" align="center" valign="middle">:</th>
							<td width="27%" align="left"><input type="text" class="w230" name="ses_filter_ip" id="ses_filter_ip" tabindex="1" value="<?php if(isset($_SESSION['ses_filter_ip']) && $_SESSION['ses_filter_ip'] != '') echo unEscapeSpecialCharacters($_SESSION['ses_filter_ip']) ;?>" ></td>
							
							<td align="left" width="15%"><input type="Submit" class="button" value="Search" title="Search" alt="Search" name="search" tabindex="3" id="search"/></td>
							<td></td>
						</tr>
					</table>
					</form>
				</td></tr>				
			</table>
		</td></tr>
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%" align="center">
				<?php if(is_array($card_attempts_details) && count($card_attempts_details) > 0) { ?> 
				<?php if(isset($_GET['del']) && $_GET['del'] == 1){ ?>
					<tr><td align="left"><span style="padding-right:500px;" ><strong class="success_msg" style="color:#ff0000;"><?php echo "IP Deleted Successfully"; ?></strong></span></td></tr>
				<?php } else if(isset($_GET['edit']) && $_GET['edit'] == 1){ ?>
					<tr><td align="left"><span style="padding-right:500px;" ><strong class="success_msg"><?php echo "IP Info Updated Successfully"; ?></strong></span></td></tr>
				<?php  } else if(isset($_GET['add']) && $_GET['add'] == 1){ ?>
					<tr><td align="left"><span style="padding-right:500px;" ><strong class="success_msg"><?php echo "IP Added Successfully"; ?></strong></span></td></tr>
				<?php  }  ?>
				<tr><td align="right"><span style="padding-right:425px;"><?php //echo $msg; ?></span><span>No. of IP(s)  : <?php echo $rows; ?></span></td></tr>
				<tr><td height="10"></td></tr>
				<form name="list_card_attempts_form" id="list_card_attempts_form" action="card_attempts_listing.php" method="post" onsubmit="return confirmDelete(this);" >
					<input type="hidden" id="orderBy" value="id" name="orderBy">
					<input type="hidden" id="orderType" value="desc" name="orderType">
				<tr><td> 
					 <table cellpadding="0" cellspacing="1" width="100%" class="listTable">
						<tr>
							<th width="2%" align="center"><input type="checkbox" id="titlecheckbox" name="titlecheckbox" onclick="check('list_card_attempts_form')" ></th>
							<th width="2%" align="center">#</th>
							<th width="20%" align="left">IP</th>
							<th width="20%" align="left">Attempts</th>
							<th width="20%" align="left">Last Attempt</th>
							
							<th colspan="2" align="center">Actions</th>
						</tr>
						<?php if(isset($card_attempts_details) && is_array($card_attempts_details) && count($card_attempts_details)>0){
							foreach($card_attempts_details as $key => $value) { 
								$value = (array)$value; ?>
						<tr class="<?php if($key%2==0) echo 'colorRow1'; else echo 'colorRow2';?>">
							<td align="center"><input type="checkbox" name="row_id[]" id="row_id" value="<?php echo $value['id'];?>"></td>
							<td align="center"><?php echo (($_SESSION['curpage'] - 1) * ($_SESSION['perpage']))+$key+1;?></td>
							<td align="left"><?php echo unEscapeSpecialCharacters($value['ip']); ?></td>
							<td align="left"><?php echo unEscapeSpecialCharacters($value['attempts']); ?></td>
							<td align="left"><?php echo unEscapeSpecialCharacters($value['lastAttempt']); ?></td>
							
							<td width="2%" align="center"><a onclick="return confirm('Are you sure to delete?');" href="card_attempts_listing.php?deleteid=<?php echo $value['id'];?>" title="Delete IP"><img src="<?php echo ADMIN_IMAGE_PATH;?>delete.gif" alt="Delete IP"  title="Delete IP" border="0" /></a></td>
						</tr>
						<?php }  } ?>
					</table> 
				</td></tr>
				<tr><td height="10"></td></tr>
				<tr><td>
					<div style="width: 72px;float:left;">
						<div id="checklist" class="fleft" style="display: block;text-align:right;"><a href="#" onclick="linkcheck('list_card_attempts_form','1')" title="Check All" alt="Check All">Check All</a></div>&nbsp;
						<div class="relative"><div id="unchecklist" class="absolute un_check" style="display: none;"><a href="#"  onclick="linkcheck('list_card_attempts_form','0')" title="Uncheck All" alt="Uncheck All">Uncheck All</a></div></div>
					</div>
					<div class="fleft">&nbsp;/&nbsp;<a class="delete" href="#" onclick="confirmDelete(document.forms.list_card_attempts_form,'IP');" title="Delete" alt="Delete">Delete</a></div>
				</td></tr> 
				</form>
				<tr><td><?php pagingControl($rows,"card_attempts_listing.php"); ?></td></tr>
				<?php  } else { ?>
				<tr><td class="success_msg" align="center"><strong>No Card Attempts Found</strong></td></tr> 
				<?php } ?>
				<tr><td height="20"></td></tr>
			</table>
		</td></tr>
	</table>
<?php adminFooterInclude();?>
