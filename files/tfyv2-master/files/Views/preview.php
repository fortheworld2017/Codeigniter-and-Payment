<?php
	/*if(isset($_SESSION['create_page'])){ } else {
		header("Location:home");
	}*/
	if(!isset($_SESSION['tac_data']['user_id'])  &&  (!isset($_SESSION['adminid'])) )
		header("Location:home");
	/*	variable declration - begins*/
	//echo '<pre>'; print_r($_GET); echo '</pre>';
	$span_class			=	'prev_left';
	$logo_image			=	'';
	$logo_display		=	'display:none;';
	$profile_display	=	'display:none;';
	$banner_display		=	'display:none;';
	$h2_display			=	'display:none;';
	$h3_display			=	'display:none;';
	$tile_display		=	'display:block;';
	$row_display		=	'display:none;';
	$row_class			=	'metal';
	$logo_site_path		=	'';
	$profile_site_path	=	'';
	$banner_site_path	=	'';
	$condition			=	'';
	$click				=	'0';
	$shortUrl			=	'';
	$cardid				=	'';
	$userid				=	'';
	$cardType			=	0;
	$layout				=	'';
	$folderpath			=	IMAGE_FOLDER_PATH_SITE.'tileicon/metal/';
	$card_values	= array(
					   'id'							=> '',
					   'name'						=> '',
					   'title'						=> '',
					   'logoName'					=> '',
					   'profileName'				=> '',
					   'buttonFormat'	  			=> '',
					   'buttonStyle'	  			=> '',
					   'groupName'					=> '',
					   'cardOption'					=> '',
					   'groupNameCheck'				=> 0,
					   'facebookSelected'  			=> 0,
					   'twitterSelected' 			=> 0,
					   'linkedinSelected'			=> 0,
					   'blogSelected' 				=> 0,
					   'tumblrSelected' 			=> 0,
					   'soundCloudSelected'			=> 0,
					   'youTubeSelected'  			=> 0,
					   'googlePlusSelected'			=> 0,
					   'spotifySelected'			=> 0,
					   'phoneNumberSelected'		=> 0,
					   'websiteSelected'			=> 0,
					   'emailSelected'				=> 0,
					   'smsSelected'				=> 0,
					   'skypeSelected'				=> 0,
					   'addContactSelected'			=> 0,
					   'addWeblinkSelected'			=> 0,
					   'addressSelected'			=> 0,
					   'viberSelected'				=> 0,
					   'promotionSelected'			=> 0,
					   'calenderSelected'			=> 0,
					   'customerServiceSelected'	=> 0,
					   'appStoreSelected'			=> 0,
					   'shareFilesSelected'			=> 0,
					   'requestMeetingSelected'		=> 0,
					   'ticketsSelected'			=> 0,
					   'playStoreSelected'			=> 0,
					   'selectedOptions'			=> '',
					   'cardColour'					=> '#CBCBCB',
					   'headerColour'				=> '#FFFFFF',
					   'phoneNumber'				=> '',
					   'website'					=> '',
					   'email'						=> '',
					   'sms'						=> '',
					   'skype'						=> '',
					   'addContact'					=> '',
					   'addWeblink'					=> '',
					   'address'					=> '',
					   'viber'						=> '',
					   'facebook'					=> '',
					   'twitter'					=> '',
					   'linkedin'					=> '',
					   'blog'						=> '',
					   'tumblr'						=> '',
					   'soundCloud'					=> '',
					   'youTube'					=> '',
					   'googlePlus'					=> '',
					   'spotify'					=> '',
					   'promotion'					=> '',
					   'calender'					=> '',
					   'customerService'			=> '',
					   'appStore'					=> '',
					   'shareFile'					=> '',
					   'requestMeeting'				=> '',
					   'tickets'					=> '',
					   'playStore'					=> '',
		 				);
	/*	variable declration - ends*/
	require_once('Includes/CommonFunctions.php');
	$layout = detectLayout();

	if( (isset($_GET['shorturl']) && $_GET['shorturl'] != '') || (isset($_GET['temp_id']) && $_GET['temp_id'] != ''))
	{
		require_once('Controllers/CardDetailsController.php');
		$cardDetailsControllerObj 	= 	new CardDetailsController();
		$curr_os	=	detectOs();
		if($curr_os == 'Windows') {
			$thumb = '';
			$browser = 1;
		}
		else if($curr_os == 'iOS') {
			$browser = 2;
		}
		else if($curr_os == 'Android') {
			$browser = 3;
		}
		
		$bindParams = array();
		if(isset($_GET['shorturl']) && $_GET['shorturl'] != '')
		{
			$condition	  = ' and cd.shortUrl = ? ';
			$bindParams[] = $_GET['shorturl'];
			$click		  = '1';
		}
		if(isset($_GET['temp_id']) && $_GET['temp_id'] != '')
		{
			$condition    = ' and ct.id = ? ';
			$bindParams[] = $_GET['temp_id'];
		}
		$fields			=	'ct.*, cd.*';
		$cardDetails	=	$cardDetailsControllerObj->getCardDetails($fields, $condition, '', $bindParams);
		//if($_SERVER['REMOTE_ADDR'] == '172.21.4.135') { echo "<pre>Line : ".__LINE__."<br>FILE : ".__FILE__."<br>"; print_r($cardDetails); echo "</pre>"; }
		if(isset($cardDetails) && count($cardDetails)>0 && is_array($cardDetails))
		{
			foreach($cardDetails[0] as $key => $value)
			{
				$card_values[$key]	=	$value;
			}
			$cardType		=	$card_values['cardType'];
			$shortUrl		=	$card_values['shortUrl'];
			$cardid			=	$card_values['id'];
			$userid			=	$card_values['fkUserId'];
			$h2_display		=	'display:block;';
			$h3_display		=	'display:block;';
			$button_format	=	$card_values['buttonFormat'];
			$button_style	=	$card_values['buttonStyle'];
			
			if($button_format == 1 && $button_style == 1)
				$folderpath	=	IMAGE_FOLDER_PATH_SITE.'tileicon/metal/';
			else if($button_format ==1 && $button_style == 2)
				$folderpath	=	IMAGE_FOLDER_PATH_SITE.'tileicon/rubber/';
			else if($button_format ==2 && $button_style == 1)
			{
				$row_class		=	'metal';
				$folderpath	=	IMAGE_FOLDER_PATH_SITE.'rowicon/metal/';
			}
			else if($button_format ==2 && $button_style == 2)
			{
				$row_class		=	'rubber';
				$folderpath	=	IMAGE_FOLDER_PATH_SITE.'rowicon/rubber/';
			}
			if($button_format == 2)
			{
				$tile_display	=	'display:none;';
				$row_display	=	'display:block;';
			}
			
			if(isset($card_values['logoName']) && $card_values['logoName'] != '') {
				$logo_image			=	$card_values['id'].'.'.$card_values['logoExt'];
				//$logo_Abspath	 	= 	ABS_IMAGE_PATH_LOGO.'thumb/'.$logo_image;
				$logo_Abspath	 	= 	ABS_IMAGE_PATH_LOGO.$logo_image;
				if(file_exists($logo_Abspath))
				{
					$span_class	= '';
					//$logo_site_path	 	= 	IMAGE_PATH_LOGO.'thumb/'.$logo_image;
					$logo_site_path	 	= 	IMAGE_PATH_LOGO.$logo_image;
					$logo_display		=	'display:inline;';
				}
			}
			if(isset($card_values['profileName']) && $card_values['profileName'] != '') {
				$profile_image		=	$card_values['id'].'.'.$card_values['profileExt'];
				$proflie_Abspath 	=	ABS_IMAGE_PATH_PROFILE.$profile_image;
				if(file_exists($proflie_Abspath))
				{
					$profile_site_path	 	= 	IMAGE_PATH_PROFILE.$profile_image;
					$profile_display		=	'display:block;';
				}
			}
			if(isset($card_values['bannerName']) && $card_values['bannerName'] != '') {
				$banner_image		=	$card_values['id'].'.'.$card_values['bannerExt'];
				$banner_Abspath 	=	ABS_IMAGE_PATH_BANNER.$banner_image;
				if(file_exists($banner_Abspath))
				{
					$span_class	= '';
					$banner_site_path	= 	IMAGE_PATH_BANNER.$banner_image;
					$banner_display		=	'display:block;';
				}
			}
		}
		/*else
			header("Location:homepage");*/
	}
	//echo '-----------'.$cardType;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!-- <meta name="viewport" content="initial-scale = 1.0" /> -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" /> 
	<meta name="author" content="Caps Creative" />
	<meta name="description" content="NFC contact Details" />
	<meta name="keywords" content="NFC, Business Cards, Online referdex" />
	<title><?php echo SITE_TITLE;?></title>
	<link rel="STYLESHEET" type="text/css" href="<?php echo STYLE_PATH;?>phone_prev.css">
	<script src="<?php echo SCRIPT_PATH; ?>Jquery/jquery-1.7.min.js" type="text/javascript"></script>	
	<?php if(isset($_GET['small']) && $_GET['small'] == 1) { ?>	
	<link rel="STYLESHEET" type="text/css" href="<?php echo STYLE_PATH;?>scroll_bar.css">
	<script src="<?php echo SCRIPT_PATH; ?>jquery.tinyscrollbar.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#scrollbar2').tinyscrollbar();			
		});
		function scrollbar() {
			$('#scrollbar2').tinyscrollbar_update();
		}
	</script>
	<?php } else if($layout == 'desktop') { ?>
		<link rel="STYLESHEET" type="text/css" href="<?php echo STYLE_PATH;?>desktop_prev.css">
	<?php } ?>
</head>
<body <?php if($layout != 'desktop') { ?> style="background-color: <?php echo $card_values['headerColour']; ?>" <?php } ?>>
<div class="wrapper" id="scrollbar2">
	<?php if(isset($_GET['small']) && $_GET['small'] == 1) {?>
	<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	<div class="viewport" id="setBgColor" style="background-color: <?php echo $card_values['headerColour']; ?>">
	<div class="overview">
	<?php } ?>
	<div class="outer_box">
	<!-- Header : Start  -->
	<?php if($cardType != 1) { ?>
	<div class="sticker_img" style="<?php if($layout == 'desktop') { ?>background-color: <?php echo $card_values['headerColour']; } ?>;<?php if(isset($_GET['temp_id']) && $_GET['temp_id'] != ''  ) { ?>min-height: 50px;<?php }  ?>"><img style="<?php echo $banner_display; ?> width:100%; " id="iframe_banner" src="<?php echo $banner_site_path; ?>" alt=""></div>
	<?php } ?>	
	
	<div class="header" style="<?php if($layout == 'desktop') { ?>background-color: <?php echo $card_values['headerColour']; } ?>;">
		<div class="header_top" style="<?php if(isset($_GET['temp_id']) && $_GET['temp_id'] != '' && !isset($_GET['small']) ) { ?>min-height:150px;<?php } ?> display:<?php if($cardType != 1 && $cardType != 0) echo 'none'; else echo 'block'; ?>">
			<div class="left">
				<div class="headtop" style="display:<?php if((isset($_GET['small']) && $_GET['small'] == 1) || (isset($_GET['card']) && $_GET['card'] != '') ) echo 'block'; else if($logo_site_path == '') echo 'none'; else echo 'block';?>;">
					<span id="iframe_span" class="<?php echo $span_class; ?>"><img style="<?php echo $logo_display; ?>" id="iframe_logo" src="<?php echo $logo_site_path;?>" width="100%" alt=""></span>	
				</div>			
			</div>
			<div class="right">
				<img style="<?php echo $profile_display; ?>" id="iframe_profile" src="<?php echo $profile_site_path; ?>" alt=""> 				
			</div>
			<div class="clearh"></div>
		</div>		
		<!-- 	 -->
		<div class="headbot_colr" <?php if($layout == 'desktop') { ?>style="background-color:#FFF;"<?php } ?> >
			<div class="headbot">
				<h2 id="iframe_name" style="<?php echo $h2_display; ?>"><span id="iframe_name"><?php echo $card_values['name']; ?></span></h2>
				<h3 style="<?php echo $h3_display; ?>" id="iframe_title"><?php echo $card_values['title']; ?></h3>
			</div>
		</div>		
	</div>	
	<!-- Container : Start -->
	<div class="container">
		<div class="bg">
			<div class="menu" style="background-color: <?php echo $card_values['cardColour']; ?>">
				<input type="Hidden" id="userId" name="userId" value="<?php echo $userid; ?>">
				<input type="Hidden" id="cardId" name="cardId" value="<?php echo $cardid; ?>">
				<input type="Hidden" id="shortUrl" name="shortUrl" value="<?php echo $shortUrl; ?>">
				<div id="tileicon" style="<?php echo $tile_display; ?>">
					<ul>
						<!-- Contact -->
						<li style="display:<?php if($card_values['phoneNumberSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="phoneNumberSelected_icon">
							<a target="_blank" href="<?php if($card_values['phoneNumber'] != '') echo 'tel:+'.$card_values['phoneNumber']; else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('phoneNumber');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>phone.png" border="0" alt="" title=""/>Phone</a>
						</li>
						<li style="display:<?php if($card_values['websiteSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="websiteSelected_icon">
							<a target="_blank" href="<?php if($card_values['website'] != '') echo addhttp($card_values['website']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('website');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>www.png" border="0" alt="" title=""/>Website</a>
						</li>
						<li style="display:<?php if($card_values['emailSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="emailSelected_icon">
							<a target="_blank" href="<?php if($card_values['email'] != '') echo 'mailto:'.$card_values['email']; else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('email');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>mail.png" border="0" alt="" title=""/>Email</a>
						</li>
						<li style="display:<?php if($card_values['smsSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="smsSelected_icon">
							<a target="_blank" href="<?php if($card_values['sms'] != '') echo 'sms:+'.$card_values['sms']; else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('sms');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>sms.png" border="0" alt="" title=""/>SMS</a>
						</li>
						<li style="display:<?php if($card_values['skypeSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="skypeSelected_icon">
							<a target="_blank" href="<?php if($card_values['skype'] != '') echo 'skype:'.$card_values['skype']; else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('skype');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>skype.png" border="0" alt="" title=""/>Skype</a>
						</li>
						<li style="display:<?php if($card_values['addContactSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="addContactSelected_icon">
							<a href="javascript:void(0);" <?php if($click == 1) {?> onclick="downloadVcf(<?php echo $browser; ?>,'<?php echo $card_values['name']; ?>'); clickTesting('addContact'); "<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>contact2.png" border="0" alt="" title=""/>Add contact</a>
						</li>
						<li style="display:<?php if($card_values['addWeblinkSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="addWeblinkSelected_icon">
							<a target="_blank" href="<?php if($card_values['addWeblink'] != '') echo addhttp($card_values['addWeblink']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('addWeblink');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>weblink.png" border="0" alt="" title=""/>Add weblink</a>
						</li>
						<li style="display:<?php if($card_values['addressSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="addressSelected_icon">
							<a target="_blank" href="<?php if($card_values['address'] != '') echo 'http://maps.google.com/maps?q='.$card_values['address']; else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('address');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>map.png" border="0" alt="" title=""/>Address</a>
						</li>
						<li style="display:<?php if($card_values['viberSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="viberSelected_icon">
							<a href="javascript:void(0);" <?php if($click == 1) {?> onclick="clickTesting('viber');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>viber.png" border="0" alt="" title=""/>Viber</a>
						</li>
						<!-- Social -->
						<li style="display:<?php if($card_values['facebookSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="facebookSelected_icon">
							<a target="_blank" href="<?php if($card_values['facebook'] != '') echo addhttp($card_values['facebook']); else echo 'javascript:void(0);';?>" <?php if($click == 1) {?> onclick="clickTesting('facebook');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>facebook.png" border="0" alt="" title=""/>Facebook</a>
						</li>
						<li style="display:<?php if($card_values['twitterSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="twitterSelected_icon">
							<a target="_blank" href="<?php if($card_values['twitter'] != '') echo addhttp($card_values['twitter']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('twitter');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>twitter.png" border="0" alt="" title=""/>Twitter</a>
						</li>
						<li style="display:<?php if($card_values['linkedinSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="linkedinSelected_icon">
							<a target="_blank" href="<?php if($card_values['linkedin'] != '') echo addhttp($card_values['linkedin']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('linkedin');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>linkedin.png" border="0" alt="" title=""/>Linkedin</a>
						</li>
						<li style="display:<?php if($card_values['blogSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="blogSelected_icon">
							<a target="_blank" href="<?php if($card_values['blog'] != '') echo addhttp($card_values['blog']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('blog');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>blog.png" border="0" alt="" title=""/>Blog</a>
						</li>
						<li style="display:<?php if($card_values['tumblrSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="tumblrSelected_icon">
							<a target="_blank" href="<?php if($card_values['tumblr'] != '') echo addhttp($card_values['tumblr']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('tumblr');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>tumblr.png" border="0" alt="" title=""/>Tumblr</a>
						</li>
						<li style="display:<?php if($card_values['soundCloudSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="soundCloudSelected_icon">
							<a target="_blank" href="<?php if($card_values['soundCloud'] != '') echo addhttp($card_values['soundCloud']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('soundCloud');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>soundcloud.png" border="0" alt="" title=""/>Soundcloud</a>
						</li>
						<li style="display:<?php if($card_values['youTubeSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="youTubeSelected_icon">
							<a target="_blank" href="<?php if($card_values['youTube'] != '') echo addhttp($card_values['youTube']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('youTube');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>youtube.png" border="0" alt="" title=""/>Youtube</a>
						</li>
						<li style="display:<?php if($card_values['googlePlusSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="googlePlusSelected_icon">
							<a target="_blank" href="<?php if($card_values['googlePlus'] != '') echo addhttp($card_values['googlePlus']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('googlePlus');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>googleplus.png" border="0" alt="" title=""/>Google+</a>
						</li>
						<li style="display:<?php if($card_values['spotifySelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="spotifySelected_icon">
							<a target="_blank" href="<?php if($card_values['spotify'] != '') echo addhttp($card_values['spotify']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('spotify');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>spotify.png" border="0" alt="" title=""/>Spotify</a>
						</li>
						<!-- Utility -->
						<li style="display:<?php if($card_values['promotionSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="promotionSelected_icon">
							<a href="javascript:void(0);" <?php if($click == 1) {?> onclick="clickTesting('promotion');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>promotion.png" border="0" alt="" title=""/>Promotion</a>
						</li>
						<li style="display:<?php if($card_values['calenderSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="calenderSelected_icon">
							<a href="javascript:void(0);" <?php if($click == 1) {?> onclick="clickTesting('calender');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>calender.png" border="0" alt="" title=""/>Calender</a>
						</li>
						<li style="display:<?php if($card_values['customerServiceSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="customerServiceSelected_icon">
							<a target="_blank" href="<?php if($card_values['customerService'] != '') echo 'tel:+'.$card_values['customerService']; else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('customerService');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>linkedin.png" border="0" alt="" title=""/>Customer service</a>
						</li>
						<li style="display:<?php if($card_values['appStoreSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="appStoreSelected_icon">
							<a target="_blank" href="<?php if($card_values['appStore'] != '') echo addhttp($card_values['appStore']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('appStore');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>ios_appstore.png" border="0" alt="" title=""/>App store</a>
						</li>
						<li style="display:<?php if($card_values['shareFilesSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="shareFilesSelected_icon">
							<a href="javascript:void(0);" <?php if($click == 1) {?> onclick="clickTesting('shareFile');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>share_file.png" border="0" alt="" title=""/>Share files</a>
						</li>
						<li style="display:<?php if($card_values['requestMeetingSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="requestMeetingSelected_icon">
							<a href="javascript:void(0);" <?php if($click == 1) {?> onclick="clickTesting('requestMeeting');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>request_meet.png" border="0" alt="" title=""/>Request meeting</a>
						</li>
						<li style="display:<?php if($card_values['ticketsSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="ticketsSelected_icon">
							<a target="_blank" href="<?php if($card_values['tickets'] != '') echo addhttp($card_values['tickets']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('tickets');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>tickets.png" border="0" alt="" title=""/>Tickets</a>
						</li>
						<li style="display:<?php if($card_values['playStoreSelected'] == 1 ) echo 'block'; else echo 'none';  ?>" id="playStoreSelected_icon">
							<a target="_blank" href="<?php if($card_values['playStore'] != '') echo addhttp($card_values['playStore']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('playStore');"<?php } ?> ><img class="imageicon" src="<?php echo $folderpath; ?>google.png" border="0" alt="" title=""/>Play store</a>
						</li>
					</ul>
				</div>
				<div id="rowicon" class="<?php echo $row_class; ?>" style="<?php echo $row_display; ?>"><!-- rubber metal -->
					<div id="phoneNumberSelected_row" class="midbg" style="display:<?php if($card_values['phoneNumberSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['phoneNumber'] != '') echo 'tel:+'.$card_values['phoneNumber']; else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('phoneNumber');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/phone.png"  alt="" class="fleft">Phone</a></div></div>
					</div>
					<div id="websiteSelected_row" class="midbg" style="display:<?php if($card_values['websiteSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['website'] != '') echo addhttp($card_values['website']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('website');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/www.png"  alt="" class="fleft">Website</a></div></div>
					</div>
					<div id="emailSelected_row" class="midbg" style="display:<?php if($card_values['emailSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['email'] != '') echo 'mailto:'.$card_values['email']; else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('email');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/mail.png"  alt="" class="fleft">Email</a></div></div>
					</div>
					<div id="smsSelected_row" class="midbg" style="display:<?php if($card_values['smsSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['sms'] != '') echo 'sms:+'.$card_values['sms']; else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('sms');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/sms.png"  alt="" class="fleft">SMS</a></div></div>
					</div>
					<div id="skypeSelected_row" class="midbg" style="display:<?php if($card_values['skypeSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['skype'] != '') echo 'skype:'.$card_values['skype']; else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('skype');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/skype.png"  alt="" class="fleft">Skype</a></div></div>
					</div>
					<div id="addContactSelected_row" class="midbg" style="display:<?php if($card_values['addContactSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a href="javascript:void(0);" <?php if($click == 1) {?> onclick="downloadVcf(<?php echo $browser; ?>,'<?php echo $card_values['name']; ?>'); clickTesting('addContact');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/contact2.png"  alt="" class="fleft">Add contact</a></div></div>
					</div>
					<div id="addWeblinkSelected_row" class="midbg" style="display:<?php if($card_values['addWeblinkSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['addWeblink'] != '') echo addhttp($card_values['addWeblink']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('addWeblink');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/weblink.png"  alt="" class="fleft">Add weblink</a></div></div>
					</div>
					<div id="addressSelected_row" class="midbg" style="display:<?php if($card_values['addressSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['address'] != '') echo 'http://maps.google.com/maps?q='.$card_values['address']; else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('address');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/map.png"  alt="" class="fleft">Address</a></div></div>
					</div>
					<div id="viberSelected_row" class="midbg" style="display:<?php if($card_values['viberSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a href="javascript:void(0);" <?php if($click == 1) {?> onclick="clickTesting('viber');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/viber.png"  alt="" class="fleft">Viber</a></div></div>
					</div>
					<div id="facebookSelected_row" class="midbg" style="display:<?php if($card_values['facebookSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['facebook'] != '') echo addhttp($card_values['facebook']); else echo 'javascript:void(0);';?>" <?php if($click == 1) {?> onclick="clickTesting('facebook');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/facebook.png"  alt="" class="fleft">Facebook</a></div></div>
					</div>
					<div id="twitterSelected_row" class="midbg" style="display:<?php if($card_values['twitterSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['twitter'] != '') echo addhttp($card_values['twitter']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('twitter');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/twitter.png"  alt="" class="fleft">Twitter</a></div></div>
					</div>
					<div id="linkedinSelected_row" class="midbg" style="display:<?php if($card_values['linkedinSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['linkedin'] != '') echo addhttp($card_values['linkedin']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('linkedin');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/linkedin.png"  alt="" class="fleft">Linked In</a></div></div>
					</div>
					<div id="blogSelected_row" class="midbg" style="display:<?php if($card_values['blogSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['blog'] != '') echo addhttp($card_values['blog']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('blog');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/blog.png"  alt="" class="fleft">Blog</a></div></div>
					</div>
					<div id="tumblrSelected_row" class="midbg" style="display:<?php if($card_values['tumblrSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['tumblr'] != '') echo addhttp($card_values['tumblr']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('tumblr');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/tumblr.png"  alt="" class="fleft">Tumblr</a></div></div>
					</div>
					<div id="soundCloudSelected_row" class="midbg" style="display:<?php if($card_values['soundCloudSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['soundCloud'] != '') echo addhttp($card_values['soundCloud']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('soundCloud');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/soundcloud.png"  alt="" class="fleft">Soundcloud</a></div></div>
					</div>
					<div id="youTubeSelected_row" class="midbg" style="display:<?php if($card_values['youTubeSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['youTube'] != '') echo addhttp($card_values['youTube']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('youTube');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/youtube.png"  alt="" class="fleft">Youtube</a></div></div>
					</div>
					<div id="googlePlusSelected_row" class="midbg" style="display:<?php if($card_values['googlePlusSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['googlePlus'] != '') echo addhttp($card_values['googlePlus']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('googlePlus');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/googleplus.png"  alt="" class="fleft">Google+</a></div></div>
					</div>
					<div id="spotifySelected_row" class="midbg" style="display:<?php if($card_values['spotifySelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['spotify'] != '') echo addhttp($card_values['spotify']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('spotify');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/spotify.png"  alt="" class="fleft">Spotify</a></div></div>
					</div>
					
					<div id="promotionSelected_row" class="midbg" style="display:<?php if($card_values['promotionSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a href="javascript:void(0);" <?php if($click == 1) {?> onclick="clickTesting('promotion');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/promotion.png"  alt="" class="fleft">Promotion</a></div></div>
					</div>
					<div id="calenderSelected_row" class="midbg" style="display:<?php if($card_values['calenderSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a href="javascript:void(0);" <?php if($click == 1) {?> onclick="clickTesting('calender');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/calender.png"  alt="" class="fleft">Calender</a></div></div>
					</div>
					<div id="customerServiceSelected_row" class="midbg" style="display:<?php if($card_values['customerServiceSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['customerService'] != '') echo 'tel:+'.$card_values['customerService']; else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('customerService');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/linkedin.png"  alt="" class="fleft">Customer service</a></div></div>
					</div>
					<div id="appStoreSelected_row" class="midbg" style="display:<?php if($card_values['appStoreSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['appStore'] != '') echo addhttp($card_values['appStore']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('appStore');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/ios_appstore.png"  alt="" class="fleft">App store</a></div></div>
					</div>
					<div id="shareFilesSelected_row" class="midbg" style="display:<?php if($card_values['shareFilesSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a href="javascript:void(0);" <?php if($click == 1) {?> onclick="clickTesting('shareFile');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/share_file.png"  alt="" class="fleft">Share files</a></div></div>
					</div>
					<div id="requestMeetingSelected_row" class="midbg" style="display:<?php if($card_values['requestMeetingSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a href="javascript:void(0);" <?php if($click == 1) {?> onclick="clickTesting('requestMeeting');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/request_meet.png"  alt="" class="fleft">Request meeting</a></div></div>
					</div>
					<div id="ticketsSelected_row" class="midbg" style="display:<?php if($card_values['ticketsSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['tickets'] != '') echo addhttp($card_values['tickets']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('tickets');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/tickets.png"  alt="" class="fleft">Tickets</a></div></div>
					</div>
					<div id="playStoreSelected_row" class="midbg" style="display:<?php if($card_values['playStoreSelected'] == 1 ) echo 'block'; else echo 'none';  ?>">
						<div class="left"><div class="right"><a target="_blank" href="<?php if($card_values['playStore'] != '') echo addhttp($card_values['playStore']); else echo 'javascript:void(0);'; ?>" <?php if($click == 1) {?> onclick="clickTesting('playStore');"<?php } ?> ><img src="<?php echo IMAGE_FOLDER_PATH_SITE; ?>rowicon/plastic/google.png"  alt="" class="fleft">Play store</a></div></div>
					</div>
				</div>
				<div class="push"></div>
				<div class="clearh"></div>
			</div>
			<div class="clearh"></div>
		</div>
		<div class="clearh"></div>
	</div>
	
	<!-- Footer : Start -->
	<!-- <div class="footer">
		<a href="#"><img src="<?php echo IMAGE_BUTTON_PATH; ?>tab.png" alt="" border="0"></a>
	</div> -->	
	</div>
</div><?php if(isset($_GET['small']) && $_GET['small'] == 1) {?></div></div><?php } ?>

</body>
</html>
<?php if( isset($_GET['card']) && $_GET['card'] != '') { ?>
<script type="text/javascript">
	var path = actionPath;
	var preview = window.opener.document;
	var bgcolour = $(preview.getElementById("cardColour_1")).val();
	$('.menu').css('background',bgcolour);
	var headcolour = $(preview.getElementById("cardColour_2")).val();
	$('.header').css('background',headcolour);
	/*$('.viewport').css('background',headcolour);*/
	//document.body.style.background = bgcolour;
	var format_type = $(preview.getElementById("buttonFormat")).val();
	var style_type = $(preview.getElementById("buttonStyle")).val();
	var img_path;
	if(format_type != '' && style_type != '') {
		if(format_type == 1 && style_type == 1) {
			img_path = path+'WebResources/Images/tileicon/metal/';
		}
		else if(format_type == 1 && style_type == 2) {
			img_path = path+'WebResources/Images/tileicon/rubber/';
		}
		else if(format_type == 2 && style_type == 1) {
			$('#tileicon').attr('class','').addClass('metal');
			img_path = path+'WebResources/Images/rowicon/metal/';
		}
		else if(format_type == 2 && style_type == 2) {
			$('#rowicon').attr('class','').addClass('rubber');
			img_path = path+'WebResources/Images/rowicon/rubber/';
		}
		$('.imageicon').each(function(i,variable){
			var img_src = $(this).attr('src');
			img_name_array = img_src.split('/');
			img_name = img_name_array[img_name_array.length-1];
			$(this).attr('src',img_path+img_name);
		}); 
	}
	if(format_type == 1)
	{
		$('#tileicon').show();
		$('#rowicon').hide();
		var img_type = '_icon';
	}
	else
	{
		$('#tileicon').hide();
		$('#rowicon').show();
		var img_type = '_row';
	}
	/*Contact*/
	if($(preview.getElementById("phoneNumberSelected")).is(':checked'))
		$('#phoneNumberSelected'+img_type).show();
	if($(preview.getElementById("websiteSelected")).is(':checked'))
		$('#websiteSelected'+img_type).show();
	if($(preview.getElementById("emailSelected")).is(':checked'))
		$('#emailSelected'+img_type).show();
	if($(preview.getElementById("smsSelected")).is(':checked'))
		$('#smsSelected'+img_type).show();
	if($(preview.getElementById("skypeSelected")).is(':checked'))
		$('#skypeSelected'+img_type).show();
	if($(preview.getElementById("addContactSelected")).is(':checked'))
		$('#addContactSelected'+img_type).show();
	if($(preview.getElementById("addWeblinkSelected")).is(':checked'))
		$('#addWeblinkSelected'+img_type).show();
	if($(preview.getElementById("addressSelected")).is(':checked'))
		$('#addressSelected'+img_type).show();
	if($(preview.getElementById("viberSelected")).is(':checked'))
		$('#viberSelected'+img_type).show();
	/* Social*/
	if($(preview.getElementById("facebookSelected")).is(':checked'))
		$('#facebookSelected'+img_type).show();
	if($(preview.getElementById("twitterSelected")).is(':checked'))
		$('#twitterSelected'+img_type).show();
	if($(preview.getElementById("linkedinSelected")).is(':checked'))
		$('#linkedinSelected'+img_type).show();
	if($(preview.getElementById("blogSelected")).is(':checked'))
		$('#blogSelected'+img_type).show();
	if($(preview.getElementById("tumblrSelected")).is(':checked'))
		$('#tumblrSelected'+img_type).show();
	if($(preview.getElementById("soundCloudSelected")).is(':checked'))
		$('#soundCloudSelected'+img_type).show();
	if($(preview.getElementById("youTubeSelected")).is(':checked'))
		$('#youTubeSelected'+img_type).show();
	if($(preview.getElementById("googlePlusSelected")).is(':checked'))
		$('#googlePlusSelected'+img_type).show();
	if($(preview.getElementById("spotifySelected")).is(':checked'))
		$('#spotifySelected'+img_type).show();
	/*Utility*/
	if($(preview.getElementById("promotionSelected")).is(':checked'))
		$('#promotionSelected'+img_type).show();
	if($(preview.getElementById("calenderSelected")).is(':checked'))
		$('#calenderSelected'+img_type).show();
	if($(preview.getElementById("customerServiceSelected")).is(':checked'))
		$('#customerServiceSelected'+img_type).show();
	if($(preview.getElementById("appStoreSelected")).is(':checked'))
		$('#appStoreSelected'+img_type).show();
	if($(preview.getElementById("shareFilesSelected")).is(':checked'))
		$('#shareFilesSelected'+img_type).show();
	if($(preview.getElementById("requestMeetingSelected")).is(':checked'))
		$('#requestMeetingSelected'+img_type).show();
	if($(preview.getElementById("ticketsSelected")).is(':checked'))
		$('#ticketsSelected'+img_type).show();
	if($(preview.getElementById("playStoreSelected")).is(':checked'))
		$('#playStoreSelected'+img_type).show();
	
</script>
<?php }  else if( (isset($_GET['small']) && $_GET['small'] == 1) || (isset($_GET['shorturl']) && $_GET['shorturl'] != '') ) { } else { ?>
<script type="text/javascript">
	var path = actionPath;
	var preview = window.opener.document;
	var bgcolour = $(preview.getElementById("cardColour_1")).val();
	$('.menu').css('background',bgcolour);
	var headcolour = $(preview.getElementById("cardColour_2")).val();
	$('.header').css('background',headcolour);
	/*$('.viewport').css('background',headcolour);*/
	//document.body.style.background = bgcolour;
	$('#iframe_profile').hide();
	$('#iframe_logo').hide();
	var iframe_s = $(preview.getElementById("cardPreview"));
	iframe_object = iframe_s.contents();
	iframe_logo_src = iframe_object.find('#iframe_logo').attr('src');
	iframe_profile_src = iframe_object.find('#iframe_profile').attr('src');
	iframe_logo_src = iframe_logo_src.replace("thumb/","")
	$('#iframe_span').addClass('prev_left');
	if(iframe_logo_src != '') {
		$('#iframe_logo').attr('src',iframe_logo_src);
		//$('#iframe_logo').show();
		$('.headtop').show();
		$("#iframe_logo").css("display", "inline");
		$('#iframe_span').removeClass('prev_left');
	}
	if(iframe_profile_src != '') {
		$('#iframe_profile').attr('src',iframe_profile_src);
		$('#iframe_profile').show();
	}
	if($(preview.getElementById("banner_img_name")).val() != '')
	{
		var frm_name = 'banner';
		var imgName = $(preview.getElementById("banner_img_name")).val();
		var path = actionPath+'WebResources/Images/temp/';
		var img_n = imgName+'?'+Math.random();
		$('#iframe_'+frm_name).show();
		$('#iframe_'+frm_name).attr('src',path+img_n);
		$('#iframe_span').removeClass('prev_left');
	}
	if($(preview.getElementById("name")).val() != '')
	{
		$('#iframe_name').html($(preview.getElementById("name")).val());
		$('#iframe_name').removeAttr('style');
	}
	if($(preview.getElementById("title")).val() != '')
	{
		$('#iframe_title').html($(preview.getElementById("title")).val());
		$('#iframe_title').removeAttr('style');
	}
</script>
<?php } ?>
<script>
	function clickTesting(id)
	{
		var userId = $('#userId').val();
		var cardId = $('#cardId').val();
		var shortUrl = $('#shortUrl').val();
		var ajax_action_url = 'Models/AjaxAction.php';
		$.post(actionPath+ajax_action_url+'?action=CLICK_COUNT',{card_id:cardId, user_id:userId, name:id, short_url:shortUrl},function(data){
			//	To do
		});
	}
	function downloadVcf(browser,c_name)
	{
		var cardId = $('#cardId').val();
		location.href = actionPath+'Views/downloadContact.php?browser='+browser+'&card_id='+cardId+'&card_name='+c_name;
	}
</script>