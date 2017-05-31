<?php ob_start();
if (!session_id()) session_start();
if(!isset($_SESSION['adminid'])) header("location:index.php");
error_reporting(E_ALL);
require_once('../Includes/AdminCommonIncludes.php');
require_once('../Controllers/CardDetailsController.php');
$cardDetailsControllerObj 	= 	new CardDetailsController();
require_once('../Controllers/DomainController.php');
$DomainControllerObj 	= 	new DomainController();
$domain_list = $DomainControllerObj->getDomainInfo('');
$cond = '';
if(isset($_POST['row_id']) && $_POST['row_id'] != ''){
	$ids	=	implode(',',$_POST['row_id']);
	$res	=	$cardDetailsControllerObj->deleteCard($ids);
	header("Location:card_listing.php?cs=1&del=1");
	die();
}
if(isset($_GET['deleteid']) && $_GET['deleteid'] != ''){
	$res 	= 	$cardDetailsControllerObj->deleteCard($_GET['deleteid']);
	header("Location:card_listing.php?cs=1&del=1");
	die();
}
if(isset($_GET['cs']) && $_GET['cs'] == '1')
{
	destroyPagingControlsVariables();
	unset($_SESSION['ses_filter_name']);
	unset($_SESSION['ses_filter_email']);
	unset($_SESSION['orderBy']);
	unset($_SESSION['orderType']);
	unset($_SESSION['ses_domain_name']);
}
if(isset($_POST['search']) && $_POST['search'] != '')
{
	destroyPagingControlsVariables();
	$_SESSION['ses_filter_name']		=	$_POST['ses_filter_name'];
	$_SESSION['ses_filter_email']		=	$_POST['ses_filter_email'];
	$_SESSION['ses_domain_name'] 		= 	$_POST['domain_name'];
}
if(isset($_POST['sortBy']) && $_POST['sortBy'] != '')
{
	$_SESSION['orderBy']	= 	$_POST['orderBy'];
	$_SESSION['orderType']	= 	$_POST['orderType'];
}
setPagingControlValues('id',ADMIN_PER_PAGE_LIMIT);
$fields 		= 	' cd.*,dd.domainName ';
$condition		=	' and cd.deletedStatus = 1 ';
$orderBy		=	' order by cd.id desc';
$card_details 	= 	$cardDetailsControllerObj->getCardList($fields, $condition, $orderBy);
$rows 			= 	$cardDetailsControllerObj->getTotalRecordCount();
?>

<?php adminHeaderInclude();?>
	<table cellpadding="0" cellspacing="0" width="100%" border="0" align="center"  class="border_outer">
		<tr><td class="title">Card List</td></tr>
		<tr><td height="20"></td></tr>
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%"  class="border" align="center">				
				<tr><td>
					<form name="card_search_form" id="card_search_form" method="post" action="card_listing.php?cs=1">
					<table cellpadding="0" cellspacing="0" width="98%" align="center" class="filter">
						<tr><td height="10"></td></tr>
						<tr>
							<th width="10%" align="right">Name</th>
							<th width="2%" align="center" valign="middle">:</th>
							<td width="20%" align="left"><input type="text" class="w230" name="ses_filter_name" id="ses_filter_name" tabindex="1" value="<?php if(isset($_SESSION['ses_filter_name']) && $_SESSION['ses_filter_name'] != '') echo unEscapeSpecialCharacters($_SESSION['ses_filter_name']) ;?>" ></td>
							<th width="5%" align="right">Email Id</th>
							<th width="2%" align="center" valign="middle">:</th>
							<td width="20%" align="left"><input type="text" class="w230" name="ses_filter_email" id="ses_filter_email" tabindex="1" value="<?php if(isset($_SESSION['ses_filter_email']) && $_SESSION['ses_filter_email'] != '') echo unEscapeSpecialCharacters($_SESSION['ses_filter_email']) ;?>" ></td>
							<th width="10%" align="right">Domain Name</th>
							<th width="2%" align="center" valign="middle">:</th>
							<td width="10%" align="left">
								<select name="domain_name" id="domain_name">
									<option value="">Select</option>
									<?php  if(isset($domain_list) && is_array($domain_list) && count($domain_list)>0){ 
												foreach($domain_list as $key=>$value){ ?>
													<option <?php  if(isset($_SESSION['ses_domain_name']) && $_SESSION['ses_domain_name'] == $value->id ){ echo "selected='selected'"; }  ?> value="<?php  echo $value->id;  ?>"><?php  echo $value->name;  ?></option>
									<?php  		}
										   }  ?>
								</select>
							</td>
							<td align="center" width="15%"><input type="Submit" class="button" value="Search" title="Search" alt="Search" name="search" tabindex="3" id="search"/></td>
							<td></td>
						</tr>
					</table>
					</form>
				</td></tr>				
			</table>
		</td></tr>
		<tr height="50">
			<!-- <td align="right"><div id="add_link"><a href="news.php" title="Add News" class="add_stoc">Add News</a></div></td> -->
		</tr>
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%" align="center">
				<?php if(is_array($card_details) && count($card_details) > 0) { ?> 
				<?php if(isset($_GET['del']) && $_GET['del'] == 1){ ?>
					<tr><td align="right"><span style="padding-right:500px;color:#ff0000" ><strong class="success_msg" style="color:#ff0000;"><?php echo "Card Detail Deleted Successfully"; ?></strong></span></td></tr>
				<?php } else if(isset($_GET['edit']) && $_GET['edit'] == 1){ ?>
					<tr><td align="right"><span style="padding-right:500px;color:#ff0000" ><strong class="success_msg" style=""><?php echo "Card Detail Updated Successfully"; ?></strong></span></td></tr>
				<?php  }  ?>
				<tr><td align="right"><span style="padding-right:425px;"><?php //echo $msg; ?></span><span>No. of Card(s)  : <?php echo $rows; ?></span></td></tr>
				<tr><td height="10"></td></tr>
				<form name="list_card_form" id="list_card_form" action="card_listing.php" method=POST onsubmit="return confirmDelete(this);" >
					<input type="hidden" id="orderBy" value="id" name="orderBy">
					<input type="hidden" id="orderType" value="desc" name="orderType">
				<tr><td> 
					 <table cellpadding="0" cellspacing="1" width="100%" class="listTable">
						<tr>
							<th width="2%" align="center"><input type="checkbox" id="titlecheckbox" name="titlecheckbox" onclick="check('list_card_form')" ></th>
							<th width="3%" align="center">#</th>
							<th width="15%" align="left">Name</th>
							<th width="15%" align="left">Title</th>
							<th width="15%" align="left">Position</th>
							<th width="10%" align="left">Company</th>
							<th width="10%" align="left">Short Url</th>
							<th width="20%" align="left">Email Id</th>
							<th width="20%" align="left">Domain Name</th>
							<th colspan="3" align="center">Actions</th>
							
						</tr>
						<?php if(isset($card_details) && is_array($card_details) && count($card_details)>0){
							foreach($card_details as $key => $value) { 
								$value = (array)$value; ?>
						<tr class="<?php if($key%2==0) echo 'colorRow1'; else echo 'colorRow2';?>">
							<td align="center"><input type="checkbox" name="row_id[]" id="row_id" value="<?php echo $value['id'];?>"></td>
							<td align="center"><?php echo (($_SESSION['curpage'] - 1) * ($_SESSION['perpage']))+$key+1;?></td>
							<td align="left"><?php echo ucfirst(unEscapeSpecialCharacters($value['name'])); ?></td>
							<td align="left"><?php echo unEscapeSpecialCharacters($value['title']); ?></td>
							<td align="left"><?php echo unEscapeSpecialCharacters($value['position']); ?></td>
							<td align="left"><?php echo unEscapeSpecialCharacters($value['company']); ?></td>
							<td align="left"><?php echo unEscapeSpecialCharacters($value['shortUrl']); ?></td>
							<td align="left"><?php echo unEscapeSpecialCharacters($value['email']); ?></td>
							<td align="left"><?php  echo unEscapeSpecialCharacters($value['domainName']);  ?></td>
							<td width="2%" align="center"><a target="_blank" href="<?php echo SITE_PATH."preview?shorturl=".$value['shortUrl'];?>" title="View card"><img src="<?php echo ADMIN_IMAGE_PATH;?>view.png" width="18" height="18" alt="View card" title="View card" border="0" /></a></td> 
							<td width="2%" align="center"><a href="edit_card.php?id=<?php echo $value['id'];?>"><img src="<?php echo ADMIN_IMAGE_PATH;?>edit.gif" alt="Edit card"  title="Edit card" border="0" /></a></td>
							<td width="2%" align="center"><a onclick="return confirm('Are you sure to delete?');" href="card_listing.php?deleteid=<?php echo $value['id'];?>" title="Delete card"><img src="<?php echo ADMIN_IMAGE_PATH;?>delete.gif" alt="Delete card"  title="Delete card" border="0" /></a></td>
						</tr>
						<?php }  } ?>
					</table> 
				</td></tr>
				<tr><td height="10"></td></tr>
				<tr><td>
					<div style="width: 72px;float:left;">
						<div id="checklist" class="fleft" style="display: block;text-align:right;"><a href="#" onclick="linkcheck('list_card_form','1')" title="Check All" alt="Check All">Check All</a></div>&nbsp;
						<div class="relative"><div id="unchecklist" class="absolute un_check" style="display: none;"><a href="#"  onclick="linkcheck('list_card_form','0')" title="Uncheck All" alt="Uncheck All">Uncheck All</a></div></div>
					</div>
					<div class="fleft">&nbsp;/&nbsp;<a class="delete" href="#" onclick="confirmDelete(document.forms.list_card_form,'Cards');" title="Delete" alt="Delete">Delete</a></div>
				</td></tr> 
				</form>
				<tr><td><?php pagingControl($rows,"card_listing.php"); ?></td></tr>
				<?php  } else { ?>
				<tr><td class="success_msg" align="center"><strong>No Cards Found</strong></td></tr> 
				<?php } ?>
				<tr><td height="20"></td></tr>
			</table>
		</td></tr>
	</table>
<?php adminFooterInclude();?>
