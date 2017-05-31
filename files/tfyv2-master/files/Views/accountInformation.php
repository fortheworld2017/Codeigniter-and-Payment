<?php
	ob_start();
	if (!session_id()) session_start();
	if(!isset($_SESSION['tac_data']['user_id']))
		header("Location:home");
	$_SESSION['create_page'] = 1;
	require_once('Controllers/UserController.php');
	$userControllerObj 	= 	new UserController();
	$userName = $firstName = $surName = $company = $telephone = $mobile = $email = $website = $postalStreetName = $imageName = $imageExt = $postalCity = $postalState = $postalZipCode = $postalCountry = $billingStreetName = $billingCity = $billingState = $billingZipCode = $billingCountry = '';
	$update_msg_display = 	'none';
	$update_msg			=	'';
	$msg_class			=	"success_msg";
	$pass_msg			=	"block";
	$profile_ext		=	"";
	$billingDisplay 	= 	"none";
	$billingStatus 		= 	"1";
?>
<?php
	if(isset($_POST['userName']) && $_POST['userName'] != ''){
		$signup_Array['username'] 	= 	$_POST['userName'];
		$signup_Array['email'] 	  	= 	$_POST['email'];
		$signup_Array['password'] 	= 	$_POST['newPassword'];
		$userEmailexist	= $userControllerObj->checkUserNameExist($_POST['email']);
		if(isset($userEmailexist) && is_array($userEmailexist)) {
			header("Location:accountInformation?msg=4");die();
			$msg = 4;
		}
		else{
			
			$sql = '';
			$bindParams = array();
			print_r($_FILES['profileImage']);
			print_r($_POST);
			if(isset($_FILES['profileImage']['name']) && $_FILES['profileImage']['name'] != '' && isset($_POST['img_type']) && $_POST['img_type'] == '1') {
				$profile_img_array 			=	explode(".",$_FILES['profileImage']['name']);
				$profile_ext				=	end($profile_img_array);
				$profile_name				=	$profile_img_array[0];
				
				$path 			= 	ABS_IMAGE_PATH_PROFILE.$_SESSION['tac_data']['user_id'].'.'.$profile_ext;
				$path_thumb 	= 	ABS_IMAGE_PATH_PROFILE.'thumb/'.$_SESSION['tac_data']['user_id'].'.'.$profile_ext;
				if(file_exists($path))
					unlink($path);
				copy($_FILES['profileImage']['tmp_name'],$path);
				echo "Uehhhh".$path;
				
				if(file_exists($path_thumb))
					unlink($path_thumb);
				copy($_FILES['profileImage']['tmp_name'],$path_thumb);
				
				$sql .= "profileImage		=	?,";
				$bindParams[] = $profile_ext;
			}
			if(isset($_POST['userHidden']) && $_POST['userHidden'] == '1'){
				if(isset($_POST['oldPassword']) && $_POST['oldPassword'] != '' && isset($_POST['newPassword']) && $_POST['newPassword'] != ''){
					if(md5($_POST['oldPassword']) != $_POST['passwordHidden']){
						header("Location:accountInformation?err=1");
						die();
					}
					else{
						$sql .= "password	=	?,";
						$bindParams[] = MD5($_POST['newPassword']);
					}
				}
				$sql .= "username 			=	?,";
				$bindParams[] = $_POST['userName'];
			}
			if(isset($_POST['contactHidden']) && $_POST['contactHidden'] == '1'){
				$sql .= "firstName			=	?,
						surName				=	?,
						company				=	?,
						telephone			=	?,
						mobile				=	?,
						website				=	?,";
				array_push($bindParams, $_POST['firstName'],
										$_POST['surName'],
										$_POST['company'],
										$_POST['telephone'],
										$_POST['mobile'],
										$_POST['website']);
			}
			if(isset($_POST['postalHidden']) && $_POST['postalHidden'] == '1'){
				if(isset($_POST['billingStatus']) && $_POST['billingStatus'] == 1){
					$sql .= "streetName			=	?,
							city				=	?,
							state				=	?,
							zipCode				=	?,
							country				=	?,
							billingStreetName	=	?,
							billingCity			=	?,
							billingState		=	?,
							billingZipCode		=	?,
							billingCountry		=	?,
							billingStatus		=	?,";
					array_push($bindParams, $_POST['streetName'],
											$_POST['city'],
											$_POST['state'],
											$_POST['zipCode'],
											$_POST['country'],
											$_POST['streetName'],
											$_POST['city'],
											$_POST['state'],
											$_POST['zipCode'],
											$_POST['country'],
											$_POST['billingStatus']);
				}
				else{
					$sql .= "streetName			=	?,
							city				=	?,
							state				=	?,
							zipCode				=	?,
							country				=	?,
							billingStatus		=	?,";
					array_push($bindParams, $_POST['streetName'],
											$_POST['city'],
											$_POST['state'],
											$_POST['zipCode'],
											$_POST['country'],
											$_POST['billingStatus']);
				}
			}
			if(isset($_POST['billingHidden']) && $_POST['billingHidden'] == '1'){
				$sql .= "billingStreetName	=	?,
						billingCity			=	?,
						billingState		=	?,
						billingZipCode		=	?,
						billingCountry		=	?,
						billingStatus		=	?,";
				array_push($bindParams, $_POST['billingStreetName'],
										$_POST['billingCity'],
										$_POST['billingState'],
										$_POST['billingZipCode'],
										$_POST['billingCountry'],
										$_POST['billingStatus']);
			}
			$userControllerObj->updateUserAccount($sql,$_SESSION['tac_data']['user_id'], $bindParams);
			$update_msg_display 	= 	'block';
			$update_msg 			= 	'Account Information Updated Succesfully';
			$msg_class				=	"success_msg";
			$pass_msg				=	"none";
		}
	}
	
	if(isset($_SESSION['tac_data']['user_id']) && $_SESSION['tac_data']['user_id'] != ''){
		$cond 			= 	" and id = ? ";
		$user_details	=	$userControllerObj->getUserInfo($cond, array($_SESSION['tac_data']['user_id']));
		
		if(isset($user_details) && is_array($user_details) && count($user_details) > 0){
			foreach($user_details as $key => $value){
				$billingStatus 		= $value->billingStatus;
				
				if($billingStatus == 0)
					$billingDisplay = "block";
				else if($billingStatus == 1)
					$billingDisplay = "none";
				
				$userName 			= $value->username;
				$password 			= $value->password;
				$firstName 			= $value->firstName;
				$surName 			= $value->surName;
				$company 			= $value->company;
				$telephone 			= $value->telephone;
				$mobile 			= $value->mobile;
				$email 				= $value->email;
				$website 			= $value->website;
				$postalStreetName 	= $value->streetName;
				$postalCity 		= $value->city;
				$postalState 		= $value->state;
				$postalZipCode 		= $value->zipCode;
				$postalCountry 		= $value->country;
				$billingStreetName 	= $value->billingStreetName;
				$billingCity 		= $value->billingCity;
				$billingState 		= $value->billingState;
				$billingZipCode 	= $value->billingZipCode;
				$billingCountry 	= $value->billingCountry;
				//$profile_name		= $value->profileImageName;
				$profile_ext		= $value->profileImage;
				if(isset($value->profileImage) && $value->profileImage != ''){
					$image_path 	= 	ABS_IMAGE_PATH_PROFILE.$_SESSION['tac_data']['user_id'].'.'.$profile_ext;
				if(file_exists($image_path))
					$profilePicture	=	IMAGE_PATH_PROFILE.$_SESSION['tac_data']['user_id'].'.'.$profile_ext;
				}
			}
		}
	}
	if(isset($_GET['msg']) && $_GET['msg'] == 4){
		$update_msg_display 	= 	'block';
		$update_msg 			= 	'Email is already exist';
		$msg_class				=	"error_msg";
	}
	//echo "<br>++><pre>"; print_r($billingStatus); echo "</pre><++";
	//$billingStatus = 0;
?>
<?php siteHeader(); ?>
	<!-- Content : Start -->
	<div class="Bodycontent">
		<!-- Left nav : Start -->
		<?php leftNav();?>
		<!-- Left nav : End -->
		<div class="inner_container">
			<!-- Breadcrum : Start -->
			<?php breadCrumb();?>
			<!-- Breadcrum : End -->
			<div class="account">
				<form id="accountInfoForm" name="accountInfoForm" action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="passwordHidden" id="passwordHidden" value="<?php  echo $password;  ?>">
				<div class="signup">	
					<div class="<?php  echo $msg_class;  ?>" id="error_div" style="display:<?php  echo $update_msg_display;  ?>;padding-left: 250px;"><?php  echo $update_msg;  ?></div>
						<?php  if(isset($_GET['err']) && $_GET['err'] != '') { ?>
							<div class="error_msg" style="display:<?php  echo $pass_msg;  ?>;padding-left: 0px;">Old password is incorrect</div>
						<?php  }  ?>
						<div class="stepone"> 
							<h2>USERNAME/PASSWORD</h2>
							<input type="hidden" name="userHidden" id="userHidden" value="0">
							<div class="clr">
								<label><input type="text" id="userName" name="userName" placeholder="USERNAME" class="user inputbox" value="<?php  echo unEscapeSpecialCharacters($userName);  ?>" readonly /></label>
								<div id="userName_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="password" id="oldPassword" name="oldPassword" placeholder="OLD PASSWORD" class="user inputbox" value="" readonly /></label>
								<div id="oldPassword_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="password" id="newPassword" name="newPassword" placeholder="NEW PASSWORD" class="user inputbox" value="" readonly /></label>
								<div id="newPassword_msg" class="error_msg clear" ></div>
							</div>
							<div class="clr">
								<label><input type="password" id="confirmPassword" name="confirmPassword" placeholder="CONFIRM PASSWORD" class="user inputbox" value="" readonly /></label>
								<div id="confirmPassword_msg" class="error_msg clear" ></div>
							</div>
							<div class="clr buttonr">
								<input type="button" id="userEdit" name="userEdit" value="Edit" class="greybut" onclick="editAccount('user');">
								<input style="display:none;" type="button" id="userCancel" name="userCancel" value="Cancel" class="greybut" onclick="cancelAccount('user');">
							</div>
						</div>
								
						<div class="steptwo"> 
							<h2>CONTACT DETAILS</h2>
							<input type="hidden" name="contactHidden" id="contactHidden" value="0">
							<div class="clr">
								<label><input type="text" id="firstName" name="firstName" placeholder="FIRST NAME" class="contact inputbox" value="<?php  echo unEscapeSpecialCharacters($firstName);  ?>" readonly /></label>
								<div id="firstName_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="surName" name="surName" placeholder="SURNAME" class="contact inputbox" value="<?php  echo unEscapeSpecialCharacters($surName);  ?>" readonly /></label>
								<div id="surName_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="company" name="company" placeholder="COMPANY" class="contact inputbox" value="<?php  echo unEscapeSpecialCharacters($company);  ?>" readonly /></label>
								<div id="company_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="telephone" name="telephone" placeholder="TELEPHONE" onkeypress="return isNumberKey(event);" class="contact inputbox" value="<?php  echo unEscapeSpecialCharacters($telephone);  ?>" readonly /></label>
								<div id="telephone_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="mobile" name="mobile" placeholder="MOBILE" onkeypress="return isNumberKey(event);" class="contact inputbox" value="<?php  echo unEscapeSpecialCharacters($mobile);  ?>" readonly /></label>
								<div id="mobile_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="email" name="email" placeholder="EMAIL" class="inputbox" value="<?php  echo unEscapeSpecialCharacters($email);  ?>" readonly /></label>
								<div id="email_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="website" name="website" placeholder="WEBSITE" class="contact inputbox" value="<?php  echo unEscapeSpecialCharacters($website);  ?>" readonly /></label>
								<div id="website_msg" class="error_msg" ></div>
							</div>
							<div class="clr buttonr">
								<input type="button" id="contactEdit" name="contactEdit" value="Edit" class="greybut" onclick="editAccount('contact');">
								<input type="button" style="display:none;" id="contactCancel" name="contactCancel" value="Cancel" class="greybut" onclick="cancelAccount('contact');">
							</div>
							<div class="clear"><br></div>
							<h2>PROFILE PIC <b>(Optional)</b></h2><!-- onchange="ajaxfileUpload('signUpForm','profileImage',1)" -->
							<div class="clr profilepic">
								<div class="profileimg">
									<?php  if(isset($profilePicture) && $profilePicture !='') { ?>
										<img src="<?php  echo $profilePicture;  ?>" height="100" width="100" alt="Image" title="Image" style="display:block;" id="hidden_img" />
										<img style="display:none;" src="WebResources/Images/common/noimage.jpg" alt="Image" title="Image" id="noImage" width="100" height="100" alt="">
										<img  class="deleteimg" title="Delete" name="deleteImage" id="deleteImage"  src="<?php  echo IMAGE_PATH."delete.png"  ?>"  onclick=" return deleteProfileImage('<?php  echo $_SESSION['tac_data']['user_id'];  ?>','<?php  echo $profile_ext;  ?>','1');">
									<?php  } else {  ?>
										<img src="" height="100" width="100" alt="Image" title="Image" style="display:none;" id="hidden_img" />
										<img src="WebResources/Images/common/noimage.jpg" alt="Image" title="Image" id="noImage" width="100" height="100" alt="">
										<img  class="deleteimg" title="Delete" name="deleteImage" style="display:none;" id="deleteImage"  src="<?php  echo IMAGE_PATH."delete.png"  ?>"  onclick=" return deleteProfileImage('<?php  echo $_SESSION['tac_data']['user_id'];  ?>','<?php  echo $profile_ext;  ?>','1');">
									<?php  }  ?>
								</div>
								<div class="relative">
									<input  onchange="ajaxProfileImageUpload('accountInfoForm','<?php  echo $_SESSION['tac_data']['user_id'];  ?>');" type="file"  id="profileImage" name="profileImage"  placeholder="" class="file_photo" value="" />
									<span class="fakefile_photo">
										<input type="text" class="browsebut" value="" >
									</span>
								</div><br><br>
								<span class="clear exampletxt">Recommended 300px by 300px jpeg</span>
								<div id="profilePic_msg" class="clr error_msg" ></div>
								<input type="hidden" id="profile_img_name" name="profile_img_name" value="<?php  echo $imageName;  ?>" />
								<input type="hidden" id="profile_img_ext" name="profile_img_ext" value="<?php  echo $profile_ext;  ?>" />
								<input type="hidden" id="img_type" name="img_type" value="" />
							</div>										
						</div>
						<div class="stepthree"> 
							<h2>POSTAL ADDRESS</h2>
							<input type="hidden" name="postalHidden" id="postalHidden" value="0">
							<div class="clr">
								<label><input type="text" id="streetName" name="streetName" placeholder="STREET NAME" class="postal inputbox" value="<?php  echo unEscapeSpecialCharacters($postalStreetName);  ?>" readonly /></label>
								<div id="streetName_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="city" name="city" placeholder="CITY" class="postal inputbox" value="<?php  echo unEscapeSpecialCharacters($postalCity);  ?>" readonly /></label>
								<div id="city_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="state" name="state" placeholder="STATE" class="postal inputbox" value="<?php  echo unEscapeSpecialCharacters($postalState);  ?>" readonly /></label>
								<div id="state_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="zipCode" name="zipCode" placeholder="ZIP CODE" class="postal inputbox" value="<?php  echo unEscapeSpecialCharacters($postalZipCode);  ?>" readonly /></label>
								<div id="zipCode_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="country" name="country" placeholder="COUNTRY" class="postal inputbox" value="<?php  echo unEscapeSpecialCharacters($postalCountry);  ?>" readonly /></label>
								<div id="country_msg" class="error_msg" ></div>
							</div>
							<div class="clr homechk">
								<input id="billingAddress" <?php  if(isset($billingStatus) && $billingStatus == '0') echo "checked=checked";  ?> name="billingAddress" class="postal_checkbox" type="checkbox" value="" disabled="disabled" />&nbsp;&nbsp;<label> Billing address is different to<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	postal address.</label>
								<input type="hidden" name="billingStatus" id="billingStatus" value="<?php  echo $billingStatus;  ?>">
								<div id="billingAddress_msg" class="error_msg" ></div>
							</div>
							<div class="clr buttonr">
								<input type="button" id="postalEdit" name="billingEdit" value="Edit" class="greybut" onclick="editAccount('postal');">
								<input type="button" style="display:none;" id="postalCancel" name="postalCancel" value="Cancel" class="greybut" onclick="cancelAccount('postal');">
							</div>
							
							<div class="clear"><br></div>
							<div id="billingAddressDiv" style="padding-top:10px;display:<?php  echo $billingDisplay;  ?>">					
								<h2>BILLING ADDRESS</h2>
								<input type="hidden" name="billingHidden" id="billingHidden" value="0">
								<div class="clr">
									<label><input type="text" id="billingStreetName" name="billingStreetName" placeholder="STREET NAME" class="billing inputbox" value="<?php  echo unEscapeSpecialCharacters($billingStreetName);  ?>" readonly /></label>
									<div id="billingStreetName_msg" class="error_msg" ></div>
								</div>
								<div class="clr">
									<label><input type="text" id="billingCity" name="billingCity" placeholder="CITY" class="billing inputbox" value="<?php  echo unEscapeSpecialCharacters($billingCity);  ?>" readonly /></label>
									<div id="billingCity_msg" class="error_msg" ></div>
								</div>
								<div class="clr">
									<label><input type="text" id="billingState" name="billingState" placeholder="STATE" class="billing inputbox" value="<?php  echo unEscapeSpecialCharacters($billingState);  ?>" readonly /></label>
									<div id="billingState_msg" class="error_msg" ></div>
								</div>
								<div class="clr">
									<label><input type="text" id="billingZipCode" name="billingZipCode" placeholder="ZIP CODE" class="billing inputbox" value="<?php  echo unEscapeSpecialCharacters($billingZipCode);  ?>" readonly /></label>
									<div id="billingZipCode_msg" class="error_msg" ></div>
								</div>
								<div class="clr">
									<label><input type="text" id="billingCountry" name="billingCountry" placeholder="COUNTRY" class="billing inputbox" value="<?php  echo unEscapeSpecialCharacters($billingCountry);  ?>" readonly /></label>
									<div id="billingCountry_msg" class="error_msg" ></div>
								</div>
								<div class="clr buttonr">
									<input type="button" id="billingEdit" name="billingEdit" value="Edit" class="greybut" onclick="editAccount('billing');">
									<input type="button" style="display:none;" id="billingCancel" name="billingCancel" value="Cancel" class="greybut" onclick="cancelAccount('billing');">
								</div>
							</div>							
							<div class="clear"><br></div>
							<div class="clr buttonr">
								<input type="submit" id="account_submit" name="account_submit" class="yellowbut" value="SAVE DETAILS" onclick="return validateAccountInfo();">
							</div>
						</div>
					<div class="clearh"></div>
				</div>
				<input type="hidden" id="errorFlag" name="errorFlag" value="0">
				</form>
				<iframe src="uploadAction?" id="imguploadprintpic" height="0" width="0"  name="imguploadprintpic" frameborder="0" ></iframe>
				<?php // } else if(isset($userInsert_Id) && $userInsert_Id != '')  { ?>
				<?php // }  ?>
			</div><!-- Account -->
		</div>
	</div>
	<!-- Content : End -->
	<div class="clearh"></div>


<?php 
	//iframe();
	siteFooter(); 
// call siteFooter from template ?>
<script>
	function editAccount(classEdit){
		$('.'+classEdit).removeAttr("readonly");
		$('#'+classEdit+'Hidden').val(1);
		$('#'+classEdit+'Cancel').show();
		$('#'+classEdit+'Edit').hide();
		$("#account_submit").removeAttr("disabled");
		if(classEdit == 'postal')
			$(".postal_checkbox").removeAttr("disabled");
	}
	function cancelAccount(classCancel){
		$('.'+classCancel).attr("readonly","readonly");
		$('#'+classCancel+'Hidden').val(0);
		$('#'+classCancel+'Cancel').hide();
		$('#'+classCancel+'Edit').show();
		
		if(classCancel == 'postal')
			$(".postal_checkbox").attr("disabled","disabled");
	}
	$(function() {
		var availableTags = [<?php foreach($country_array as $key => $value) { ?> '<?php echo $value; ?>' ,<?php } ?> ];
	    $("#country").autocomplete({
			source: availableTags
	    }).focus(function(){            
	            $(this).data("autocomplete").search($(this).val())
	    });
		$("#billingCountry").autocomplete({
			source: availableTags
	    }).focus(function(){            
	            $(this).data("autocomplete").search($(this).val())
	    });
	});
	$(document).ready(function(){
		//$('input').attr('autocomplete','off');
		$('#billingAddress').click(function() {
			if($("#billingAddress").is(':checked')){
				$("#billingAddressDiv").fadeIn(); //fadeIn
				$("#billingStatus").val(0);
				$('.billing').val('');
			}
			else{
				$("#billingAddressDiv").fadeOut();	//fadeOut
				$("#billingStatus").val(1);
			}
		});
	});
</script>
