<?php  require_once('Includes/CommonIncludes.php');
?>

<?php
if (!session_id())
		session_start();
	session_destroy();
	
	/*require 'Views/facebook_sdk/src/facebook.php';
	$facebook = new Facebook(array(
	  'appId'  => FB_APP_ID,
	  'secret' => FB_SECRET_KEY,
	));
	$user = $facebook->getUser();
	// Login or logout url will be needed depending on current user state.
	if($user)
	{
	  $logoutUrl = $facebook->getLogoutUrl();
	  
	  //$logoutUrl = str_replace('logout&','&',$logoutUrl);
	 
	 header("Location:".$logoutUrl);
	  //header("Location:/kikit/");
	  
	}
	else
	{
	 header("Location:".REDIRECT_PATH);
	}*/
	
	//setcookie('ck_keepme_login',"",time()-3600);
	setcookie('ck_login_email',"",time()-3600);
	 ?>
	 <script src="<?php echo SCRIPT_PATH; ?>Jquery/jquery-1.7.min.js" type="text/javascript"></script>
<div id="fb-root"></div>
<script type="text/javascript">
    var myapp_id = '<?php echo FB_APP_ID; ?>';
	$(window).load(function() {
		facebookLogout(myapp_id);
	});
function facebookLogout(myapp_id) {
	window.fbAsyncInit = function () {
      	FB.init({
            appId: myapp_id,
            status: true,
            cookie: true,
            xfbml: true,
            oauth: true
        });
		FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				myaccess_token_post = response.authResponse.accessToken;
				 FB.logout(function(response) {
					location.href = '<?php echo SITE_PATH ?>';
				 });
			}
			else {
				location.href = '<?php echo SITE_PATH ?>';
			}
		});
    };
    (function () {
		var e = document.createElement('script');
        e.async = true;
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
    }());
	
}
 </script>
<?php header("Location:".REDIRECT_PATH); ?>	
