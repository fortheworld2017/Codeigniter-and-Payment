<?php ob_start();
	if (!session_id()) session_start();
	if(isset($_SESSION['tac_data']['user_id'])){
		//header("Location:createCard");
		header("Location:homepage");
		die();
	}
	require_once('Includes/CommonIncludes.php'); 
	
	checkTestLoginScreenUser();
	
	require_once('Controllers/UserController.php');
	$userControllerObj 	= 	new UserController();
	
	require_once('Controllers/AdminController.php');
	$admincontrollerobj = new AdminController();
	/*require_once(ABS_PATH.'Controllers/MonitorController.php');
	$MonitorControllerObj = new MonitorController();*/
	
	/* Verify if IP address is blocked */
	require_once('Controllers/CardAttemptsController.php');
	$cardAttemptsControllerObj = new CardAttemptsController();
	require_once('Controllers/LoginFailsController.php');
	$loginFailsControllerObj = new LoginFailsController();
	
	$client_ip = getClientIP();
	$this_page = 'signin';
	
	if($cardAttemptsControllerObj->isIpBlocked($client_ip))
	{
		header('location:http://'.PRIMARY_DOMAIN.'/error');
		die();
	}
	
	$display_signin = 'block';
	$display_forget = 'none';
	$display_signup = 'none';
	$check_user_name_exist	=	'';
	$mail_content_array		=	'';
	$adminDetails			=	'';
	$err_msg = ''; 
	$error = $msg = ''; 
	$errClass = $err_msg_signup = '';
	$signup_Array = '';
	if(isset($_POST)){
		$_POST = escapeSpecialCharacters($_POST);
	}
	
	if(isset($_POST['signin_submit']) && $_POST['signin_submit']!=''){
		if(isset($_POST['signInEmail']) && $_POST['signInEmail']!=''){
			$userEmailexist	= $userControllerObj->selectEmaiPass($_POST['signInEmail'],$_POST['SignInPassword']); // for email and password check
			
			if(isset($userEmailexist) && is_array($userEmailexist)) {
				$userEmailexist	=	(array)$userEmailexist[0];
				$userEmailexist	=	unEscapeSpecialCharacters($userEmailexist);
				$_SESSION['tac_data']['user_id'] 		= $userEmailexist['id'];
				$_SESSION['tac_data']['user_name'] 		= $userEmailexist['username'];
				$_SESSION['tac_data']['user_email'] 	= $userEmailexist['email'];
				header("Location:dashboard");
				die();
				$display = 'none';
			} else{
				//header('Location:home?msg=1');
				$msg = 1;
				
				/* Updates failedLogins */
				$loginFailsControllerObj->insertLoginFail($client_ip,$_POST['signInEmail'],$this_page);
			} 
		}
	}
	
	// forget start
	if(isset($_POST['forgotEmail']))
	 { 
		if(isset($_POST['forgotEmail'])&&($_POST['forgotEmail']!=''))
			$check_user_name_exist		=	$userControllerObj->checkUserNameExist(escapeSpecialCharacters($_POST['forgotEmail']));
			if(is_array($check_user_name_exist) && count($check_user_name_exist)>0 ) { // User available
				$check_user_name_exist	=	(array)$check_user_name_exist[0];
				$check_user_name_exist	=	unEscapeSpecialCharacters($check_user_name_exist);
				$adminDetails			=	$admincontrollerobj->getAdminDetail();
				if(is_array($adminDetails) && count($adminDetails) > 0){
					$adminDetails					=	$adminDetails[0];
					$adminDetails					=	unEscapeSpecialCharacters((array)$adminDetails);
					$mailContentArray['from']		= 	$adminDetails['emailAddress'];
				}
				//--Generate new password
				list($salt, $passwd) = mkRandPasswd(); //PASSWD_LEN define inside the mkrandpasswd()
				$str_passwd = substr($salt, strlen($salt) / 4, PASSWD_LEN);
				$update = $userControllerObj->changePassword(trim($str_passwd),trim(escapeSpecialCharacters($_POST['forgotEmail'])));
				$toMail							=	$check_user_name_exist['email'];
				$mailContentArray['fileName']	=	'userForgotPasswordMail.txt';
				$mailContentArray['toemail']	= 	$toMail;
				$mailContentArray['subject']	= 	"Tactify Password Change";
				$mailContentArray['greetMail']	=	GREETING_TEXT;
				$mailContentArray['password']	=	trim($str_passwd);
				$mailContentArray['forget_link']	=	'<a href="'.FORGET_LINK.'" target="_blank">here</a>';
				$mailContentArray['username']	=   ucfirst($check_user_name_exist['username']);
				sendMail($mailContentArray,1);  // case for forget password
				$_SESSION['emailerrormsg'] = 0;
				$_SESSION['ses_forgetPassword'] = 1;
				//header('Location:home?msg=2');die();
				$msg = 2;
			} else {
				//header('Location:home?msg=3');die();
				$msg = 3;
			}
	} 
	// forget end
	
	if(isset($_POST['signup_submit'])) {
		if(isset($_POST['signUpEmail']) && $_POST['signUpEmail']!=''){
			
			$_POST	=	escapeSpecialCharacters($_POST);
			$signup_Array['username'] = $_POST['fullname'];
			$signup_Array['email'] 	  = $_POST['signUpEmail'];
			$signup_Array['password'] = $_POST['signUpPassword'];
			$userEmailexist	= $userControllerObj->checkUserNameExist($_POST['signUpEmail']);
			if(isset($userEmailexist) && is_array($userEmailexist)) {
				//header("Location:home?msg=4");die();
				$msg = 4;
			} else{
				$userInsert_Id = $userControllerObj->addUser($signup_Array);
				$_SESSION['tac_data']['user_id'] = $userInsert_Id;
				$_SESSION['tac_data']['user_email'] = $signup_Array['email'];
				$_SESSION['tac_data']['user_name'] 	= 	$signup_Array['username'];
				$adminDetails			=	$admincontrollerobj->getAdminDetail();
				if(is_array($adminDetails) && count($adminDetails) > 0){
					$adminDetails					=	$adminDetails[0];
					$adminDetails					=	unEscapeSpecialCharacters((array)$adminDetails);
					$mailContentArray['from']		= 	$adminDetails['emailAddress'];
				}
				$toMail							=	$_SESSION['tac_data']['user_email'];
				$mailContentArray['fileName']	=	'registration.txt';
				$mailContentArray['toemail']	= 	$toMail;
				$mailContentArray['subject']	= 	"Welcome to Tactify";
				$mailContentArray['greetMail']	=	GREETING_TEXT;
				$mailContentArray['userName']	    =	$_SESSION['tac_data']['user_name'];
				$mailContentArray['link']	=	'<a href="'.SITE_PATH.'" target="_blank">here</a>';
				sendMail($mailContentArray,3);  // case for registration
				//header("Location:createCard");
				//header("Location:homepage");
				header("Location:dashboard");
				die();
			}
		}
	}
	if(isset($msg) && $msg== 1){
		$display_signin = 'block';
		$display_forget = 'none';
		$err_msg = 'Invalid email or password';
	}else if(isset($msg) && $msg== 2){
		$err_msg = 'Your new password has been sent to your mail';
		$display_signin = 'block';
		$display_forget = 'none';
	} else if(isset($msg) && $msg== 3){
		$err_msg = 'Email not exists';
		$display_forget = 'block';
		$display_signin = 'none';
	}
	else if(isset($msg) && $msg== 4){
		$err_msg_signup  = 'Email is already exist';
		$errClass = 'error_msg';
		$display_signup = 'block';
		$display_signin = 'block';
	}
	?>
	
	<?php siteHeader(); ?>		
		<!-- Content : Start -->
	<div class="Bodycontent">
		<div class="Landing">
			<div class="signin">
			<?php if($loginFailsControllerObj->isIpBlocked($client_ip)) { ?>
				<?php $remaining_delay = $loginFailsControllerObj->getRemainingDelay($client_ip); ?>
				<h1 id="signinTitle">SIGN IN</h1>
				
				<div class="signIn_div">
					<?php echo "You must wait ".$remaining_delay." before your next login attempt. " ?>
				</div>
				
				<div class="clearh"></div>
			<?php } else { /* if($loginFailsControllerObj->isIpBlocked($client_ip)) */ ?>
				<h1 id="signinTitle">SIGN IN</h1>
				<!-- <div  class="youtube_bg">
					<table style="margin:auto;">
						<tr>
							<td><img src="<?php echo IMAGE_PATH; ?>phone-vtop.png" width="36" height="243" alt=""></td>
							<td style="background:#000">
								<iframe width="355" height="240" frameborder="0" allowfullscreen="" src="<?php echo LANDING_VIDEO; ?>"></iframe>
							</td>
							<td><img src="<?php echo IMAGE_PATH; ?>phone-vbottom.png"></td>
						</tr>
					</table>
				</div> -->
			
				 <div class="signIn_div" style="display:<?php echo $display_signin; ?>;">					
					<div class="signin_cont">
						<div class=" clr <?php if(isset($_GET['msg']) && $_GET['msg'] == 2 ) echo 'success_msg'; else echo 'error_msg'; ?>" style="display:<?php echo $display_signin; ?>;"><?php echo $err_msg; ?></div>
						<form id="signin_form" name="signin_form" method="post" action="#">
							<div class="clr">
								<label><input type="text" id="signInEmail" name="signInEmail" placeholder="EMAIL" class="inputbox" value="<?php if(isset($_POST['signInEmail']) && $_POST['signInEmail']!=''){ echo $_POST['signInEmail'];}?>" ></label>
								<div id="signInEmail_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<label><input type="password" id="SignInPassword" name="SignInPassword" maxlength="30" placeholder="PASSWORD" class="inputbox" ></label>
								<div id="SignInPassword_msg" class="error_msg" ></div>
							</div>
							<div class="clr">
								<a href="javascript:void(0);" title="Forgot password" onclick="showForget('forgotpass');">Forgot password?</a>
								<input type="hidden" id="errFlag" name="errFlag" class="errorFlag" value="0">
								<input type="submit" class="submit" name="signin_submit" value="SIGN IN" />
							</div>
						</form>
					</div>
				</div>
				
				<div class="forgotpass" style="display:<?php echo $display_forget; ?>;">					
					<div class="signin_cont">
						<div id="forget_error" class="clr error_msg" style="display:<?php echo $display_forget; ?>;"><?php echo $err_msg; ?></div>
						<form id="forgot_form" name="forgot_form" method="post" action="#">			
							<div class="clr">
								<label><input type="text" id="forgotEmail" name="forgotEmail" placeholder="EMAIL" class="inputbox" ></label>
								<div id="forgotEmail_msg" class="error_msg" ></div>
							</div>								
							<div class="clr">
								<a href="javascript:void(0);" title="Back" name="forget_back" onclick="forgetback();"  style="line-height: 23px;margin-left:10px">Back</a>
								<input type="hidden" id="errFlag_forgot" name="errFlag_forgot" class="errorFlag" value="0">
								<input type="button" class="submit" name="forget_submit" value="SUBMIT" onclick="return forgotPassword();"/>
							</div>
						</form>
					</div>
				</div>
				
				<div class="clearh"></div>
			<?php } /* if($loginFailsControllerObj->isIpBlocked($client_ip)) */ ?>
			</div>
			
			
		</div>			
	</div>
	<!-- Content : End -->		
	<div class="clearh"></div>
</div>
<?php siteFooter(); // call siteFooter from template ?>
</div>
