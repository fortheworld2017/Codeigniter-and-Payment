<?php 
function adminHeaderInclude($field_focus='') { 
	$menu_management_array = array(
								'Settings'	=> array(
													'Account Settings' 	=> array('change_password.php'),
													'SEO Settings' 		=> array('seo_settings.php')
													),
								'Users'		=> array(
													 'Add User'			=> array('edit_user.php?add=1'),
													 'User List'		=> array('user_listing.php','view_user.php','edit_user.php?edit=1'),
													 'Blocked IPs'	=> array('blocked_ips_listing.php')
													),
								'Cards'		=> array(
													 'Card List'		=> array('card_listing.php','view_card.php','edit_card.php'),
													 'Card Attempts'	=> array('card_attempts_listing.php')
													),
								'Domain'	=> array(
													 'Add Domain'		=> array('add_domain.php'),
													 'Domain List'		=> array('domain_listing.php'),
													 'Assign Domain'	=> array('assign_domain.php'),
													),
								'CMS'		=> array(
													 'Tour'				=> array('staticpage.php?id=1','staticpage_edit.php?id=2'),
													 'Pricing'			=> array('staticpage.php?id=2','staticpage_edit.php?id=3'),
													 'FAQ'				=> array('staticpage.php?id=3','staticpage_edit.php?id=3')
													)
								  );
	$page   = getCurrPage(); 
	//'News'				=> array('list_news.php','view_news.php','news.php')
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" lang="en-US">
<head>
	<title><?php echo SITE_TITLE;?></title>
	<link rel="STYLESHEET" type="text/css" href="<?php echo ADMIN_STYLE_PATH;?>style.css">
	<link href="<?php echo STYLE_PATH;?>jquery.ui.autocomplete.css" rel="stylesheet" type="text/css">
	<script src="<?php echo SCRIPT_PATH; ?>Jquery/jquery-1.7.min.js" type="text/javascript"></script>
	<script src="<?php echo SCRIPT_PATH; ?>jquery.ui.all.js"></script>
</head>
<body class="body_bg" >
	<table cellpadding="0" cellspacing="10" border="0" align="center"  width="100%" bgcolor="#fff" height="100%">
		<tr>
			<td valign="top" colspan="3">
				<div class="logo"><img src="<?php echo ADMIN_IMAGE_PATH; ?>logo.png" width="89" height="28" alt="" /></div>
				<div class="welcome_admin">
					<div><span>Welcome</span>&nbsp;<?php if(isset($_SESSION['adminusername']) && $_SESSION['adminusername'] != '') echo $_SESSION['adminusername']; ?></div>
					<div><a href="logout.php" title="logout" class="head_logout">Logout</a><a href="logout.php" class="logout_img" title="logout">&nbsp;</a></div>
				</div>
			</td>
		</tr>
		<tr><td height="10" class="dived_strip" colspan="3">&nbsp;</td></tr>
		<tr>
			<td valign="top">
				<div class="left_nav_top"></div>
				<div class="leftnavbg">
				<?php $div_loop	  	=	1;
				  $select_div	=	"";
				  $select_menu	=	"";
				  foreach($menu_management_array as $menu_key => $menu_value){ //echo $menu_value."<br>======div_loop==============".$div_loop;?>
					<div class="leftnav_head">
						<a name="ManagePlus<?php echo $div_loop; ?>" id="ManagePlus<?php echo $div_loop; ?>" onclick="openDiv(<?php echo $div_loop; ?>, '<?php echo $menu_key; ?>');" title="<?php echo $menu_key; ?>">
							<img src="<?php echo ADMIN_IMAGE_PATH;?>arrow.png" width="16" height="16" alt="<?php echo $menu_key; ?>" align="absmiddle" />
							<span><?php echo $menu_key; ?></span>
						</a>
					</div>
					<div id="ManagePage<?php echo $div_loop; ?>" style="display:none;" class="leftnav_list">
						<ul>
							<?php $widget_key	=	1;
								foreach($menu_value as $sub_menu_key => $sub_menu_value){
									$link_page		 =  (isset($sub_menu_value[0]) && $sub_menu_value[0]!='') ? $sub_menu_value[0] : "#";
									if($menu_key == "CMS" )
									{
										if($link_page == 'list_news.php')
											$link_page .="?cs=1";
										else
											$link_page .="&cs=1";
									} 
									if($menu_key == "Users"){
										if($link_page == 'user_listing.php')
											$link_page .="?cs=1";
									}
									if($menu_key == "Cards"){
										if($link_page == 'card_listing.php')
											$link_page .="?cs=1";
									}
									$sub_menu_class	 	= 	"";
									$temp_page			=   "";
									 if($sub_menu_key == 'Tour' && $page == 'staticpage.php' && (isset($_GET['id']) && $_GET['id'] == 1))
										$temp_page = $page.'?id=1';
									else if($sub_menu_key == 'Pricing' && $page == 'staticpage.php' && (isset($_GET['id']) && $_GET['id'] == 2))
										$temp_page = $page.'?id=2';
									else if($sub_menu_key == 'FAQ' && $page == 'staticpage.php' && (isset($_GET['id']) && $_GET['id'] == 3))
										$temp_page = $page.'?id=3';
									/*else if($sub_menu_key == 'Tour' && $page == 'staticpage.php' && (isset($_GET['id']) && $_GET['id'] == 1))
										$temp_page = $page.'?id=1';*/
									else if($sub_menu_key == 'FAQ' && $page == 'staticpage_edit.php' && (isset($_GET['id']) && $_GET['id'] == 3))
										$temp_page = $page.'?id=3';
									else if($sub_menu_key == 'Add User' && $page == 'edit_user.php' && (isset($_GET['add']) && $_GET['add'] == 1))
										$temp_page = $page.'?add=1';
									else if($sub_menu_key == 'User List' && $page == 'edit_user.php' && (isset($_GET['edit']) && $_GET['edit'] == 1))
										$temp_page = $page.'?edit=1';
									else
										$temp_page = $page;
									if(is_array($sub_menu_value) && in_array($temp_page,$sub_menu_value)){
										$sub_menu_class	=   "select";
										$select_div		=	$div_loop;
										$select_menu	=	$menu_key;
									} ?>
								<li><a href="<?php echo $link_page; ?>" title="<?php echo $sub_menu_key; ?>" class="<?php echo $sub_menu_class; ?>"><?php echo $sub_menu_key; ?></a></li>													
							<?php } ?>
						</ul>
					</div>
				<?php $div_loop++; } ?>	
				</div>
				<div class="left_nav_btm"></div>
			</td>
			<td width="84%" valign="top">
			<div class="right_side">
<?php ?>
<script type="text/javascript"> 
	<?php if ($select_div != '' && $select_menu != '') {  ?>
		openDiv(<?php echo $select_div; ?>, '<?php echo $select_menu; ?>');
	<?php	  } ?>
	function openDiv(divId, val)
	{
		var	ManagePlus = "ManagePlus" + divId; 
		var	ManagePage = "ManagePage" + divId; 
		if(document.getElementById(ManagePage).style.display == 'none')
		{
			document.getElementById(ManagePlus).innerHTML 		= '<img src="<?php echo ADMIN_IMAGE_PATH;?>downarrow.png" width="16" height="16" alt=""  align="absmiddle" /><span>'+val+'</span> ';
			document.getElementById(ManagePage).style.display 	= 'block';
			$("#"+ManagePlus).removeClass('menu_font');
			$("#"+ManagePlus).addClass('menu_font_sel');
		}
		else
		{
			document.getElementById(ManagePlus).innerHTML 		= '<img src="<?php echo ADMIN_IMAGE_PATH;?>arrow.png" width="16" height="16" alt="" align="absmiddle"  /><span>'+val+'</span> ';
			document.getElementById(ManagePage).style.display 	= 'none';
			$("#"+ManagePlus).removeClass('menu_font_sel'); 
			$("#"+ManagePlus).addClass('menu_font'); 		
		}
	}
</script>

<?php } function adminFooterInclude(){
	//global $js; ?>
<!-- Footer -->
			</div>
		</td></tr>
		<tr><td height="50"></td></tr>
	</table>
</body>	
	<script src="<?php echo SCRIPT_PATH; ?>util.js" type="text/javascript"></script>
	<script src="<?php echo SCRIPT_PATH; ?>util.js" type="text/javascript"></script>
	<!-- <script type="text/javascript" src="<?php echo SCRIPT_PATH;?>jquery.ui.autocomplete.js"></script> -->
	<script src="<?php echo ADMIN_SCRIPT_PATH; ?>validate.js" type="text/javascript"></script>
	<script src="<?php echo SCRIPT_PATH; ?>ajax_actions.js" type="text/javascript"></script>
	<!-- <script src="<?php //echo SCRIPT_PATH; ?>plugin.js"></script> --><!-- This js has isotope,anythingslider,datepicker -->
	<?php //create_entries($js, "\n", '<script src="'.ADMIN_SCRIPT_PATH, '" type="text/javascript"></script>'); ?>	
</html>
<!-- Footer -->
<?php } ?>

