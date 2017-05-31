<?php ob_start();
	if (!session_id()) session_start();
	if(isset($_SESSION['tac_data']['user_id'])){
		header("Location:homepage");
		die();
	}
	require_once('Includes/CommonIncludes.php');
	require_once('Controllers/UserController.php');
	$userControllerObj 	= 	new UserController();
	$err_msg = '';
	$post_value	= array(
					   'fullname'			=> '',
					   'email'		  		=> ''
					   );
	
	checkTestLoginScreenUser();
	
	siteHeader();
	unset($_SESSION['ses_home_fullname']);
	unset($_SESSION['ses_home_email']);
	unset($_SESSION['ses_home_password']);
	if(isset($_POST['fullname']) && $_POST['fullname']!= '')
	{
		foreach($_POST as $key => $value)
		{
			$post_value[$key]	=	$value;
		}
		if(isset($_POST['email']) && $_POST['email']!=''){
			$userEmailexist	= $userControllerObj->checkUserNameExist($_POST['email']);
			if(isset($userEmailexist) && is_array($userEmailexist) && count($userEmailexist) > 0) {
				$err_msg = '* Email already exist';
			}
		}
		if($err_msg == '')
		{
			$_SESSION['ses_home_fullname']	= $_POST['fullname'];
			$_SESSION['ses_home_email']		= $_POST['email'];
			$_SESSION['ses_home_password']	= $_POST['password'];
			header('Location:signup');
			die();
		}
	}
?>		
		<!-- Content : Start -->
	<div class="Bodycontent">
		<div class="Landing landingn">
			<div class="home">
				<div class="banner relative">		
					<div class="youtube_bg">
						<iframe width="370" height="260" frameborder="0" allowfullscreen="" src="<?php echo LANDING_VIDEO; ?>"></iframe>
					</div>
					<form id="homeSignup" name="homeSignup" action="" method="post">
						<div class="home_signup">
							<p>
								<label>FULL NAME</label>
								<span><input id="fullname" name="fullname" type="text" value="<?php echo $post_value['fullname']; ?>" class="inputbox"></span>
							</p>
							<div id="fullname_msg" class="error_msg" ></div>
							<p>
								<label>EMAIL</label>
								<span><input id="email" name="email" type="text" value="<?php echo $post_value['email']; ?>" class="inputbox"></span>
							</p>
							<div id="email_msg" class="error_msg" ><?php echo $err_msg; ?></div>
							<p>
								<label>PASSWORD</label>
								<span><input id="password" name="password" type="password" value=""  class="inputbox"></span>
							</p>
							<div id="password_msg" class="error_msg" ></div>
							<p>
								<input type="hidden" id="errorFlag" name="errorFlag" value="0">
								<input type="submit" value="SIGN UP" class="yellowbut" onclick="return homeSignupValidate();" />
							</p>
						</div>
					</form>
				</div>
				<div class="yellowbg">&nbsp;</div>
				<div class="home_bottom">
					<img src="WebResources/Images/common/home_botbg.png" width="900" height="175" alt="">
				</div>
			</div>
		</div>			
	</div>
	<!-- Content : End -->		
	<div class="clearh"></div>
</div>
<?php siteFooter(); // call siteFooter from template ?>
</div>
