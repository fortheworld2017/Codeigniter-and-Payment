<?php 
ob_start();
	if (!session_id()) session_start();
	if(!isset($_SESSION['adminid'])) header("location:index.php");
	require_once('../Includes/AdminCommonIncludes.php');
	require_once('../Controllers/CardDetailsController.php');
	$cardDetailsControllerObj 	= 	new CardDetailsController();
	$id = $profile_path_abs = $imageName = $imageExt = $userName = $firstName = $surName = $company = $telephone = $mobile = $email = $website = $streetName = $city = $state = $zipCode = $country = $billingStreetName = $billingCity = $billingState = $billingZipCode = $billingCountry = '';
	$condition = '';
	$fields = '*';
	$tableName = 'cardDetails';
	if(isset($_GET['id']) && $_GET['id'] != ''){
		$condition = " id = ".$_GET['id'];
		$card_details		=	$cardDetailsControllerObj->getData($fields, $tableName, $condition);
		$id 				= 	$card_details[0]->id;
		$shortUrl 			= 	$card_details[0]->shortUrl;
	}
	if(isset($_POST['shortUrl']) && $_POST['shortUrl'] !=''){
		if(isset($_POST['card_id']) && $_POST['card_id'] !='')
		{
			$cardDetailsControllerObj->updateShortUrl($_POST['card_id'], $_POST['shortUrl']);
		
		}
		header("Location:card_listing.php?edit=1");
		die();
	}
?>

<?php adminHeaderInclude('name'); ?>
	<!-- Content Start -->
	<table cellpadding="0" cellspacing="0" width="100%" class="border_outer">
		<tr><td class="title"><?php  if(isset($_GET['add']) && $_GET['add'] == '1') { ?>Add<?php  } else { ?>Edit<?php  }  ?> Card</td></tr>
		<tr><td height="20"></td></tr>
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%" class="border" align="center">						
				<tr><td>
					<form name="cards_form" id="cards_form" method="post" action="" enctype="multipart/form-data">
						<table cellpadding="0" cellspacing="0" width="95%" align="center" class="filter">
							<tr> 
							<th align="left" width="10%">Short Url</th>
							<th align="center" width="5%">:</th>
							<td align="left">
								<input type="text" class="w230 first_focus" name="shortUrl" id="shortUrl" value="<?php	echo unEscapeSpecialCharacters($shortUrl);?>">
								<div id="shortUrl_msg" class="error_msg" ></div>
							</td>
						</tr>
						<tr><td height="10"></td></tr>
							<tr>
								<td colspan="2">&nbsp;</td></td>	
								<td>
									<input type="hidden" id="card_id" name="card_id" value="<?php echo $id; ?>">
									<?php  //if(isset($_GET['add']) && $_GET['add'] == '1') { ?>
										<!-- <input type="Submit" class="button" onclick="return validateUserEdit();" tabindex="3" value="Add" title="Add user" alt="Add user" name="add_user_submit" id="add_user_submit" />&nbsp;&nbsp; -->
									<?php // } else {  ?>
										<input type="Submit" onclick="return validateCard();" class="button" tabindex="3" value="Update" title="Update" alt="Update" name="card_submit" id="card_submit" />&nbsp;&nbsp;
									<?php // }  ?>
									<input type="Button" class="button" tabindex="4" value="Back" title="Back" alt="Back" name="Back" id="Back" onclick="location.href='card_listing.php'" />
								</td>
							</tr>
					</table>
					<input type="hidden" id="errorFlag" name="errorFlag" value="0">
					</form>
					<iframe src="uploadAction?" id="imguploadprintpic" height="0" width="0"  name="imguploadprintpic" frameborder="0" ></iframe>
				</td></tr>
			</table>
		</td></tr>
		<tr><td height="20"></td></tr>
	</table>
	<!-- Content End -->
<?php adminFooterInclude();?>