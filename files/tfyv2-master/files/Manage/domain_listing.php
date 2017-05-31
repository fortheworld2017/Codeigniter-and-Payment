<?php ob_start();
if (!session_id()) session_start();
if(!isset($_SESSION['adminid'])) header("location:index.php");
require_once('../Includes/AdminCommonIncludes.php');
require_once('../Controllers/DomainController.php');
$domainControllerObj 	= 	new DomainController();
$cond = '';
if(isset($_POST['row_id']) && $_POST['row_id'] != ''){
	$flag = '';
	foreach($_POST['row_id'] as $key=>$value){
		$fields = ' dd.id ';
		$condition = ' d.id = ? ';
		
		$exist = $domainControllerObj->checkDomainExist($fields, $condition, array($value));
		if(isset($exist) && is_array($exist) && count($exist)>0){
		}
		 else {
		 	$flag = 1;
		 	$res = $domainControllerObj->deleteDomain($value);
		}
	}
	//$ids = implode(',',$_POST['row_id']);
	//$res = $domainControllerObj->deleteUser($ids);
	if($flag == 1){
		header("Location:domain_listing.php?cs=1&del=1");die();
	} else {
		header("Location:domain_listing.php?cs=1&exist=1");die();
	}
	
}
if(isset($_GET['deleteid']) && $_GET['deleteid'] != ''){
	$fields = ' dd.id ';
	$condition = ' d.id = ? ';
	$exist = $domainControllerObj->checkDomainExist($fields, $condition, array($_GET['deleteid']));
	if(isset($exist) && is_array($exist) && count($exist)>0){
		header("Location:domain_listing.php?cs=1&exist=1");
	} else {
		$res = $domainControllerObj->deleteDomain($_GET['deleteid']);
		header("Location:domain_listing.php?cs=1&del=1");
		die();
	}
}
if(isset($_GET['cs']) && $_GET['cs'] == '1')
{
	destroyPagingControlsVariables();
	unset($_SESSION['ses_filter_domianName']);
	unset($_SESSION['orderBy']);
	unset($_SESSION['orderType']);
}
if(isset($_POST['search']) && $_POST['search'] != '')
{
	destroyPagingControlsVariables();
	$_SESSION['ses_filter_domianName']	=	$_POST['ses_filter_domianName'];
}
if(isset($_POST['sortBy']) && $_POST['sortBy'] != '')
{
	$_SESSION['orderBy']	= 	$_POST['orderBy'];
	$_SESSION['orderType']	= 	$_POST['orderType'];
}
setPagingControlValues('id',ADMIN_PER_PAGE_LIMIT);
$domain_details = $domainControllerObj->getDomainDetails();
$rows = $domainControllerObj->getTotalRecordCount();
?>

<?php adminHeaderInclude();?>
	<table cellpadding="0" cellspacing="0" width="100%" border="0" align="center"  class="border_outer">
		<tr><td class="title">Domain List</td></tr>
		<tr><td height="20"></td></tr>
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%"  class="border" align="center">				
				<tr><td>
					<form name="domain_search_form" id="domain_search_form" method="post" action="domain_listing.php">
					<table cellpadding="0" cellspacing="0" width="98%" align="center" class="filter">
						<tr><td height="10"></td></tr>
						<tr>
							<th width="10%" align="right">Domain Name</th>
							<th width="2%" align="center" valign="middle">:</th>
							<td width="27%" align="left"><input type="text" class="w230" name="ses_filter_domianName" id="ses_filter_domianName" tabindex="1" value="<?php if(isset($_SESSION['ses_filter_domianName']) && $_SESSION['ses_filter_domianName'] != '') echo unEscapeSpecialCharacters($_SESSION['ses_filter_domianName']) ;?>" ></td>
							
							<td align="left" width="15%"><input type="Submit" class="button" value="Search" title="Search" alt="Search" name="search" tabindex="3" id="search"/></td>
							<td></td>
						</tr>
					</table>
					</form>
				</td></tr>				
			</table>
		</td></tr>
		<tr height="50">
			<td align="right"><div id="add_link"><a href="add_domain.php?add=1" title="Add Domain" class="add_stoc"><img src="<?php  echo ADMIN_IMAGE_PATH."add_icon.png";  ?>"> Add Domain</a></div></td>
		</tr>
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%" align="center">
				<?php if(is_array($domain_details) && count($domain_details) > 0) { ?> 
				<?php if(isset($_GET['del']) && $_GET['del'] == 1){ ?>
					<tr><td align="right"><span style="padding-right:500px;color:#ff0000" ><strong class="success_msg" style="color:#ff0000;"><?php echo "Domain Detail Deleted Successfully"; ?></strong></span></td></tr>
				<?php } else if(isset($_GET['edit']) && $_GET['edit'] == 1){ ?>
					<tr><td align="right"><span style="padding-right:500px;color:#ff0000" ><strong class="success_msg" style=""><?php echo "Domain Detail Updated Successfully"; ?></strong></span></td></tr>
				<?php  } else if(isset($_GET['add']) && $_GET['add'] == 1){ ?>
					<tr><td align="right"><span style="padding-right:500px;color:#ff0000" ><strong class="success_msg" style=""><?php echo "Domain Added Successfully"; ?></strong></span></td></tr>
				<?php  }  else if(isset($_GET['exist']) && $_GET['exist'] == 1){ ?>
					<tr><td align="right"><span style="padding-right:500px;color:#ff0000" ><strong class="success_msg"  style="color:#ff0000;"><?php echo "Domain Already Used in Card"; ?></strong></span></td></tr>
				<?php  }  ?>
				<tr><td align="right"><span style="padding-right:425px;"><?php //echo $msg; ?></span><span>No. of Domain(s)  : <?php echo $rows; ?></span></td></tr>
				<tr><td height="10"></td></tr>
				<form name="list_domain_form" id="list_domain_form" action="domain_listing.php" method="post" onsubmit="return confirmDelete(this);" >
					<input type="hidden" id="orderBy" value="id" name="orderBy">
					<input type="hidden" id="orderType" value="desc" name="orderType">
				<tr><td> 
					 <table cellpadding="0" cellspacing="1" width="100%" class="listTable">
						<tr>
							<th width="2%" align="center"><input type="checkbox" id="titlecheckbox" name="titlecheckbox" onclick="check('list_domain_form')" ></th>
							<th width="2%" align="center">#</th>
							<th width="20%" align="left">Domain Name</th>
							<th colspan="2" align="center">Actions</th>
						</tr>
						<?php if(isset($domain_details) && is_array($domain_details) && count($domain_details)>0){
							foreach($domain_details as $key => $value) { 
								$value = (array)$value; ?>
						<tr class="<?php if($key%2==0) echo 'colorRow1'; else echo 'colorRow2';?>">
							<td align="center"><input type="checkbox" name="row_id[]" id="row_id" value="<?php echo $value['id'];?>"></td>
							<td align="center"><?php echo (($_SESSION['curpage'] - 1) * ($_SESSION['perpage']))+$key+1;?></td>
							<td align="left"><?php echo unEscapeSpecialCharacters($value['name']); ?></td>
							
							<td width="2%" align="center"><a onclick="return confirm('Are you sure to delete?');" href="domain_listing.php?deleteid=<?php echo $value['id'];?>" title="Delete Domain"><img src="<?php echo ADMIN_IMAGE_PATH;?>delete.gif" alt="Delete Domain"  title="Delete Domain" border="0" /></a></td>
						</tr>
						<?php }  } ?>
					</table> 
				</td></tr>
				<tr><td height="10"></td></tr>
				<tr><td>
					<div style="width: 72px;float:left;">
						<div id="checklist" class="fleft" style="display: block;text-align:right;"><a href="#" onclick="linkcheck('list_domain_form','1')" title="Check All" alt="Check All">Check All</a></div>&nbsp;
						<div class="relative"><div id="unchecklist" class="absolute un_check" style="display: none;"><a href="#"  onclick="linkcheck('list_domain_form','0')" title="Uncheck All" alt="Uncheck All">Uncheck All</a></div></div>
					</div>
					<div class="fleft">&nbsp;/&nbsp;<a class="delete" href="#" onclick="confirmDelete(document.forms.list_domain_form,'Domain');" title="Delete" alt="Delete">Delete</a></div>
				</td></tr> 
				</form>
				<tr><td><?php pagingControl($rows,"domain_listing.php"); ?></td></tr>
				<?php  } else { ?>
				<tr><td class="success_msg" align="center"><strong>No Domains Found</strong></td></tr> 
				<?php } ?>
				<tr><td height="20"></td></tr>
			</table>
		</td></tr>
	</table>
<?php adminFooterInclude();?>
