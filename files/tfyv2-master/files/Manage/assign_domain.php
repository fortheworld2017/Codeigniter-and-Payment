<?php ob_start();
if (!session_id()) session_start();
if(!isset($_SESSION['adminid'])) header("location:index.php");
require_once('../Includes/AdminCommonIncludes.php');
require_once('../Controllers/DomainController.php');
$domainControllerObj 	= 	new DomainController();
$cond = '';
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
		<tr><td class="title">Select Domain To Assign</td></tr>
		<tr><td height="20"></td></tr>
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%"  class="border" align="center">				
				<tr><td>
					<form name="domain_search_form" id="domain_search_form" method="post" action="assign_domain.php">
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
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%" align="center">
				<?php if(is_array($domain_details) && count($domain_details) > 0) { ?> 
					<tr><td align="right"><span style="padding-right:425px;"><?php //echo $msg; ?></span><span>No. of Domain(s)  : <?php echo $rows; ?></span></td></tr>
					<tr><td height="10"></td></tr>
					<form name="list_domain_form" id="list_domain_form" action="assign_domain.php" method="post" onsubmit="return confirmDelete(this);" >
						<input type="hidden" id="orderBy" value="id" name="orderBy">
						<input type="hidden" id="orderType" value="desc" name="orderType">
					<tr><td> 
						 <table cellpadding="0" cellspacing="1" width="100%" class="listTable">
							<tr>
								<th width="2%" align="center">#</th>
								<th width="20%" align="left">Domain Name</th>
							</tr>
							<?php if(isset($domain_details) && is_array($domain_details) && count($domain_details)>0){
								foreach($domain_details as $key => $value) { 
									$value = (array)$value; ?>
							<tr class="<?php if($key%2==0) echo 'colorRow1'; else echo 'colorRow2';?>" onclick="window.location.href='assign_domain_users.php?domain_id=<?php echo $value['id'];?>'" style="cursor:pointer">
								<td align="center"><?php echo (($_SESSION['curpage'] - 1) * ($_SESSION['perpage']))+$key+1;?></td>
								<td align="left"><?php echo unEscapeSpecialCharacters($value['name']); ?></td>
							</tr>
							<?php }  } ?>
						</table> 
					</td></tr>
					<tr><td height="10"></td></tr>
					</form>
					<tr><td><?php pagingControl($rows,"assign_domain.php"); ?></td></tr>
				<?php  } else { ?>
					<tr><td class="success_msg" align="center"><strong>No Domains Found</strong></td></tr> 
				<?php } ?>
				<tr><td height="20"></td></tr>
			</table>
		</td></tr>
	</table>
<?php adminFooterInclude();?>
