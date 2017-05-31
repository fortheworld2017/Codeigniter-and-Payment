<?php ob_start();
	if (!session_id()) session_start();
	if(isset($_SESSION['tac_data']['user_id'])){
		header("Location:createCard");
		die();
	}
	if(!isset($_SESSION['ses_home_fullname'])){
		header("Location:home");
		die();
	}
	require_once('Includes/CommonIncludes.php'); 
	
	checkTestLoginScreenUser();
	
	require_once('Controllers/UserController.php');
	$userControllerObj 	= 	new UserController();
	require_once('Controllers/AdminController.php');
	$admincontrollerobj = new AdminController();
	//require_once(ABS_PATH.'Controllers/MonitorController.php');
	//$MonitorControllerObj = new MonitorController();
	$display_signup 			= 	'none';
	$adminDetails				=	'';
	$err_msg 					= 	'';
	$error = $msg 				= 	'';
	$errClass = $err_msg_signup = 	'';
	$_POST['image_name']		= 	'';
	$_POST['image_extension']	= 	'';
	$signup_Array 				= 	'';
	$firstName					=	'';
	$lastName					=	'';
	if(isset($_POST)){
		//$_POST = escapeSpecialCharacters($_POST);
	}
	
	if(isset($_SESSION['ses_home_fullname']) && $_SESSION['ses_home_fullname'] != '')
	{
		$name_array = explode(' ',$_SESSION['ses_home_fullname']);
		if(isset($name_array) && is_array($name_array) && count($name_array) > 0) {
			if(count($name_array) > 1)
			{
				for($i=0; $i < count($name_array)-1; $i++)
				{
					$firstName .= $name_array[$i].' ';
				}
				$lastName = $name_array[(count($name_array)-1)];
			}
			else
				$firstName .= $name_array[0];
		}
	}
	if(isset($_POST['userName'])) {
		if(isset($_POST['email']) && $_POST['email']!=''){
			
			//$_POST	=	escapeSpecialCharacters($_POST);
			$signup_Array['username'] 	= 	$_POST['userName'];
			$signup_Array['email'] 	  	= 	$_POST['email'];
			$signup_Array['password'] 	= 	$_POST['password'];
			$userEmailexist	= $userControllerObj->checkUserNameExist($_POST['email']);
			if(isset($userEmailexist) && is_array($userEmailexist)) {
				header("Location:signup?msg=4");die();
				$msg = 4;
			} else{
				
				if(isset($_FILES['profileImage']['name']) && $_FILES['profileImage']['name'] != '') {
					$profile_img_array 		=	explode(".",$_FILES['profileImage']['name']);
					$profile_ext			=	end($profile_img_array);
					$profile_name			=	$profile_img_array[0];
					
					if(isset($_POST['img_type']) && $_POST['img_type'] == '1'){ 
						$_POST['image_name']		= $profile_name;
						$_POST['image_extension']	= $profile_ext;
					}
					else{
						$_POST['image_name']		= '';
						$_POST['image_extension']	= '';
					}
				}
				
				if(isset($_POST['billingStatus']) && $_POST['billingStatus'] == 1){
					$_POST['billingStreetName'] 	= 	$_POST['streetName'];
    				$_POST['billingCity'] 			= 	$_POST['city'];
    				$_POST['billingState'] 			= 	$_POST['state'];
    				$_POST['billingZipCode'] 		= 	$_POST['zipCode'];
    				$_POST['billingCountry'] 		= 	$_POST['country'];
				}
				
				$userInsert_Id = $userControllerObj->addUser($_POST);
				if(isset($userInsert_Id) && $userInsert_Id != '' && isset($_POST['img_type']) && $_POST['img_type'] == '1'){
					$path 		= 	ABS_IMAGE_PATH_PROFILE.$userInsert_Id.'.'.$profile_ext;
					$thumb_path = 	ABS_IMAGE_PATH_PROFILE.'thumb/'.$userInsert_Id.'.'.$profile_ext;
					copy($_FILES['profileImage']['tmp_name'],$path);
					copy($_FILES['profileImage']['tmp_name'],$thumb_path);
				}
				$_SESSION['tac_data']['user_id'] 		= 	$userInsert_Id;
				$_SESSION['tac_data']['user_email'] 	= 	$signup_Array['email'];
				$_SESSION['tac_data']['user_name'] 		= 	$signup_Array['username'];
				
				$adminDetails			=	$admincontrollerobj->getAdminDetail();
				if(is_array($adminDetails) && count($adminDetails) > 0){
					$adminDetails					=	$adminDetails[0];
					$adminDetails					=	unEscapeSpecialCharacters((array)$adminDetails);
					$mailContentArray['from']		= 	$adminDetails['emailAddress'];
				}
				$toMail								=	$_SESSION['tac_data']['user_email'];
				$mailContentArray['fileName']		=	'registration.txt';
				$mailContentArray['toemail']		= 	$toMail;
				$mailContentArray['subject']		= 	"Welcome to Tactify";
				$mailContentArray['greetMail']		=	GREETING_TEXT;
				$mailContentArray['userName']		=	$_SESSION['tac_data']['user_name'];
				$mailContentArray['link']			=	'<a href="'.SITE_PATH.'" target="_blank">here</a>';
				sendMail($mailContentArray,3);  // case for registration
				//header("Location:createCard");die();
			}
		}
	}
	if(isset($_GET['msg']) && $_GET['msg']== 4){
		$err_msg_signup		= 	'Email is already exist';
		$display_signup 	= 	'block';
	}
?>
	<?php siteHeader(); ?>
		<!-- Content : Start -->
	<div class="Bodycontent">
		<div class="Landing ">
			<div class="home">
				<form id="signUpForm" name="signUpForm" action="" method="post" enctype="multipart/form-data">
					<div class="signup">
					<?php  if(!isset($userInsert_Id)){  ?>
						<h1>SIGN UP</h1>
						<div class="error_msg" style="display:<?php  echo $display_signup;  ?>;text-align:center;"><?php  echo $err_msg_signup;  ?></div>
						<div class="stepone"> 
							<h2>USERNAME/PASSWORD</h2>
							<div class="clr">
								<label><input type="text" id="userName" name="userName" placeholder="USERNAME" class="inputbox" value="" /></label>
								<div id="userName_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="password" id="password" name="password" placeholder="PASSWORD" class="inputbox" value="<?php if(isset($_SESSION['ses_home_password']) && $_SESSION['ses_home_password'] != '') echo $_SESSION['ses_home_password']; ?>" /></label>
								<div id="password_msg" class="error_msg clear" ></div>
							</div>
							<div class="clr">
								<label><input type="password" id="confirmPassword" name="confirmPassword" placeholder="CONFIRM PASSWORD" class="inputbox" value="" /></label>
								<div id="confirmPassword_msg" class="error_msg clear" ></div>
							</div>
						</div>
						
						<div class="steptwo"> 
							<h2>CONTACT DETAILS</h2>
							<div class="clr">
								<label><input type="text" id="firstName" name="firstName" placeholder="FIRST NAME" class="inputbox" value="<?php echo $firstName; ?>" /></label>
								<div id="firstName_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="surName" name="surName" placeholder="SURNAME" class="inputbox" value="<?php echo $lastName; ?>" /></label>
								<div id="surName_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="company" name="company" placeholder="COMPANY" class="inputbox" value="" /></label>
								<div id="company_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="telephone" name="telephone" placeholder="TELEPHONE" onkeypress="return isNumberKey(event);" class="inputbox" value="" /></label>
								<div id="telephone_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="mobile" name="mobile" placeholder="MOBILE" onkeypress="return isNumberKey(event);" class="inputbox" value="" /></label>
								<div id="mobile_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="email" name="email" placeholder="EMAIL" class="inputbox" value="<?php if(isset($_SESSION['ses_home_email']) && $_SESSION['ses_home_email'] != '') echo $_SESSION['ses_home_email']; ?>" /></label>
								<div id="email_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="website" name="website" placeholder="WEBSITE" class="inputbox" value="" /></label>
								<div id="website_msg" class="error_msg" ></div>
							</div>
							<div class="clr">							
								<h2>PROFILE PIC <b>(Optional)</b></h2><!-- onchange="ajaxfileUpload('signUpForm','profileImage',1)" -->
							</div>
							<div class="clr profilepic">
								<div class="profileimg">
									<img src="" height="100" width="100" alt="Image" title="Image" style="display:none;" id="hidden_img" />
									<img src="WebResources/Images/common/noimage.jpg" alt="Image" title="Image" id="noImage" width="100" height="100" alt="">
									<img class="deleteimg" name="deleteImage" style="display:none" id="deleteImage"  src="<?php  echo IMAGE_PATH."delete.png"  ?>"  onclick="deleteProfileImageSignup();">
								</div>
								<div class="relative">
									<input  onchange="ajaxProfileImageUpload('signUpForm','');" type="file"  id="profileImage" name="profileImage"  placeholder="" class="file_photo" value="" />
									<span class="fakefile_photo">
										<input type="text" class="browsebut" value="" >
									</span>
								</div>								
								<span class="clear exampletxt"><br><br>
								Recommended 300px by 300px jpeg</span>
								<div id="profilePic_msg" class="clr error_msg" ></div>
								<input type="hidden" id="profile_img_name" name="profile_img_name" value="" />
								<input type="hidden" id="img_type" name="img_type" value="" />
							</div>							
						</div>
						
						<div class="stepthree"> 
							<h2>POSTAL ADDRESS</h2>
							<div class="clr">
								<label><input type="text" id="streetName" name="streetName" placeholder="STREET NAME" class="inputbox" value="" /></label>
								<div id="streetName_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="city" name="city" placeholder="CITY" class="inputbox" value="" /></label>
								<div id="city_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="state" name="state" placeholder="STATE" class="inputbox" value="" /></label>
								<div id="state_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="text" id="zipCode" name="zipCode" placeholder="ZIP CODE" class="inputbox" value="" /></label>
								<div id="zipCode_msg" class="error_msg" ></div>
							</div>
							<div class="clr">								
								<label><input type="text" id="country" name="country" placeholder="COUNTRY" class="inputbox" value="" /></label>
								<div id="country_msg" class="error_msg" ></div>
								<!-- <div class="relative country" >
										<div class="dropdown" id="country">
											<input type="text" value="" placeholder="COUNTRY" name="country" id="country" class="inputbox">
											<b onclick="shippingtriggerautocomplete()">v</b>
										</div>
										<div class="dropdown_option country_option" style="display: none">
											<ul></ul>	
										</div>
									</div> -->
							</div>
							<div class="clr homechk">
								<input id="billingAddress" name="billingAddress" type="checkbox" value="" />&nbsp;&nbsp;<label> Billing address is different to<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	postal address.</label>
								<input type="hidden" name="billingStatus" id="billingStatus" value="1">
								<div id="billingAddress_msg" class="error_msg" ></div>
							</div>
							<div class="billing_height">
								<div id="billingAddressDiv" style="display:none">					
									<h2>BILLING ADDRESS</h2>
									<div class="clr">
										<label><input type="text" id="billingStreetName" name="billingStreetName" placeholder="STREET NAME" class="inputbox" value="" /></label>
										<div id="billingStreetName_msg" class="error_msg" ></div>
									</div>
									<div class="clr">
										<label><input type="text" id="billingCity" name="billingCity" placeholder="CITY" class="inputbox" value="" /></label>
										<div id="billingCity_msg" class="error_msg" ></div>
									</div>
									<div class="clr">
										<label><input type="text" id="billingState" name="billingState" placeholder="STATE" class="inputbox" value="" /></label>
										<div id="billingState_msg" class="error_msg" ></div>
									</div>
									<div class="clr">
										<label><input type="text" id="billingZipCode" name="billingZipCode" placeholder="ZIP CODE" class="inputbox" value="" /></label>
										<div id="billingZipCode_msg" class="error_msg" ></div>
									</div>
									<div class="clr">
										<label><input type="text" id="billingCountry" name="billingCountry" placeholder="COUNTRY" class="inputbox" value="" /></label>
										<div id="billingCountry_msg" class="error_msg" ></div>
									</div>
								</div>
								<div class="clr homechk">
									<input id="agree" name="agree" type="checkbox" value="" /> <label>&nbsp;&nbsp;I agree to the <a href="#" title="terms and and conditions">terms and conditions</a>.</label>
									<div id="agree_msg" class="error_msg" ></div>
								</div>	
							</div>
							<div class="clr buttonr">
							<input type="submit" class="submit" id="signup_submit" name="signup_submit" value="SAVE DETAILS" onclick="return validateSignUp();">
						</div>						
						</div>
						
						<div class="clearh"></div>
					</div>
					<input type="hidden" id="errorFlag" name="errorFlag" value="0">
				</form>
				<iframe src="uploadAction?" id="imguploadprintpic" height="0" width="0"  name="imguploadprintpic" frameborder="0" ></iframe>
				<?php  } else if(isset($userInsert_Id) && $userInsert_Id != '')  { ?>
					<div style="width:860px;height:300px;text-align:center;">
						<h3>Thanks for signing up to Tactify!
						Please click <a href="createCard"> here </a> to continue.</h3>
					</div>
				<?php  }  ?>
			</div>
		</div>			
	</div>
	<!-- Content : End -->		
	<div class="clearh"></div>
</div>

<?php siteFooter(); // call siteFooter from template ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		//$('input').attr('autocomplete','off');
		$('#billingAddress').click(function() {
			if($("#billingAddress").is(':checked')){
				$("#billingAddressDiv").fadeIn(); //fadeIn
				$("#billingStatus").val(0);
			}
			else{
				$("#billingAddressDiv").fadeOut();	//fadeOut
				$("#billingStatus").val(1);
			}
		});
	});
	
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
	
</script>