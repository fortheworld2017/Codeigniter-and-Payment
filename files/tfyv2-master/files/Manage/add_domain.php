<?php 
ob_start();
	if (!session_id()) session_start();
	if(!isset($_SESSION['adminid'])) header("location:index.php");
	require_once('../Includes/AdminCommonIncludes.php');
	require_once('../Includes/CommonIncludes.php');
	require_once('../Controllers/DomainController.php');
	$domainControllerObj 	= 	new DomainController();
	$id = $name = '';
	$cond = '';
	// edit view
	if(isset($_GET['id']) && $_GET['id'] != ''){
		$cond = " and id = ? ";
		$domain_details	 = $domainControllerObj->getDomainInfo($cond, array($_GET['id']));
		$id 			 = $domain_details[0]->id;
		$name			 = $domain_details[0]->name;
	}
	if((isset($_POST['edit_status']) && $_POST['edit_status'] =='1') || (isset($_POST['edit_status']) && $_POST['edit_status'] =='0')){
		/*if(isset($_POST['edit_status']) && $_POST['edit_status'] =='1'){
			$domainControllerObj->updateUser($_POST,$_POST['domain_id']);
			$msg 			= 	"?edit=1";
		}
		else */
		if(isset($_POST['edit_status']) && $_POST['edit_status'] =='0'){
			$fields = ' id ';
			$condition = ' name = ? ';
			
			$exist = $domainControllerObj->checkExist($fields, $condition, array($_POST['domainName']));
			if(isset($exist) && is_array($exist) && count($exist)>0){
				header("Location:add_domain.php?exist=1");die();
			}
			else{
				$userInsert_Id = $domainControllerObj->addDomain($_POST);
				$msg = "?add=1";
			}
		}
		header("Location:domain_listing.php".$msg);
		die();
	}
?>
<?php adminHeaderInclude('name'); ?>
	<!-- Content Start -->
	<table cellpadding="0" cellspacing="0" width="100%" class="border_outer">
		<tr><td class="title"><?php  if((isset($_GET['add']) && $_GET['add'] == '1') || (!isset($_GET['view']) && !isset($_GET['edit'])) ) { ?>Add<?php  } else { ?>Edit<?php  }  ?> Domain</td></tr>
		<tr><td height="20"></td></tr>
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%" class="" align="center">
			
				<tr><td>
					<form name="domain_form" id="domain_form" method="post" action="" enctype="multipart/form-data">
						<table cellpadding="0" cellspacing="0" width="100%" align="center" >
							<tr>
								<td valign="top" width="35%">
									<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
									<?php  if(isset($_GET['exist']) && $_GET['exist'] == 1) { ?>
									<tr><td align="left" colspan="3"><span id="exist_msg" style="color:#ff0000"><strong class="success_msg" style="color:#ff0000;"><?php echo "Domain Name Already Exist"; ?></strong></span></td></tr>
									<?php  }  ?>
										<tr><td height="15"></td></tr>
										<tr> 
											<th align="left" width="10%">Domain Name</th>
											<th align="center" width="5%">:</th>
											<td align="left">
												<?php  if(isset($_GET['view']) && $_GET['view'] == '1'){  ?>
													<?php	echo unEscapeSpecialCharacters($name);?>
												<?php  } else {  ?>
												<input type="text" class="w230 first_focus" name="domainName" id="domainName" value="<?php	echo unEscapeSpecialCharacters($name);?>">
												<div id="domainName_msg" class="error_msg" ></div>
												<?php  }  ?>
											</td>
										</tr>
										<tr><td height="7"></td></tr>
										<tr width="35%">
											<td></td>
											<td></td>
											<td colspan=""  align="left">
												<input type="hidden" id="domain_id" name="domain_id" value="<?php echo $id; ?>">
												<?php  if((isset($_GET['add']) && $_GET['add'] == '1') || (!isset($_GET['view']) && !isset($_GET['edit'])) ) { ?>
													<input type="Submit" class="button" onclick="return validateDomainForm();" tabindex="3" value="Add" title="Add user" alt="Add user" name="add_domain_submit" id="add_domain_submit" />&nbsp;&nbsp;
													<input type="hidden" id="edit_status" name="edit_status" value="0">
												<?php  } else {  ?>
													<input type="Submit" class="button" onclick="return validateDomainForm();" tabindex="3" value="Update" title="Update" alt="Update" name="domain_submit" id="domain_submit" />&nbsp;&nbsp;
													<input type="hidden" id="edit_status" name="edit_status" value="1">
												<?php  }  ?>
												<input type="Button" class="button" tabindex="4" value="Back" title="Back" alt="Back" name="Back" id="Back" onclick="location.href='domain_listing.php'" />
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr><td height="20"></td></tr>							
					</table>
					<input type="hidden" id="errorFlag" name="errorFlag" value="0">
					</form>
				</td></tr>
			</table>
		</td></tr>
		<tr><td height="20"></td></tr>
	</table>
	<!-- Content End -->
<?php adminFooterInclude();?>