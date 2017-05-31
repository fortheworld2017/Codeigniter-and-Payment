<?php
	ob_start();
	if (!session_id()) session_start();
	if(!isset($_SESSION['tac_data']['user_id'])) {
		header("Location:homepage");
		die();
	}
	//$_SESSION['template_page'] = 1;
	if(!isset($_GET['editId']))
	{
		if(!isset($_SESSION['tac_data']['template_id']) || !isset($_SESSION['template_page'])) {
			header("Location:homepage");
			die();
		}
	}
	$_SESSION['create_page'] = 1;
	require_once('Controllers/CardDetailsController.php');
	$cardDetailsControllerObj 	= 	new CardDetailsController();
	require_once('Controllers/CardTemplateController.php');
	$cardTemplateControllerObj 	= 	new CardTemplateController();
	require_once('Controllers/DomainController.php');
	$domainControllerObj 	= 	new DomainController();
	// variable declaration - begins
	$activity 					= '';
	$cardType					= '';
	$template_id				= '';
	$logo_image	=	$profile_image	=	$banner_image	=	$promotion_image	=	$sharefile_image	=	'';
	$logo_ext = $profile_ext = $banner_ext = $promotion_ext = '';
	$logo_upload_display		= 'display:block';
	$logo_name_display			= 'display:none';
	$logo_img_name				= '';
	$profile_upload_display		= 'display:block';
	$profile_name_display		= 'display:none';
	$profile_img_name			= '';
	$banner_upload_display		= 'display:block';
	$banner_name_display		= 'display:none';
	$banner_img_name			= '';
	$promotion_upload_display	= 'display:block';
	$promotion_name_display		= 'display:none';
	$promotion_img_name			= '';
	$sharefile_upload_display	= 'display:block';
	$sharefile_name_display		= 'display:none';
	$sharefile_img_name			= '';
	$contact_fields	=	$social_fields	=	$utility_fields = array();
	$title_array	=	array('1'=>'CARD', '2'=>'STICKER', '3'=>'CAMPAIGN', '4'=>'PROMOTION', '5'=>'EVENT');
	$class_array	=	array('1'=>'card_txt', '2'=>'sticker_txt', '3'=>'campaign_txt', '4'=>'promotion_txt', '5'=>'event_txt');
	$post_value	= array(
					   'name'	  			=> '',
					   'title'		  		=> '',
					   'position'			=> '',
					   'company'			=> '',
					   'buttonFormat'		=> '',
					   'buttonStyle'		=> '',
					   'facebook'  			=> '',
					   'twitter' 			=> '',
					   'linkedin'			=> '',
					   'blog' 				=> '',
					   'tumblr' 			=> '',
					   'soundCloud'			=> '',
					   'youTube'  			=> '',
					   'googlePlus'			=> '',
					   'spotify'			=> '',
					   'phoneNumber'		=> '',
					   'website'			=> '',
					   'email'				=> '',
					   'sms'				=> '',
					   'skype'				=> '',
					   'addContact'			=> '',
					   'addWeblink'			=> '',
					   'address'			=> '',
					   'viber'				=> '',
					   'promotion'			=> '',
					   'calender'			=> '',
					   'customerService'	=> '',
					   'appStore'			=> '',
					   'shareFiles'			=> '',
					   'requestMeeting'		=> '',
					   'tickets'			=> '',
					   'playStore'			=> '',
					   'backgroundColor'	=> '#CBCBCB'
		 				);
	// variable declaration - ends
	$contact_class_name	=	array(
								"msg"	=>	array('Phone number','Website address','Email', 'SMS', 'Skype address', 'Add contact', 'Add weblink', 'Address', 'Viber'),
								"name"	=>	array('phoneNumber', 'website', 'email', 'sms', 'skype', 'addContact', 'addWeblink', 'address', 'viber'),
								"class"	=>	array('required', 'required url', 'required email', 'required', 'required', 'required', 'required url', 'required', 'required')
						  	 );
	$social_class_name	=	array(
								"msg"	=>	array('Facebook URL','Twitter URL','Linkedin URL', 'Blog URL', 'Tumblr URL', 'Sound cloud URL', 'You Tube URL', 'Google plus URL', 'Spotify URL'),
								"name"	=>	array('facebook', 'twitter', 'linkedin', 'blog', 'tumblr', 'soundCloud', 'youTube', 'googlePlus', 'spotify'),
								"class"	=>	array('required url', 'required url', 'required url', 'required url', 'required url', 'required url', 'required url', 'required url', 'required url')
						  	 );
	
	$utility_class_name	=	array(
								"msg"	=>	array('Promotion','Calender','Customer service', 'App Store URL', 'Share Files', 'Request meeting', 'Tickets', 'Play store URL'),
								"name"	=>	array('promotion', 'calender', 'customerService', 'appStore', 'shareFiles', 'requestMeeting', 'tickets', 'playStore'),
								"class"	=>	array('required', 'required', 'required', 'required url', 'required', 'required', 'required', 'required', 'required url')
						  	 );

	unset($_SESSION['designCard']);
	unset($_SESSION['designSticker']);
	unset($_SESSION['designTag']);
	/*	To get selected Fields - begins	*/
	if(isset($_GET['editId']) && $_GET['editId'] != '')
	{
		$card_temp_id		=	$_GET['editId'];
		$selectedOptions	=	$cardTemplateControllerObj->getSelectedOptionsByCard($card_temp_id);	//	card id
	}
	else if(isset($_SESSION['tac_data']['template_id']) && $_SESSION['tac_data']['template_id'] != '')
	{
		$template_id		=	$_SESSION['tac_data']['template_id'];
		$selectedOptions	=	$cardTemplateControllerObj->getSelectedOptions($template_id);		//	template id
	}
	if(isset($selectedOptions) && is_array($selectedOptions) && count($selectedOptions) > 0) {
		$cardType	=	$selectedOptions[0]->cardType;
		$mediaType	=	$selectedOptions[0]->mediaType;
		$_SESSION['tac_data']['cardType'] = $cardType;
		$cardColor	=	$selectedOptions[0]->cardColour;
		if($template_id != '')
			$iframe_dup			=	'&temp_id='.$template_id;
		else {
			$iframe_dup			=	'&temp_id='.$selectedOptions[0]->id;
			$template_id		=	$selectedOptions[0]->id;
		}
		$field_array = explode('##',$selectedOptions[0]->selectedOptions);
		if($field_array[0] != 'NULL')
		{
			$contact_fields = explode(',',$field_array[0]);
		}
		if($field_array[1] != 'NULL')
		{
			$social_fields = explode(',',$field_array[1]);
		}
		if($field_array[2] != 'NULL')
		{
			$utility_fields = explode(',',$field_array[2]);
		}
	}
	/*	To get selected Fields - ends	*/
	
	/*	Submit action - begins	*/
	if(isset($_POST['cardSubmit']) && $_POST['cardSubmit'] != '')
	{
		if(isset($_POST['logo_img_name']) && $_POST['logo_img_name'] != '') {
			$logo_img_array 				=	explode(".",$_POST['logo_img_name']);
			$_POST['logoExt']				=	end($logo_img_array);
			$_POST['logoName']				=	$logo_img_array[0];//getImageName($logo_img_array[0]);
		}
		if(isset($_POST['profile_img_name']) && $_POST['profile_img_name'] != '') {
			$profile_img_array 				=	explode(".",$_POST['profile_img_name']);
			$_POST['profileExt']			=	end($profile_img_array);
			$_POST['profileName']			=	$profile_img_array[0];//getImageName($profile_img_array[0]);
		}
		else
			unset($_POST['profile_img_name']);
		if(isset($_POST['banner_img_name']) && $_POST['banner_img_name'] != '') {
			$banner_img_array 				=	explode(".",$_POST['banner_img_name']);
			$_POST['bannerExt']				=	end($banner_img_array);
			$_POST['bannerName']			=	$banner_img_array[0];//getImageName($banner_img_array[0]);
		}
		if(isset($_POST['promotion_img_name']) && $_POST['promotion_img_name'] != '') {
			$promotion_img_array 			=	explode(".",$_POST['promotion_img_name']);
			$_POST['promotionExt']			=	end($promotion_img_array);
			$_POST['promotionImgName']		=	$promotion_img_array[0];//getImageName($$promotion_img_array[0]);
		}
		if(isset($_POST['sharefile_img_name']) && $_POST['sharefile_img_name'] != '') {
			$sharefile_img_array 			=	explode(".",$_POST['sharefile_img_name']);
			$_POST['shareFileExt']			=	end($sharefile_img_array);
			$_POST['shareFile']				=	$sharefile_img_array[0];//getImageName($sharefile_img_array[0]);
		}
		
		/*	To generate short url	- begins	*/
		if(!isset($_POST['card_id'])) {
			$shorturl	= get_rand_alphanumeric(SHORT_URL_LEN);
			$fields		= 'id, name';
			$check_exists_loop = 1;
			while($check_exists_loop){
				$condition	= ' shortUrl = ? ';
				$check_exists = $cardDetailsControllerObj->checkExist($fields, $condition, array($shorturl));
				if(isset($check_exists) && is_array($check_exists) && count($check_exists[0]) > 0)
				{
					$shorturl	=	get_rand_alphanumeric(SHORT_URL_LEN);
				}
				else {
					$check_exists_loop = 0;
				}
			}
			$_SESSION['tac_data']['shorturl']	=	$shorturl;
		}
		/*	To generate short url	- ends	*/
		
		/*	Create or Update Card - Begins	*/
		if(isset($_POST['card_id']) && $_POST['card_id'] != '')
		{
			$card_id			=	$_POST['card_id'];
			$updateCardDetails	=	$cardDetailsControllerObj->updateCardDetails($_POST,$card_id);
			$result = array_diff_assoc($_POST,$_SESSION['prev_card_val']);
			foreach($result as $key => $value)
			{
				if($key != 'errorFlag' && $key != 'cardSubmit' && $key != 'card_id' && $key != 'logoName' && $key != 'logoExt' && $key != 'profileName' && $key != 'profileExt' && $key != 'bannerName' && $key != 'bannerExt' && $key != 'promotionImgName' && $key != 'promotionExt' && $key != 'shareFile' && $key != 'shareFileExt')
				{
					if($key == 'logo_img_name')
						$activity .= 'Logo image has been changed, ';
					else if($key == 'profile_img_name')
						$activity .= 'Profile image has been changed, ';
					else if($key == 'banner_img_name')
						$activity .= 'Banner image has been changed, ';
					else if($key == 'promotion_img_name')
						$activity .= 'Promotion image has been changed, ';
					else if($key == 'sharefile_img_name')
						$activity .= 'Share file has been changed, ';
					else
						$activity .= ucfirst($key).' changed to '.$value.', ';
				}
			}
			$activity = substr($activity, 0, -2);
		}
		else
		{
			$insertCardDetails	=	$cardDetailsControllerObj->insertCardDetails($_POST,$shorturl);
			$card_id			=	$insertCardDetails;
			if($card_id) {
				/*	Domain Details	- Begins	*/
				if(isset($_SESSION['domain_name']) && $_SESSION['domain_name'] != '' && $_SESSION['domain_name'] == 0)
					$domain_name =	PRIMARY_DOMAIN;
				else{
					$cond = " and id = ? ";
					$domain_details	 = $domainControllerObj->getDomainInfo($cond, array($_SESSION['domain_name']));
					$domain_name     = $domain_details[0]->name;
				}
				$insertDomainDetails	=	$cardDetailsControllerObj->insertDomainDetails($card_id,$domain_name,$shorturl);
				/*	Domain Details	- Ends	*/
				$activity			=	'New '.ucfirst(strtolower($title_array[$_POST['cardType']])).' has been created';
			}
			else {
				header("Location:homepage");
				die();
			}
		}
		if($activity != '')
			$recentActivity			=	$cardDetailsControllerObj->insertRecentActivityDetails($card_id,$activity,$_POST['name']);
		/*	Create or Update Card -	ends	*/
		
		$_SESSION['tac_data']['cardId'] = $card_id;
		require_once('Views/vcfdownload.php');
		$createVCF 	= new createVCF();
		$ext 		= '.vcf';
		$createVCF->constructVCFData($_SESSION['tac_data'],$_POST);
		$createVCF->writeVCFcard(VCF_FOLDER_PATH,$card_id.$ext);
		
		if($card_id)
		{
			// 1 - logo, 2 - profile, 3 - banner, 4 - promotion
			if(isset($_POST['logo_img_name']) && $_POST['logo_img_name'] != '') {
				$org_logo_img_name		=	$_POST['logo_img_name'];
				$logo_ext				=	$_POST['logoExt'];
				saveImage($org_logo_img_name,$card_id,$logo_ext,1);	
			}
			if(isset($_POST['profile_img_name']) && $_POST['profile_img_name'] != '') {
				$org_proflie_img_name	=	$_POST['profile_img_name'];
				$profile_ext			=	$_POST['profileExt'];
				saveImage($org_proflie_img_name,$card_id,$profile_ext,2);
			}
			if(isset($_POST['banner_img_name']) && $_POST['banner_img_name'] != '') {
				$org_banner_img_name	=	$_POST['banner_img_name'];
				$banner_ext				=	$_POST['bannerExt'];
				saveImage($org_banner_img_name,$card_id,$banner_ext,3);
			}
			if(isset($_POST['promotion_img_name']) && $_POST['promotion_img_name'] != '') {
				$org_promotion_img_name	=	$_POST['promotion_img_name'];
				$promotion_ext			=	$_POST['promotionExt'];
				saveImage($org_promotion_img_name,$card_id,$promotion_ext,4);
			}
			if(isset($_POST['sharefile_img_name']) && $_POST['sharefile_img_name'] != '') {
				$org_harefile_img_name	=	$_POST['sharefile_img_name'];
				$sharefile_ext			=	$_POST['shareFileExt'];
				saveImage($org_harefile_img_name,$card_id,$sharefile_ext,5);
			}
		}
		unset($_SESSION['template_page']);
		if($cardType == 1 || ($cardType == 5 && $mediaType == 1)) {
			$_SESSION['designCard'] = 1;
			header("Location:designCard");
			die();
		}
		else if($cardType == 2 || ($cardType == 5 && $mediaType == 2)) {
			$_SESSION['designSticker'] = 1;
			header("Location:designSticker");
			die();
		}
		else if($cardType == 3 || ($cardType == 5 && $mediaType == 3)) {
			$_SESSION['designTag'] = 1;
			header("Location:designTag");
			die();
		}
		else if($cardType == 4)
			header("Location:homepage");
			die();
	}
	/*	Submit action - ends	*/
	
	if(isset($_GET['editId']) && $_GET['editId'] != '')
	{
		$fields			=	' cd.*, ct.cardColour, ct.cardType ';
		$condition		=	' and cd.id = ? ';
		$cardDetails	=	$cardDetailsControllerObj->getCardDetails($fields, $condition, '', array($_GET['editId']));
		if(isset($cardDetails) && is_array($cardDetails) && count($cardDetails) > 0) {
			foreach($cardDetails[0] as $key => $value)
			{
				$post_value[$key]		=	$value;
				if($key != 'logoName' && $key != 'logoExt' && $key != 'profileName' && $key != 'profileExt' && $key != 'bannerName' && $key != 'bannerExt' && $key != 'promotionImgName' && $key != 'promotionExt' && $key != 'shareFile' && $key != 'shareFileExt')
					$prev_card_value[$key]	=	$value;
			}
			$_SESSION['tac_data']['shorturl'] = $cardDetails[0]->shortUrl;
		}
		else
		{
			header("Location:homepage");
			die();
		}
		if(isset($post_value['logoName']) && $post_value['logoName'] != '') {
			$logo_image					=	$post_value['logoName'].'.'.$post_value['logoExt'];
			$logo_upload_display		=	'display:none';
			$logo_name_display			=	'display:block';
			$logo_img_name				=	'<a href="javascript:void(0);" onclick="deleteImage('."'".$logo_image."'".',1)">'.$logo_image.'&nbsp;&nbsp;&nbsp;&nbsp;X</a>';
			$prev_card_value['logo_img_name']	=	$logo_image;
		}
		if(isset($post_value['profileName']) && $post_value['profileName'] != '') {
			$profile_image				=	$post_value['profileName'].'.'.$post_value['profileExt'];
			$profile_upload_display		=	'display:none';
			$profile_name_display		=	'display:block';
			$profile_img_name			=	'<a href="javascript:void(0);" onclick="deleteImage('."'".$profile_image."'".',1)">'.$profile_image.'&nbsp;&nbsp;&nbsp;&nbsp;X</a>';
			$prev_card_value['profile_img_name']	=	$profile_image;
		}
		if(isset($post_value['bannerName']) && $post_value['bannerName'] != '') {
			$banner_image				=	$post_value['bannerName'].'.'.$post_value['bannerExt'];
			$banner_upload_display		=	'display:none';
			$banner_name_display		=	'display:block';
			$banner_img_name			=	'<a href="javascript:void(0);" onclick="deleteImage('."'".$banner_image."'".',1)">'.$banner_image.'&nbsp;&nbsp;&nbsp;&nbsp;X</a>';
			$prev_card_value['banner_img_name']	=	$banner_image;
		}
		if(isset($post_value['promotionImgName']) && $post_value['promotionImgName'] != '') {
			$promotion_image			=	$post_value['promotionImgName'].'.'.$post_value['promotionExt'];
			$promotion_upload_display	=	'display:none';
			$promotion_name_display		=	'display:block';
			$promotion_img_name			=	'<a href="javascript:void(0);" onclick="deleteImage('."'".$promotion_image."'".',1)">'.$promotion_image.'&nbsp;&nbsp;&nbsp;&nbsp;X</a>';
			$prev_card_value['promotion_img_name']	=	$promotion_image;
		}
		if(isset($post_value['shareFile']) && $post_value['shareFile'] != '') {
			$sharefile_image			=	$post_value['shareFile'].'.'.$post_value['shareFileExt'];
			$sharefile_upload_display	=	'display:none';
			$sharefile_name_display		=	'display:block';
			$sharefile_img_name			=	'<a href="javascript:void(0);" onclick="deleteImage('."'".$sharefile_image."'".',1)">'.$sharefile_image.'&nbsp;&nbsp;&nbsp;&nbsp;X</a>';
			$prev_card_value['sharefile_img_name']	=	$sharefile_image;
		}
		$_SESSION['prev_card_val']	=	$prev_card_value;
	}
?>

	<?php siteHeader(); ?>
	<!-- Content : Start -->
	<div class="Bodycontent">
		<!-- Left nav : Start -->
		<?php leftNav();?>
		<!-- Left nav : End -->
		<div class="inner_container">
			<!-- Breadcrum : Start -->
			<?php breadCrumbV2();?>
			<!-- Breadcrum : End -->
			<div class="content">
				<!-- Subnav : Start -->
				<?php subNav($cardType); ?>
				<!-- Subnav : End -->
				<!-- Create Card : Start -->
				<div class="card_details">
					<!-- Step : 1  -->
					<div class="create_card businesscard" style="display:block;">
					<form id="cardCreation" name="cardCreation" method="post" action="" enctype="multipart/form-data">
					<input type="Hidden" id="cardType" name="cardType" value="<?php echo $cardType; ?>">
					<table cellpadding="1" cellspacing="0" border="0" align="center" width="100%" >
						<tr><td height="20"></td></tr>													
						<tr><td>
							<table cellpadding="1" cellspacing="0" border="0" align="center" width="100%" >
								<tr>
									<td width="70%" valign="top">
										<table cellpadding="1" cellspacing="0" border="0" align="center" width="100%" >																						
											<tr><td>
												<table cellpadding="1" cellspacing="0" border="0" align="center" width="100%" >
													<tr>
														<td valign="top" width="50%">
															<table cellpadding="1" cellspacing="0" border="0" align="center" width="100%" class="multiplecard">
																<tr><td class="title" colspan="2">CREATE <?php echo $title_array[$cardType]; ?>S</td></tr>
																<tr><td height="20"></td></tr>
																<tr>
																	<td valign="top" width="85%" style="padding-top: 5px;">
																		<div class="clear">
																			SINGLE <?php echo $title_array[$cardType]; ?> 
																			<span style="padding-left: 42px;"><input type="checkbox" ><label></label></span>
																		</div>
																		<div class="clear"><br>																		
																			MULTIPLE <?php echo $title_array[$cardType]; ?>S<br>											
																			<b class="exampletxt">Upload CSV file.</b><br>
																			<a href="#">Download CSV Template.</a><br>
																		</div>
																	</td>
																	<td valign="top" align="left">
																		<div class="relative">
																			<input type="file"  class="file_photo" onclick="return false;">
																			<span class="fakefile_photo <?php echo $class_array[$cardType]; ?>" style="">
																				<input type="text" class="browsebut" value="" autocomplete="off">
																			</span>
																		</div>
																	</td>
																</tr>
															</table>
														</td>
														<td valign="top">
														<?php if($cardType != 1) { ?>
															<table cellpadding="1" cellspacing="0" border="0" align="center" width="100%" >
															<!-- Banner -->
																<tr><td class="title" align="left">BANNER</td></tr>
																<tr><td height="10"></td></tr>
																<tr><td>
																	<div id="banner_upload" style="<?php echo $banner_upload_display; ?>">
																	<table>
																		<tr><td>Upload a Logo Image</td></tr>
																		<tr><td height="5"></td></tr>
																		<tr><td height="25" valign="top">
																			<div class="relative">
																				<input type="file" class="file_photo" onchange="ajaxfileUpload('cardCreation','image4',4)" id="image4" name="image4">
																				<span class="fakefile_photo" >
																					<input type="text" autocomplete="off" value="" class="browsebut">
																				</span>
																			</div>
																		</td></tr>
																		<tr><td class="exampletxt">Recommended 250px by 250px transparent PNG</td></tr>
																	</table>
																	</div>
																	<div id="banner_image" class="" style="<?php echo $banner_name_display; ?>"><?php echo $banner_img_name; ?></div>
																	<input type="hidden" validationmsg="Banner image" class="required" id="banner_img_name" name="banner_img_name" value="<?php echo $banner_image; ?>" />
																	<div id="banner_img_name_msg" class="error_msg" style="display:none;"></div>
																</td></tr>
																<tr><td height="10"></td></tr>
																<!-- banner -->
															</table>
															<?php } ?>
														</td>
													</tr>
												</table>
											</td></tr>
											<tr><td height="10"></td></tr>
											
											<?php if($cardType == 1) { ?>
											<tr><td valign="top">
												<table cellpadding="1" cellspacing="0" border="0" align="center" width="100%" >
													<tr>
														<td valign="top" width="48%">
															<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">										
																<tr><td class="title" align="left">LOGO</td></tr>
																<tr><td height="10"></td></tr>
																<tr><td>
																	<div id="logo_upload" style="<?php echo $logo_upload_display; ?>">
																	<table>
																		<tr><td>Upload a Logo Image</td></tr>
																		<tr><td height="5"></td></tr>
																		<tr><td height="25" valign="top">
																			<div class="relative">
																				<input type="file" class="file_photo" onchange="ajaxfileUpload('cardCreation','image',1)" id="image" name="image">
																				<span class="fakefile_photo" >
																					<input type="text" autocomplete="off" value="" class="browsebut">
																				</span>
																			</div>
																		</td></tr>
																		<tr><td class="exampletxt">Recommended 250px by 250px transparent PNG</td></tr>
																	</table>
																	</div>
																	<div id="logo_image" class="" style="<?php echo $logo_name_display; ?>"><?php echo $logo_img_name; ?></div>
																	<!-- <div id="logo_image" class="" style=""><a href="javascript:void(0);" onclick="">Sample</a></div> -->
																	<!-- <div id="logo_image" class="logoimage_delete" style="display:none;"></div> -->
																	<input type="hidden" validationmsg="Logo image" class="required" id="logo_img_name" name="logo_img_name" value="<?php echo $logo_image; ?>" />
																	<div id="logo_img_name_msg" class="error_msg" style="display:none;"></div>
																</td></tr>
															</table>
														</td>
														<td align="right">
															<table cellpadding="0" cellspacing="0" border="0" align="center" width="90%">		
																<tr><td class="title" align="left">PROFILE PIC <b>(Optional)</b></td></tr>
																<tr><td height="10"></td></tr>
																<tr><td>
																	<div id="profile_upload" style="<?php echo $profile_upload_display; ?>">
																		<table>
																			<tr><td>Upload a Profile pic <span style="padding-left: 40px;"></span></td></tr>										
																			<tr><td height="5"></td></tr>
																			<tr><td height="25" valign="top">
																					<div class="relative">
																						<input type="file"  class="file_photo" onchange="ajaxfileUpload('cardCreation','image2',2)" id="image2" name="image2">
																						<span class="fakefile_photo" >
																							<input type="text" autocomplete="off" value="OR UPLOAD NEW" class="browsebut">
																						</span>
																					</div>
																			</td></tr>
																			<tr><td class="exampletxt">Recommended 300px by 300px jpeg</td></tr>
																		</table>
																	</div>
																	<div id="profile_image" style="<?php echo $profile_name_display; ?>"><?php echo $profile_img_name; ?></div>
																	<input type="hidden"  id="profile_img_name" name="profile_img_name" value="<?php echo $profile_image; ?>" />
																</td></tr>
																<tr><td height="15"></td></tr>
															</table>
														</td>
													</tr>
												</table>		
											</td></tr>
											<tr><td height="20"></td></tr>
											<?php } ?>
											<tr><td class="title">CONTACT DETAILS</td></tr>
											<tr><td height="20"></td></tr>
											<tr><td>
												<table cellpadding="1" cellspacing="0" border="0" align="center" width="100%" >													
													<tr>
														<td valign="top">
														<ul class="contact_detial">
															<li class="clear">
																<input validationmsg="Name" type="text" autocomplete="off" onblur="changeName('name');" id="name" name="name" value="<?php echo $post_value['name']; ?>" placeholder="NAME" class="inputbox required">
																<div id="name_msg" class="error_msg" style="display:none;">*Name is required</div>
															</li>
															<li class="">
																<input validationmsg="Title" type="text" autocomplete="off" onblur="changeName('title');" id="title" name="title" value="<?php echo $post_value['title']; ?>" placeholder="TITLE" class="inputbox required">
															<div id="title_msg" class="error_msg" style="display:none;">*Title is required</div>
															</li>
															<li class="">
																<input validationmsg="Position" type="text" autocomplete="off" id="position" name="position" value="<?php echo $post_value['position']; ?>" placeholder="POSITION" class="inputbox required">
															<div id="position_msg" class="error_msg" style="display:none;">*Title is required</div>
															</li>
															<li class="">
																<input validationmsg="Company" type="text" autocomplete="off" onblur="changeName('company');" id="company" name="company" value="<?php echo $post_value['company']; ?>" placeholder="COMPANY" class="inputbox required">
																<div id="company_msg" class="error_msg" style="display:none;">*Company is required</div>
															</li>
															<?php
																
																foreach($contact_fields as $key => $c_val) {
																	$fieldName	= $contact_class_name['name'][$c_val-1];
																	$msg		= $contact_class_name['msg'][$c_val-1];
																	$class		= $contact_class_name['class'][$c_val-1];
															?>
															<li class="">
																<input type="text" validationmsg="<?php echo $msg; ?>" autocomplete="off"  <?php if($fieldName == 'phoneNumber' || $fieldName == 'sms') { ?> onkeypress="return isNumberKey(event);"  maxlength="15" <?php } ?> id="<?php echo $fieldName;?>" name="<?php echo $fieldName;?>" value="<?php echo $post_value[$fieldName]; ?>" placeholder="<?php echo $contact_array[$c_val]; ?>" class="inputbox <?php echo $class; ?>">
																<div id="<?php echo $fieldName;?>_msg" class="error_msg" style="display:none;"></div>
															</li>
															<?php } ?>
															<?php
																foreach($social_fields as $key => $s_val) {
																	$fieldName	= $social_class_name['name'][$s_val-1];
																	$msg		= $social_class_name['msg'][$s_val-1];
																	$class		= $social_class_name['class'][$s_val-1];
															?>
															<li class="">
																<input type="text" validationmsg="<?php echo $msg; ?>" autocomplete="off" id="<?php echo $fieldName;?>" name="<?php echo $fieldName;?>" value="<?php echo $post_value[$fieldName]; ?>" placeholder="<?php echo $social_array[$s_val]; ?>" class="inputbox <?php echo $class; ?>">
																<div id="<?php echo $fieldName;?>_msg" class="error_msg" style="display:none;"></div>
															</li>
															<?php } ?>
															<?php
																foreach($utility_fields as $key => $u_val) {
																	$fieldName	= $utility_class_name['name'][$u_val-1];
																	$msg		= $utility_class_name['msg'][$u_val-1];
																	$class		= $utility_class_name['class'][$u_val-1];
																	if($u_val == 1) {
															?>
																	<li class="">
																		<div id="promotion_upload" class="relative height60" style="<?php echo $promotion_upload_display; ?>">
																			<input type="file"  class="file_photo" onchange="ajaxfileUpload('cardCreation','image5',5)" id="image5" name="image5">
																			<span class="fakefile_photo" >
																				<input type="text" value="PROMOTION IMAGE" class="browsebut" >
																			</span><br><br>
																			<span class="clear exampletxt">Upload a promotional image.<br>Recommended max width</span>
																		</div>
																		<div id="promotion_image" class="uploadedtxt" style="<?php echo $promotion_name_display; ?>"><?php echo $promotion_img_name; ?></div>
																		<input type="hidden" validationmsg="Promotion image" class="required" id="promotion_img_name" name="promotion_img_name" value="<?php echo $promotion_image; ?>" />
																		<div id="promotion_img_name_msg" class="error_msg" style="display:none;"></div>
																		
																	</li>
															<?php } else if($u_val == 2 || $u_val == 6) { ?>
																	<div >
																		<input type="text" readonly="readonly" validationmsg="<?php echo $msg; ?>" autocomplete="off" id="<?php echo $fieldName;?>" name="<?php echo $fieldName;?>" value="<?php echo $post_value[$fieldName]; ?>" placeholder="<?php echo $utilities_array[$u_val]; ?>" class="inputbox inputw130 <?php echo $class; ?>">
																		<div id="<?php echo $fieldName;?>_msg" class="error_msg clear" style="display:none;"></div>
																	</div>
															<?php } else if($u_val == 5) { ?>
																	<li class="">
																		<div id="sharefile_upload" class="relative height30" style="<?php echo $sharefile_upload_display; ?>">
																			<input type="file"  class="file_photo" onchange="ajaxfileUpload('cardCreation','image6',6)" id="image6" name="image6">
																			<span class="fakefile_photo" >
																				<input type="text" value="ADD A FILE" class="browsebut">
																			</span>
																		</div>
																		<div id="sharefile_image" class="uploadedtxt" style="<?php echo $sharefile_name_display; ?>"><?php echo $sharefile_img_name; ?></div>
																		<input type="hidden" validationmsg="Share file" class="required" id="sharefile_img_name" name="sharefile_img_name" value="<?php echo $share_image; ?>" />
																		<div id="sharefile_img_name_msg" class="error_msg" style="display:none;"></div>
																	</li>
															<?php } else { ?>
																	<li class="">
																		<input type="text" validationmsg="<?php echo $msg; ?>" autocomplete="off" <?php if($fieldName == 'customerService') { ?> onkeypress="return isNumberKey(event);"  maxlength="15" <?php } ?> id="<?php echo $fieldName;?>" name="<?php echo $fieldName;?>" value="<?php echo $post_value[$fieldName]; ?>" placeholder="<?php echo $utilities_array[$u_val]; ?>" class="inputbox <?php echo $class; ?>">
																		<div id="<?php echo $fieldName;?>_msg" class="error_msg" style="display:none;"></div>
																	</li>
																	
															<?php } } ?>
														</ul>														
														</td>														
													</tr>
													<input type="hidden" id="cardColour" name="cardColour" value="<?php echo $cardColor; ?>">
													<input type="hidden" id="errorFlag" name="errorFlag" value="0">
												</table>
											</td></tr>
										</table>
									</td>
									<td valign="top" width="30%">
										<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
											<tr>
												<td align="center" valign="bottom"><input type="button" class="greybut" value="BACK" onclick="window.location.href ='cardTemplate?ct=<?php echo $cardType;?>&temp_id=<?php echo $template_id;?>';"></td>
												<td>
													<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
														<tr><td class="title" align="left" style="padding-left:55px">CARD PREVIEW</td></tr>
														<tr><td height="20"></td></tr>
														<tr><td>
															<div class="largepreview">
																<div class="top"></div>									
																<div class="midframe">
																	<div style="height:270px;background: #fff;width: 160px;margin:0 10px;">													
																		 <iframe src="<?php echo SITE_PATH; ?>preview?small=1<?php echo $iframe_dup; ?>" id="cardPreview" height="260" width="160"  border="0" frameborder="0" marginheight="0" marginwidth="0"  scrolling="no"  name="cardPreview" allowfullscreen="" frameborder="0" ></iframe>
																		<!-- <iframe src="<?php echo SITE_PATH; ?>preview?small=1<?php echo $iframe_dup; ?>" id="cardPreview" height="260" width="160"  border="0" frameborder="0" marginheight="0" marginwidth="0"  scrolling="no"  name="cardPreview" allowfullscreen="" frameborder="0" ></iframe> -->
																	</div>
																</div>
																<div class="bot"><img src="<?php echo IMAGE_PATH; ?>phone-hbottom.png"></div>
															</div>								
														</td></tr>
														<tr><td height="20"></td></tr>
														<tr><td align="center"><input type="button" class="greybut"  value="LARGE PREVIEW" onclick="largepreview('preview?<?php echo $iframe_dup; ?>');"></td></tr>
														<tr><td height="20"></td></tr>
														<tr><td align="center">
															<?php if(isset($_GET['editId']) && $_GET['editId'] != '') { ?>
																<input type="Hidden" id="card_id" name="card_id" value="<?php echo $_GET['editId']; ?>">
															<?php } ?>
															<input type="submit" id="cardSubmit" name="cardSubmit" class="yellowbut" value="SAVE AND CONTINUE" onclick="return validateCardCreation();">
														</td></tr>
													</table>
												</td>	
											</tr>
											
										</table>											
									</td>
								</tr>
							</table>
						</td></tr>
					</table>
					</form>
					</div>
					<!-- step -2 -->
				</div>
			<!-- Contact Details : Start -->
			</div>
		</div>
	</div>
	<!-- Content : End -->
	<div class="clearh"></div>
</div>
</div>
<div id="imageupload_popup" style="display:none">
	<div class="imageupload_outer imageupload_tkbox" style="display:block"></div>
	<div class="imageupload_inner imageupload_tkbox logo_thkbox" style="display:block ">
		<div class="imagedraggable" id="master" >
			<div class="imageheader">
				<h2>Upload a logo image</h2>
				<a href="javascript:void(0);" title="Close" onclick="closePopUp();"><img src="<?php echo IMAGE_BUTTON_PATH; ?>black_close.png" width="20" height="20" alt=""></a>
			</div>
			<div class="imagecontent">
				<div class="topgrey"></div>
			 	<div id="containment-wrapper1"></div>
				<div id="containment-wrapper" style="overflow:hidden;left:350px;">
					<img id="draggable3" src="" height="" width=""  style="cursor:move;z-index:10;" alt="">				
				</div>			
				<div class="botgrey"></div>
				<div class="leftgrey"></div> <!-- left div -->
				<div class="rightgrey"></div><!-- right div -->
			</div>
			<div class="imagefooter" style="position:relative;z-index:12">
				<a href="javascript:void(0);" title="CANCEL" class="greybut" onclick="closePopUp();">CANCEL</a>
				<a href="javascript:void(0);" title="SAVE" onclick="getValues();closePopUp(0);"  class="yellowbut">SAVE</a>
			</div>
		</div> 
		 <div style="position:relative;z-index:12;display:none;">
		 	<?php echo cropForm(); ?> 
		</div> 
	</div>
</div>
<?php 
	iframe();
	siteFooter(); 
// call siteFooter from template ?>
<script>
	var testpage=1;
</script>
<script src="<?php echo SCRIPT_PATH;?>jquery.ui.datepicker.js" type="text/javascript"></script>
<script>
$(function() {
	$("#requestMeeting").datepicker({
		dateFormat:'yy-mm-dd',
		showOn: "button",
		buttonImage: path+"WebResources/Images/common/cal_icon_small.png",
		buttonImageOnly: true,
		minDate:'today',
		onSelect: function()
		{
			var date_val = $('#requestMeeting').datepicker().val();
		}
	});
	$("#calender").datepicker({
		dateFormat:'yy-mm-dd',
		showOn: "button",
		buttonImage: path+"WebResources/Images/common/cal_icon_small.png",
		buttonImageOnly: true,
		minDate:'today',
		onSelect: function()
		{
			var date_val = $('#calender').datepicker().val();
		}
	});
	
});
</script>