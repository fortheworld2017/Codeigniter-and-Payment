<?php
ob_start();
	if (!session_id()) session_start();

function siteHeader() {
	
	$seosettings_content 	= seoSettingsFileRead();
	$explode_seo_settings  	= explode('*#*',$seosettings_content);
	$site_title 		  	= '';
	$keywords 				= '';
	$description			= '';
	if(count($explode_seo_settings) > 0) {
		$site_title 		= 	unEscapeSpecialCharacters($explode_seo_settings[0]);
		$keywords 			= 	unEscapeSpecialCharacters($explode_seo_settings[1]);
		$description 		= 	unEscapeSpecialCharacters($explode_seo_settings[2]);
	} 
?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
	    <meta charset="UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<!-- <meta name="viewport" content="width=device-width, user-scalable=0"> -->
		<meta name="keywords" content="<?php echo htmlentities($keywords); ?>">
		<meta name="description" content="<?php echo htmlentities($description); ?>">
		<title><?php echo htmlentities($site_title); ?></title>
		<!-- main css -->
		<link rel="shortcut icon" href="<?php echo IMAGE_PATH; ?>favicon.ico" type="image/x-icon" /> 
		<link href="<?php echo STYLE_PATH;?>style.css" rel="stylesheet" type="text/css">
		<link href="<?php echo STYLE_PATH;?>jquery.ui.autocomplete.css" rel="stylesheet" type="text/css">		
		<?php if (isset($_GET['page']) && ($_GET['page']== "monitor"|| $_GET['page'] == 'monitor_sitevisit')) { ?>
			<link type="text/css" href="<?php echo STYLE_PATH; ?>jquery.mCustomScrollbar.css" rel="stylesheet" />
		<?php } ?>
		<?php   if(isset($_GET['page']) && ($_GET['page'] == 'monitor' || $_GET['page'] == 'monitor_datepic')) {    ?>
			<link href="<?php echo STYLE_PATH;?>ui.daterangepicker.css" rel="stylesheet" type="text/css">
			<link href="<?php echo STYLE_PATH;?>jquery-ui-1.7.1.custom.css" rel="stylesheet" type="text/css">
		<?php  }  ?>
		<link href="<?php echo STYLE_PATH;?>jquery.ui.datepicker.css" rel="stylesheet" type="text/css">		
	</head>
	<body class="body demos  <?php if (!isset($_SESSION['tac_data']['user_id'])){ ?>home_bg<?php } ?>">
		<div id="loader" style="display:none;">
			<div class="loading_outer loading_tkbox" id="" style="display:block"></div>
			<div class="loading_inner loading_tkbox" id="" style="display:block;">
				<img style="padding-top:10px" src="<?php echo IMAGE_BUTTON_PATH; ?>loading.gif"/> 
			</div>	
		</div>
	<div class="Wrapper">
		<!-- Header : Start -->
		<div class="Header <?php if (!isset($_SESSION['tac_data']['user_id'])){ ?>headerhome<?php } ?>">	
			<table cellpadding="0" cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="20%"><?php  if(isset($_GET['page']) && $_GET['page']!='viewInvoice'){  ?><a href="home" title="Tactify" class="logo"><img src="<?php echo IMAGE_PATH; ?>logo.png" width="89" height="28" alt=""></a><?php  }  ?></td><!--  -->
					<?php if(!isset($_SESSION['tac_data']['user_id'])){ ?>
					<td width="40%" align="center" >
						<ul class="landtop_nav">
							<li><a href="tour" title="TOUR">TOUR</a></li>
							<li><a href="pricing" title="PRICING">PRICING</a></li>
							<li><a href="faq" title="FAQ">FAQ</a></li>
							<li><a href="javascript:void(0);" title="BLOG">BLOG</a></li>
						</ul>
					</td>
					<td width="25%" align="center" class="head_right">
						<a href="http://www.twitter.com/tactify" target="_blank" title="Twitter"><img src="<?php echo IMAGE_PATH; ?>twitter_icon.png" width="25" height="24" alt=""></a>
						<a href="http://www.facebook.com/Tactify" target="_blank" title="Facebook"><img src="<?php echo IMAGE_PATH; ?>fb_icon.png" width="25" height="24" alt=""></a>&nbsp;&nbsp;
						<?php $sign_up = '';
							if (isset($_GET['page']) && $_GET['page']== "home"){
								$sign_up = '#signup_div';
							}?>
						<!-- <a id="signup" href="signup<?php //echo $sign_up;?>" title="SIGN UP" class="yellow_but">SIGN UP</a>&nbsp;&nbsp; -->
						<a id="login" href="login<?php //echo $sign_up;?>" title="LOG IN" class="yellow_but">LOG IN</a>&nbsp;&nbsp;
					</td>
					<?php } else { 
							if(isset($_GET['page']) && $_GET['page'] != 'viewOrder'){ ?>
								<!-- <td align="right" class="logout">
									Welcome <?php echo $_SESSION['tac_data']['user_name'];?>,
									<a href="javascript:void(0);" title="Logout" onclick="location.href='logout'">Logout</a>
								</td> -->
					<?php 	} } ?>
				</tr>
			</table>
		</div>
		<!-- Header : Start -->
<?php } //siteheader end 

function siteFooter() { ?>
	<div class="Footer">
		<div class="right"><img src="<?php echo IMAGE_PATH; ?>foot_txt.jpg" width="71" height="28" alt=""></div>
	</div>

	<script src="<?php echo SCRIPT_PATH; ?>Jquery/jquery-1.7.min.js" type="text/javascript"></script>
	<script src="<?php echo SCRIPT_PATH; ?>jquery.ui.all.js"></script>
	<!--[if IE]> <script src="<?php echo SCRIPT_PATH; ?>jquery.placeholder.min.js"></script> 	
		<script>
		   $(function() {
    		$('input, textarea').placeholder();
		   });
		</script>
		<style>
			#scrollbar2 { width: 150px \0/IE9;}
			#scrollbar2 .viewport { width: 140px;}
		</style>
	<![endif]-->
	<script src="<?php echo SCRIPT_PATH; ?>util.js"></script>
	<script src="<?php echo SCRIPT_PATH; ?>validate.js"></script>
	<script src="<?php echo SCRIPT_PATH; ?>ajax_actions.js"></script>	
	<?php if(isset($_GET['page']) && ($_GET['page'] == 'cardTemplate') ) { ?>
		<script src="<?php echo SCRIPT_PATH; ?>color_picker.js"></script>
	<?php } if(isset($_GET['page']) && (($_GET['page'] == 'monitor') || ($_GET['page'] == 'monitor_page' || $_GET['page'] == 'monitor_datepic'))) {  ?>
		<script type="text/javascript" src="<?php echo SCRIPT_PATH;?>Jquery/jquery-ui-1.8.21.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo SCRIPT_PATH;?>barChart.js"></script>
		<script type="text/javascript" src="<?php echo SCRIPT_PATH;?>pieChart.js"></script>
		<script type="text/javascript" src="<?php echo SCRIPT_PATH;?>jquery.mCustomScrollbar.js"></script>
		<script type="text/javascript" src="<?php echo SCRIPT_PATH;?>jquery.mousewheel.min.js"></script>
		<script type="text/javascript" src="<?php echo SCRIPT_PATH;?>daterangepicker.jQuery.js"></script>
	<?php  }  ?>
	<?php if((isset($_GET['echo']) && $_GET['echo']==1 )  ) {
	 	global $GLOBAL_REQUESTS_QUERIES;
	 	 echo "<pre>"; print_r($GLOBAL_REQUESTS_QUERIES);echo "</pre>";
 	} ?>
	</body>
	</html>
<?php } //site footer end 
function leftNav($totalOrder='') {
	$account_path	=	SITE_PATH.'accountInformation';
	$create_path	=	SITE_PATH.'homepage';
	$order_path		=	'javascript:void(0);';
	$edit_path		=	'javascript:void(0);';
	$monitor_path	=	'javascript:void(0);';
	$create_sel = $order_sel = $edit_sel = $monitor_sel = $dashboard_sel = '';
	if(isset($_GET['page']) && ($_GET['page']=='createCard' || $_GET['page']=='homepage' || $_GET['page']=='cardTemplate'))
		$create_sel = '_sel';
	if(isset($_GET['page']) && $_GET['page']=='order')
		$order_sel = '_sel';
	if(isset($_GET['page']) && $_GET['page']=='editCard')
		$edit_sel = '_sel';
	if(isset($_GET['page']) && $_GET['page']=='monitor')
		$monitor_sel = '_sel';
	if(isset($_GET['page']) && $_GET['page']=='accountInformation')
		$account_sel = '_sel sel';
	if(isset($_GET['page']) && $_GET['page']=='dashboard')
		$dashboard_sel = '_sel';
?>
		<ul class="nav">
			<li><a class="dashboard<?php echo $dashboard_sel;  ?>" href="dashboard" title="DASHBOARD">DASHBOARD</a></li>
			<li><a href="<?php echo $account_path;  ?>" title="ACCOUNT" class="acount acount<?php echo $account_sel; ?>">ACCOUNT</a></li>
			<li><a href="<?php echo $create_path; ?>" title="CREATE"  class="create<?php echo $create_sel; ?>">CREATE</a></li>
			<li><a href="<?php echo $order_path; ?>" title="ORDER" class="order<?php echo $order_sel; ?>">ORDER</a></li>
			<li><a href="<?php echo $edit_path; ?>" title="EDIT" class="edit<?php echo $edit_sel; ?>">EDIT</a></li>
			<li><a href="<?php echo $monitor_path; ?>" title="MONITOR" class="monitor<?php echo $monitor_sel; ?>">MONITOR</a></li>
		</ul>
<?php } 
function breadCrumb() { ?>
	<div class="breadcrum">
		<div class="">
			<table cellpadding="0" cellspacing="0" border="0" align="center" height="40" width="100%">
				<tr>
					<?php  if(isset($_GET['page']) && $_GET['page']=='accountInformation')  {  ?>
						<td align="left" style="text-align:left;padding-left:50px;" id="edit_headtitle" class="headtitle">ACCOUNT</td>	
					<?php } else if(isset($_GET['page']) && $_GET['page']=='editCard')  {?>
						<td align="left" style="text-align:left;padding-left:50px;" id="edit_headtitle" class="headtitle">EDIT > CAMPAIGN</td>
					<?php } else if(isset($_GET['page']) && $_GET['page']=='dashboard')  {?>
						<td align="left" style="text-align:left;padding-left:35px;" id="edit_headtitle" class="headtitle">DASHBOARD
							<!-- <span class="dashboard_tit"></span> -->
							<!-- <div class="relative fleft">
								<input type="text" class="search_txt" />
								<span class="search_but" title="SEARCH"></span>
							</div> -->
						</td>
					<?php } else if(isset($_GET['page']) && ($_GET['page']=='homepage' || $_GET['page']=='cardTemplate' || $_GET['page']=='createCard') )  {?>
						<td class="headtitle" style="padding-top:8px !important;">CREATE</td>
						<td>
							<div class="greymenu"><ul class="greymid">fgdfgdfg</ul></div>
						</td>
						<td align="right" style="font-size:14px;font-weight:bold;" class="logout" valign="top">
							Welcome <?php echo $_SESSION['tac_data']['user_name'];?>,
							<a style="color:blue;margin-left:10px;margin-right:10px;" href="javascript:void(0);" title="Logout" onclick="location.href='logout'">Logout</a>
						</td>
					<?php } ?>
						<td align="right" style="font-size:14px;font-weight:bold;" class="logout" valign="top">
							Welcome <?php echo $_SESSION['tac_data']['user_name'];?>,
							<a style="color:blue;margin-left:10px;margin-right:10px;" href="javascript:void(0);" title="Logout" onclick="location.href='logout'">Logout</a>
						</td>
					</tr>
			</table>
		</div>
	</div>
<?php } 
function breadCrumbV2()
{
?>
	<div class="breadcrum">
		<div class="">
			<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
				<tr>
					<td valign="top" class="headtitle" style="padding-top: 8px !important;">CREATE</td>
					<td valign="top">	 				
						<div class="greymenu">
						<?php if(isset($_GET['page']) && $_GET['page'] != 'homepage')  {?>
							<div class="leftcorner"></div>
							<ul class="greymid">
							
								<li><a href="javascript:void(0);" class="sel" title="TEMPLATE">TEMPLATE</a></li>
								<li><a href="javascript:void(0);" class="sel" title="CONTENT">CONTENT</a></li>
								<li><a href="javascript:void(0);" class="sel" title="DESIGN">DESIGN</a></li>
								<li class="stripnone"><a href="javascript:void(0);" class="sel" title="FINALISE">FINALISE</a></li>							
							</ul>
							<div class="rightcorner"> </div>
							<?php } ?>
						</div>						
					</td>
					<td align="right" style="font-size:14px;font-weight:bold;" class="logout" valign="top">
						Welcome <?php echo $_SESSION['tac_data']['user_name'];?>,
						<a style="color:blue;margin-left:10px;margin-right:10px;" href="javascript:void(0);" title="Logout" onclick="location.href='logout'">Logout</a>
					</td>
				</tr>
				
			</table>
		</div>
	</div>
<?php
}
function subNav($type)
{
?>
	<div class="subnav" >
		<div class="cardmenu" style="display: block">
			<ul>
				<li title="BUSINESS CARD" onclick="window.location.href ='cardTemplate?ct=1';"><a href="javascript:void(0);" title="BUSINESS CARD" class="busines_card<?php if($type == 1) { echo '_sel sel'; }?>">BUSINESS CARD</a></li>
				<li title="STICKERS" onclick="window.location.href ='cardTemplate?ct=2';"><a href="javascript:void(0);" title="STICKERS" class="stickers<?php if($type == 2) { echo '_sel sel'; }?>">STICKERS</a></li>
				<li title="CAMPAIGN" onclick="window.location.href ='cardTemplate?ct=3';"><a href="javascript:void(0);" title="CAMPAIGN" class="campaign<?php if($type == 3) { echo '_sel sel'; }?>">CAMPAIGN</a></li>
				<li title="PROMOTION" onclick="window.location.href ='cardTemplate?ct=4';"><a href="javascript:void(0);" title="PROMOTION" class="promotion<?php if($type == 4) { echo '_sel sel'; }?>">PROMOTION</a></li>
				<li title="EVENT" onclick="window.location.href ='cardTemplate?ct=5';"><a href="javascript:void(0);" title="EVENT" class="events<?php if($type == 5) { echo '_sel sel'; }?>">EVENT</a></li>
			</ul>
		</div>				
		<div class="clearh"></div>
	</div>
<?php } ?>
