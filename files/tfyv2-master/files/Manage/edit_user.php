<?php 
ob_start();
	if (!session_id()) session_start();
	if(!isset($_SESSION['adminid'])) header("location:index.php");
	require_once('../Includes/AdminCommonIncludes.php');
	require_once('../Includes/CommonIncludes.php');
	require_once('../Controllers/UserController.php');
	require_once('../Controllers/DomainController.php');
	$userControllerObj 		= 	new UserController();
	$domainControllerObj 	= 	new DomainController();
	
	$id = $password = $profile_path_abs = $profile_ext = $imageName = $imageExt = $userName = $firstName = $surName = $company = $telephone = $mobile = $email = $website = $streetName = $city = $state = $zipCode = $country = $billingStreetName = $billingCity = $billingState = $billingZipCode = $billingCountry = '';
	$cond = '';
	
	// Delete domain
	if(isset($_GET['id']) && isset($_GET['deletedomainid']) && $_GET['deletedomainid'] != ''){
		$res = $domainControllerObj->deleteUserDomain($_GET['id'], $_GET['deletedomainid']);
	}
	
	// edit view
	if(isset($_GET['id']) && $_GET['id'] != ''){
		$cond = " and id = ? ";
		$user_details		=	$userControllerObj->getUserInfo($cond, array($_GET['id']));
		$id 				= 	$user_details[0]->id;
		$password			= 	$user_details[0]->password;
		$userName 			= 	$user_details[0]->username;
		$firstName			=	$user_details[0]->firstName;
		$surName			=	$user_details[0]->surName;
		$company			=	$user_details[0]->company;
		$telephone			=	$user_details[0]->telephone;
		$mobile				=	$user_details[0]->mobile;
		$email				=	$user_details[0]->email;
		$website			=	$user_details[0]->website;
		$streetName			=	$user_details[0]->streetName;
		$city				=	$user_details[0]->city;
		$state				=	$user_details[0]->state;
		$zipCode			=	$user_details[0]->zipCode;
		$country			=	$user_details[0]->country;
		$billingStreetName	=	$user_details[0]->billingStreetName;
		$billingCity		=	$user_details[0]->billingCity;
		$billingState		=	$user_details[0]->billingState;
		$billingZipCode		=	$user_details[0]->billingZipCode;
		$billingCountry		=	$user_details[0]->billingCountry;
		$imageName			=	$user_details[0]->profileImageName;
		$imageExt			=	$user_details[0]->profileImage;
		if($user_details[0]->profileImage != '' && $user_details[0]->profileImageName !='')
			$profile_path_abs 	= 	ABS_IMAGE_PATH_PROFILE.$id.'.'.$user_details[0]->profileImage;
		if(file_exists($profile_path_abs))
			$profile_path 		= 	IMAGE_PATH_PROFILE.$id.'.'.$user_details[0]->profileImage;
		else
			$profile_path 		= 	"../WebResources/Images/common/noimage.jpg";
			
		$domain_details = $domainControllerObj->getUserDomainInfo($id);
	}
	if((isset($_POST['edit_status']) && $_POST['edit_status'] =='1') || (isset($_POST['edit_status']) && $_POST['edit_status'] =='0')){
		if(isset($_FILES['profileImage']['name']) && $_FILES['profileImage']['name'] != '') {
			$profile_img_array 			=	explode(".",$_FILES['profileImage']['name']);
			$profile_ext				=	end($profile_img_array);
			$profile_name				=	$profile_img_array[0];
			$path 						= 	ABS_IMAGE_PATH_PROFILE.$_POST['user_id'].'.'.$profile_ext;
			$path_thumb 				= 	ABS_IMAGE_PATH_PROFILE.'thumb/'.$_POST['user_id'].'.'.$profile_ext;
			if(file_exists($path)){
				unlink($path);
			}
			if(file_exists($path_thumb)){
				unlink($path_thumb);
			}
			if(isset($_POST['img_type']) && $_POST['img_type'] == '1'){ 
				$_POST['image_name']		= 	$profile_name;
				$_POST['image_extension']	= 	$profile_ext;
			}
			else {
				$_POST['image_name']		= 	'';
				$_POST['image_extension']	= 	'';
			}
		}
		else if(isset($_POST['profile_img_name']) && isset($_POST['profile_img_ext'])){
			$_POST['image_name']			= 	$_POST['profile_img_name'];
			$_POST['image_extension']		= 	$_POST['profile_img_ext'];
		}
		if(isset($_POST['billingStatus']) && $_POST['billingStatus'] == 1){
			$_POST['billingStreetName'] 	= 	$_POST['streetName'];
			$_POST['billingCity'] 			= 	$_POST['city'];
			$_POST['billingState'] 			= 	$_POST['state'];
			$_POST['billingZipCode'] 		= 	$_POST['zipCode'];
			$_POST['billingCountry'] 		= 	$_POST['country'];
		}
		if(isset($_POST['edit_status']) && $_POST['edit_status'] =='1'){
			if(isset($_POST['oldPassword']) && $_POST['oldPassword'] != '' && isset($_POST['newPassword']) && $_POST['newPassword'] != ''){
				if(md5($_POST['oldPassword']) != $_POST['passwordHidden']){
					header("Location:edit_user.php?err=1&edit=1&id=".$_POST['user_id']);
				}
				else{
					$userControllerObj->updateUser($_POST,$_POST['user_id']);
					$userInsert_Id	=	$_POST['user_id'];
					$msg 			= 	"?edit=1";
				}
			}
			else
			{
				$userControllerObj->updateUser($_POST,$_POST['user_id']);
				$userInsert_Id	=	$_POST['user_id'];
				$msg 			= 	"?edit=1";
			}
		}
		else if(isset($_POST['edit_status']) && $_POST['edit_status'] =='0'){
			$userInsert_Id = $userControllerObj->addUser($_POST);
			$msg = "?add=1";
		}
		
		if(isset($userInsert_Id) && $userInsert_Id != '' && isset($_POST['img_type']) && $_POST['img_type'] == '1'){
			$path 			= 	ABS_IMAGE_PATH_PROFILE.$userInsert_Id.'.'.$profile_ext;
			$path_thumb 	= 	ABS_IMAGE_PATH_PROFILE.'thumb/'.$userInsert_Id.'.'.$profile_ext;
			copy($_FILES['profileImage']['tmp_name'],$path);
			copy($_FILES['profileImage']['tmp_name'],$path_thumb);
		}
		header("Location:user_listing.php".$msg);
		die();
	}
?>

<?php adminHeaderInclude('name'); ?>
	<!-- Content Start -->
	<table cellpadding="0" cellspacing="0" width="100%" class="border_outer">
		<tr><td class="title"><?php  if(isset($_GET['add']) && $_GET['add'] == '1') { ?>Add<?php  } else { ?>Edit<?php  }  ?> User</td></tr>
		<tr><td height="20"></td></tr>
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%" class="" align="center">
			<?php  if(isset($_GET['err']) && $_GET['err'] == '1'){  ?>
				<tr><td align="center" class="error_msg">Old password is incorrect</td></tr>
			<?php  }  ?>
				<tr><td>
					<form name="users_form" id="users_form" method="post" action="" enctype="multipart/form-data">
						<input type="hidden" name="passwordHidden" id="passwordHidden" value="<?php  echo $password;  ?>">
						<table cellpadding="0" cellspacing="0" width="100%" align="center" >
							<tr>
								<td valign="top" width="35%">
									<table cellpadding="0" cellspacing="0" width="95%" align="center">
										<tr><th colspan="3" align="left" class="subtitle">USERNAME/PASSWORD</th></tr>
										<tr><td height="15d"></td></tr>
										<tr> 
											<th align="left" width="35%">User Name</th>
											<th align="center" width="5%">:</th>
											<td align="left">
												<input type="text" class="w230 first_focus" name="userName" id="userName" value="<?php	echo unEscapeSpecialCharacters($userName);?>">
												<div id="userName_msg" class="error_msg" ></div>
											</td>
										</tr>
										<?php  if(isset($_GET['edit']) && $_GET['edit'] == '1') { ?>
										<tr><td height="7"></td></tr>
										<tr>
											<th align="left" valign="top">Old Password</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<label><input type="password" id="oldPassword" name="oldPassword" placeholder="" class="w230" value="" /></label>
												<div id="oldPassword_msg" class="error_msg" ></div>
											</td>
										</tr>
										<?php  }  ?>
										<tr><td height="7"></td></tr>
										<tr>
											<th align="left" valign="top">Password</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<label><input type="password" id="newPassword" name="newPassword" placeholder="" class="w230" value="" /></label>
												<div id="newPassword_msg" class="error_msg" ></div>
											</td>
										</tr>
										<tr><td height="7"></td></tr>
										<tr>
											<th align="left" valign="top">Confirm Password</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<label><input type="password" id="confirmPassword" name="confirmPassword" placeholder="" class="w230" value="" /></label>
												<div id="confirmPassword_msg" class="error_msg" ></div>
											</td>
										</tr>
										<tr><td height="15"></td></tr>
										<tr><th colspan="3" align="left" class="subtitle">ASSIGNED DOMAINS</th></tr>
										<tr><td height="7"></td></tr>
										<tr><td colspan="3">
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
													
													<td width="2%" align="center"><a onclick="return confirm('Are you sure to delete?');" href="edit_user.php?id=<?php echo $id;?>&deletedomainid=<?php echo $value['id'];?>" title="Delete Domain"><img src="<?php echo ADMIN_IMAGE_PATH;?>delete.gif" alt="Delete Domain"  title="Delete Domain" border="0" /></a></td>
												</tr>
												<?php }  } ?>
											</table>
										</td></tr>
										<tr><td height="7"></td></tr>
									</table>
								</td>
								<td valign="top" width="30%">
									<table cellpadding="0" cellspacing="0" width="95%" align="center">
										<tr><th align="left" colspan="3" valign="top" class="subtitle">CONTACT DETAILS</th></tr>
										<tr><td height="15"></td></tr>
										<tr>
											<th align="left" valign="top" width="25%">First Name</th>
											<th align="center" valign="top" width="5%">:</th>
											<td align="left">
												<input type="text" class="w230" name="firstName" id="firstName" value="<?php	echo unEscapeSpecialCharacters($firstName);?>">
												<div id="firstName_msg" class="error_msg" ></div>
											</td>
										</tr>
										<tr><td height="7"></td></tr>
										<tr>
											<th align="left" valign="top">Sur Name</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<input type="text" class="w230" name="surName" id="surName" value="<?php	echo unEscapeSpecialCharacters($surName);?>">
												<div id="surName_msg" class="error_msg" ></div>
											</td>
										</tr>
										<tr><td height="7"></td></tr>
										<tr>
											<th align="left" valign="top">Company</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<input type="text" class="w230" name="company" id="company" value="<?php	echo unEscapeSpecialCharacters($company);?>">
												<div id="company_msg" class="error_msg" ></div>
											</td>
										</tr>
										<tr><td height="7"></td></tr>
										<tr>
											<th align="left" valign="top">Telephone</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<input type="text" class="w230" onkeypress="return isNumberKey(event);" name="telephone" id="telephone" value="<?php	echo unEscapeSpecialCharacters($telephone);?>">
												<div id="telephone_msg" class="error_msg" ></div>
											</td>
										</tr>
										<tr><td height="7"></td></tr>
										<tr>
											<th align="left" valign="top">Mobile</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<input type="text" class="w230" onkeypress="return isNumberKey(event);" name="mobile" id="mobile" value="<?php	echo unEscapeSpecialCharacters($mobile);?>">
												<div id="mobile_msg" class="error_msg" ></div>
											</td>
										</tr>
										<tr><td height="7"></td></tr>
										<tr>
											<th align="left" valign="top">Email</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<input type="text" class="w230" name="email" id="email" value="<?php	echo unEscapeSpecialCharacters($email);?>">
												<div id="email_msg" class="error_msg" ></div>
											</td>
										</tr>
										<tr><td height="7"></td></tr>
										<tr>
											<th align="left" valign="top">Website</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<input type="text" class="w230" name="website" id="website" value="<?php	echo unEscapeSpecialCharacters($website);?>">
												<div id="website_msg" class="error_msg" ></div>
											</td>
										</tr>
										<tr><td height="15"></td></tr>
										<tr><th align="left" valign="top" colspan="3" class="subtitle"><strong>PROFILE PICTURE</strong></th></tr>
										<tr><td height="7"></td></tr>
										<tr><td align="left" colspan="3">
											<div class="clr profilepic">
												<div class="profileimg">
												<?php  if(isset($_GET['add']) && $_GET['add'] == '1') { ?>
													<img src="" height="100" width="100"  alt="Image" title="Image" style="display:none;" id="hidden_img" />
													<img src="../WebResources/Images/common/noimage.jpg" alt="Image" title="Image" id="noImage" width="100" height="100" alt="">
													<img class="deleteimg" name="deleteImage" title="Delete" style="display:none;border:0 none;position:absolute;right:520px;top:420px;" id="deleteImage"  src="<?php  echo IMAGE_PATH."delete.png"  ?>"  onclick="deleteProfileImageSignup();">
												<?php  } else {  ?>
													<?php  if(isset($profile_path) && $profile_path !='' && file_exists($profile_path_abs)) { ?>
														<img src="<?php  echo $profile_path;  ?>" height="100" width="100" alt="Image" title="Image" style="display:block;" id="hidden_img" />
														<img style="display:none;" src="../WebResources/Images/common/noimage.jpg" alt="Image" title="Image" id="noImage" width="100" height="100" alt="">
														<img style="display:block;border:0 none;position:absolute;right:520px;top:420px;" name="deleteImage" title="Delete" id="deleteImage"  src="<?php  echo IMAGE_PATH."delete.png"  ?>"  onclick="deleteProfileImage('<?php  echo $id;  ?>','<?php  echo $imageExt;  ?>','2');">
													<?php  } else {  ?>
														<img src="" height="100" width="100" alt="Image" title="Image" style="display:none;" id="hidden_img" />
														<img src="../WebResources/Images/common/noimage.jpg" alt="Image" title="Image" id="noImage" width="100" height="100" alt="">
														<img name="deleteImage" style="display:none;border:0 none;position:absolute;right:520px;top:420px;" title="Delete" id="deleteImage"  src="<?php  echo IMAGE_PATH."delete.png"  ?>"  onclick="deleteProfileImage('<?php  echo $id;  ?>','<?php  echo $imageExt;  ?>','2');">
													<?php  }  ?>
												<?php  }  ?>
												</div><!--   -->
												<label><input onchange="ajaxProfileImageUpload('users_form');" type="file"  id="profileImage" name="profileImage"  placeholder="" class="inputbox" value="" /></label>
												<div id="profilePic_msg" class="clr error_msg" ></div>
												<span class="exampletxt">Recommended 300px by 300px jpeg</span>
												<input type="hidden" id="profile_img_name" name="profile_img_name" value="<?php  echo $imageName;  ?>" />
												<input type="hidden" id="profile_img_ext" name="profile_img_ext" value="<?php  echo $imageExt;  ?>" />
												<input type="hidden" id="img_type" name="img_type" value="" />
											</div>
										</td></tr>
									</table>
								</td>
								<td valign="top" width="30%">
									<table cellpadding="0" cellspacing="0" width="95%" align="center">
										<tr><th align="left" colspan="3" valign="top" class="subtitle">POSTAL ADDRESS</th></tr>
										<tr><td height="15"></td></tr>
										<tr>
											<th align="left" valign="top" width="30%">Street Name</th>
											<th align="center" valign="top" width="5%">:</th>
											<td align="left">
												<input type="text" class="w230" name="streetName" id="streetName" value="<?php	echo unEscapeSpecialCharacters($streetName);?>">
												<div id="streetName_msg" class="error_msg" ></div>
											</td>
										</tr>
										<tr><td height="7"></td></tr>
										<tr>
											<th align="left" valign="top">City</th>
											<th align="center" valign="top">:</th>
											<td align="left">
											<input type="text" class="w230" name="city" id="city" value="<?php	echo unEscapeSpecialCharacters($city);?>">
											<div id="city_msg" class="error_msg" ></div>
											</td>
										</tr><tr><td height="7"></td></tr>
										<tr>
											<th align="left" valign="top">State</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<input type="text" class="w230" name="state" id="state" value="<?php	echo unEscapeSpecialCharacters($state);?>">
												<div id="state_msg" class="error_msg" ></div>
											</td>
										</tr>
										<tr><td height="7"></td></tr>
										<tr>
											<th align="left" valign="top">Zip Code</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<input type="text" class="w230" name="zipCode" id="zipCode" value="<?php	echo unEscapeSpecialCharacters($zipCode);?>">
												<div id="zipCode_msg" class="error_msg" ></div>
											</td>
										</tr><tr><td height="7"></td></tr>
										<tr>
											<th align="left" valign="top">Country</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<input type="text" class="w230" name="country" id="country" value="<?php	echo unEscapeSpecialCharacters($country);?>">
												<div id="country_msg" class="error_msg" ></div>
											</td>
										</tr>
										</tr><tr><td height="7"></td></tr>
										<tr>
											<th align="left" valign="top"></th>
											<th align="center" valign="top"></th>
											<td align="left">
											<div class="clr homechk">
												<input id="billingAddress" name="billingAddress" type="checkbox" value="" />&nbsp;<label> Billing address is different to<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	postal address.</label>
												<input type="hidden" name="billingStatus" id="billingStatus" value="1">
												<div id="billingAddress_msg" class="error_msg" ></div>
											</div>
											</td>
										</tr>
										<tr><td height="7"></td></tr>
										
										<tr class="billingAddressDiv" style="display:none">
											<th align="left" valign="top" class="subtitle" colspan="3">BILLING ADDRESS</th>
										</tr>
										<tr class="billingAddressDiv" style="display:none"><td height="15"></td></tr>
										<tr class="billingAddressDiv" style="display:none">
											<th align="left" valign="top">Street Name</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<input type="text" class="w230" name="billingStreetName" id="billingStreetName" value="<?php	echo unEscapeSpecialCharacters($billingStreetName);?>">
												<div id="billingStreetName_msg" class="error_msg" ></div>
											</td>
										</tr>
										<tr class="billingAddressDiv" style="display:none"><td height="7"></td></tr>
										<tr class="billingAddressDiv" style="display:none">
											<th align="left" valign="top">City</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<input type="text" class="w230" name="billingCity" id="billingCity" value="<?php	echo unEscapeSpecialCharacters($billingCity);?>">
												<div id="billingCity_msg" class="error_msg" ></div>
											</td>
										</tr>
										<tr class="billingAddressDiv" style="display:none"><td height="7"></td></tr>
										<tr class="billingAddressDiv" style="display:none">
											<th align="left" valign="top">State</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<input type="text" class="w230" name="billingState" id="billingState" value="<?php	echo unEscapeSpecialCharacters($billingState);?>">
												<div id="billingState_msg" class="error_msg" ></div>
											</td>
										</tr>
										<tr class="billingAddressDiv" style="display:none"><td height="7"></td></tr>
										<tr class="billingAddressDiv" style="display:none">
											<th align="left" valign="top">Zip Code</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<input type="text" class="w230" name="billingZipCode" id="billingZipCode" value="<?php	echo unEscapeSpecialCharacters($billingZipCode);?>">
												<div id="billingZipCode_msg" class="error_msg" ></div>
											</td>
										</tr>
										<tr class="billingAddressDiv" style="display:none"><td height="7"></td></tr>
										<tr class="billingAddressDiv" style="display:none">
											<th align="left" valign="top">Country</th>
											<th align="center" valign="top">:</th>
											<td align="left">
												<input type="text" class="w230" name="billingCountry" id="billingCountry" value="<?php	echo unEscapeSpecialCharacters($billingCountry);?>">
												<div id="billingCountry_msg" class="error_msg" ></div>
												
											</td>
										</tr>
										<tr><td height="7"></td></tr>
									</table>
								</td>
							</tr>
							<tr><td height="20"></td></tr>							
							<tr>
								<td colspan="3" align="center">
									<input type="hidden" id="user_id" name="user_id" value="<?php echo $id; ?>">
									<?php  if(isset($_GET['add']) && $_GET['add'] == '1') { ?>
										<input type="Submit" class="button" onclick="return validateUserEdit();" tabindex="3" value="Add" title="Add user" alt="Add user" name="add_user_submit" id="add_user_submit" />&nbsp;&nbsp;
										<input type="hidden" id="edit_status" name="edit_status" value="0">
									<?php  } else {  ?>
										<input type="Submit" class="button" onclick="return validateUserEdit();" tabindex="3" value="Update" title="Update" alt="Update" name="user_submit" id="user_submit" />&nbsp;&nbsp;
										<input type="hidden" id="edit_status" name="edit_status" value="1">
									<?php  }  ?>
									<input type="Button" class="button" tabindex="4" value="Back" title="Back" alt="Back" name="Back" id="Back" onclick="location.href='user_listing.php'" />
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
<script type="text/javascript">
	$(function() {
		var availableTags = [<?php foreach($country_array as $key => $value) { ?> '<?php echo $value; ?>' ,<?php } ?> ];
	    $("#country").autocomplete({
			source: availableTags
	    }).focus(function(){            
	            $(this).data("autocomplete").search($(this).val());
				$('.ui-menu').css('padding-left','0px');
				$('.ui-menu').css('width','185px');
				
	    });
		$("#billingCountry").autocomplete({
			source: availableTags
	    }).focus(function(){            
	            $(this).data("autocomplete").search($(this).val());
				$('.ui-menu').css('padding-left','0px');
				$('.ui-menu').css('width','185px');
	    });
	});
	$(document).ready(function(){
		//$('input').attr('autocomplete','off');
		$('#billingAddress').click(function() {
			if($("#billingAddress").is(':checked')){
				$(".billingAddressDiv").fadeIn(); //fadeIn
				$("#billingStatus").val(0);
			}
			else{
				$(".billingAddressDiv").fadeOut();	//fadeOut
				$("#billingStatus").val(1);
			}
		});
		
		/*$('#country').click(function(){
			//alert("----------------------->" );
			$('.ui-menu').attr('style','padding-left:16px;');
		});*/
	});
</script>
