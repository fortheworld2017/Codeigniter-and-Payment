<?php error_reporting(0);
//require_once('../Includes/AjaxCommonIncludes.php');
require_once('../Includes/CommonFunctions.php');
require_once('../Models/Config/cfg.constants.php');
session_start();
if(isset($_SESSION['user_data']['user_id'])){ 
	unset($_SESSION['signup_page']);
}
if(isset($_SESSION['signup_page'])){
}
else {
	if(isset($_SESSION['user_data']['user_id'])){ }
	else
	{ ?>
	<script type="text/javascript">
		window.location.href='<?php echo SITE_PATH; ?>';
	</script>
	<?php }
}
if(isset($_GET['action']) && $_GET['action'] == 'insert_user')
{
	
}
?>