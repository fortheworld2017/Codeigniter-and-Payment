<?php ob_start(); 
	if (!session_id()) session_start();
 	if(isset($_SESSION['adminid']) && $_SESSION['adminid'] != '')
		header("location:change_password.php");
	require("../Includes/AdminCommonIncludes.php");
	require("../Controllers/AdminController.php");
	$admincontrollerobj = new AdminController();
	
	/* Verify if IP address is blocked */
	require_once('../Controllers/CardAttemptsController.php');
	$cardAttemptsControllerObj = new CardAttemptsController();
	require_once('../Controllers/LoginFailsController.php');
	$loginFailsControllerObj = new LoginFailsController();
	
	$client_ip = getClientIP();
	$this_page = 'manage';
	
	if($cardAttemptsControllerObj->isIpBlocked($client_ip, true))
	{
		header('location:http://'.PRIMARY_DOMAIN.'/error');
		die();
	}
	
	if(isset($_POST['login_submit']) && $_POST['login_submit'] !='')
	{
		$checkuser = $admincontrollerobj->checklogin($_POST);
		$checkuser_array	= (array)$checkuser[0];
		$checkuser_array 	= unEscapeSpecialCharacters($checkuser_array);
		/* if($_SERVER['REMOTE_ADDR'] == '172.21.4.195'){
			echo'<pre>post';print_r($_POST);echo'</pre>';	
			echo'<pre>CHECUSER_ARRAY';print_r($checkuser_array);echo'</pre>';	
		} */ 
		if(isset($checkuser_array) && is_array($checkuser_array) && count($checkuser_array)>0) 
		{
			$_SESSION['adminid'] 		= 	$checkuser_array['id'];
			$_SESSION['adminusername'] 	= 	$checkuser_array['username'];
			$_SESSION['adminpassword'] 	= 	$_POST['password'];
			$_SESSION['emailAddress'] 	= 	$checkuser_array['emailAddress'];
			header("Location:change_password.php?cs=1");
			die();
		}
		else
		{
			$error_message = "Invalid Username or Password";
			
			/* Updates failedLogins */
			$loginFailsControllerObj->insertLoginFail($client_ip,$_POST['username'],$this_page);
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><?php echo SITE_TITLE;?></title>
	<link rel="STYLESHEET" type="text/css" href="<?php echo ADMIN_STYLE_PATH;?>style.css">
</head>
<body class="body_bg" onload="fieldfocus('username')" align="center">
	<div class="panel" >				
		<div class="login_logo">				
		<?php if($loginFailsControllerObj->isIpBlocked($client_ip)) { ?>
			<div class="login_form">
				<?php $remaining_delay = $loginFailsControllerObj->getRemainingDelay($client_ip); ?>
				<img src="<?php echo ADMIN_IMAGE_PATH; ?>logo.png" width="89" height="28" alt="" />
				
				<p>
					<?php echo "You must wait ".$remaining_delay." before your next login attempt. " ?>
				</p>
			</div>
		<?php } else { /* if($loginFailsControllerObj->isIpBlocked($client_ip)) */ ?>
		
			<img src="<?php echo ADMIN_IMAGE_PATH; ?>logo.png" width="89" height="28" alt="" />
			<form name="loginform" id="loginform" action="" method="post" >
			<div class="login_form">
				<?php if(isset($error_message) &&  $error_message != '' ) { ?>
				<div id="validate_msg_container"><div id="validate_msg" class="error_msg"><span><?php echo $error_message; ?></span></div></div><br>
				<?php } ?>
				
				<div class="login_field">
					<label>Username</label>
					<input type="text" name="username" id="username" tabindex="1" value="" class="text_box" />
				</div>
				<div class="error_height"><div id="username_msg_container"><div id="username_msg" class="error_msg"></div></div></div>
				<div class="login_field">
					<label>Password</label>
					<input type="password" name="password" id="password" tabindex="2" value="" class="text_box" />
				</div>
				<div class="error_height"><div id="password_msg_container"><div id="password_msg" class="error_msg"></div></div></div>
				<div style="padding-bottom: 20px;">
					<input type="hidden" id="errorFlag" name="errorFlag" value="0" />
					<input type="submit" value="Login" alt="Login" title="Login" class="button" name="login_submit" id="login_submit" tabindex="3" />
				</div>
			</div>
			</form> 
		<?php } /* if($loginFailsControllerObj->isIpBlocked($client_ip)) */ ?>
		</div>
	</div>
</body>
<script src="<?php echo SCRIPT_PATH;?>Jquery/jquery-1.7.min.js" type="text/javascript"></script>
<script src="<?php echo SCRIPT_PATH;?>util.js" type="text/javascript"></script>
<script src="<?php echo ADMIN_SCRIPT_PATH;?>validate.js" type="text/javascript"></script>
</html>
