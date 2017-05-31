<?php
	ob_start();
	if (!session_id()) session_start();
	if(!isset($_SESSION['tac_data']['user_id'])) {
		header("Location:home");
		die();
	}
	$_SESSION['create_page'] = 1;
	require_once('Controllers/CardTemplateController.php');
	$cardTemplateControllerObj 	= 	new CardTemplateController();
	require_once('Controllers/CardGroupsController.php');
	$cardGroupsControllerObj 	= 	new CardGroupsController();
	require_once('Controllers/DomainController.php');
	$domainControllerObj 	= 	new DomainController();
	/* variable declaration - begins	*/
	$card_id_array		= array();
	$hidden_groups_id	= '';
	$iframe_dup			= '';
	$contact_display	= '0';
	//$domain_name		= PRIMARY_DOMAIN;
	$contact_class_name	= array(
							"class"	=>	array('phone_no_icon',
											  'website_icon',
											  'email_icon', 
											  'sms_icon', 
											  'skype_icon', 
											  'add_contact_icon', 
											  'addlink_icon', 
											  'address_icon', 
											  'viber_icon'),
							"name"	=>	array('phoneNumberSelected', 
											  'websiteSelected', 
											  'emailSelected', 
											  'smsSelected', 
											  'skypeSelected', 
											  'addContactSelected', 
											  'addWeblinkSelected', 
											  'addressSelected', 
											  'viberSelected')
					  );
	$social_class_name	= array(
							"class"	=>	array('facebook_icon',
											  'twitter_icon',
											  'linkedin_icon', 
											  'blog_icon', 
											  'tumblr_icon', 
											  'cloud_icon', 
											  'youtube_icon', 
											  'google_plus_icon', 
											  'spotify_icon'),
							"name"	=>	array('facebookSelected', 
											  'twitterSelected', 
											  'linkedinSelected', 
											  'blogSelected', 
											  'tumblrSelected', 
											  'soundCloudSelected', 
											  'youTubeSelected', 
											  'googlePlusSelected', 
											  'spotifySelected')
					  );
	$utility_class_name	= array(
							"class"	=>	array('pro_icon',
											  'calen_icon',
											  'service_icon', 
											  'apple_store_icon', 
											  'share_icon', 
											  'request_icon', 
											  'ticket_icon', 
											  'google_play_icon'),
							"name"	=>	array('promotionSelected', 
											  'calenderSelected', 
											  'customerServiceSelected', 
											  'appStoreSelected', 
											  'shareFilesSelected', 
											  'requestMeetingSelected', 
											  'ticketsSelected', 
											  'playStoreSelected')
					  );
	$post_value	= array(
					   'buttonFormat'	  			=> 1,
					   'buttonStyle'	  			=> 1,
					   'mediaType'	  				=> '',
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
					   'headerColour'				=> '#FFFFFF'
		 				);
	/* variable declaration - ends	*/
	if(isset($_GET['ct']) && $_GET['ct'] != '')
		$type	=	$_GET['ct'];
	if($type > 5) {
		header("Location:homepage");
		die();
	}
	else
		$_SESSION['tac_data']['card_type'] = $type;
		
	if(isset($_POST['cardSubmit']) && $_POST['cardSubmit'] != '')
	{
		foreach($_POST as $key => $value)
		{
			$post_value[$key]	=	$value;
		}
		if(isset($_POST['templateId']) && $_POST['templateId'] != '')
		{
			$template_id			=	$_POST['templateId'];
			$updateTemplateDetails	=	$cardTemplateControllerObj->updateCardTemplate($post_value, $template_id);
		}
		else
		{
			$insertTemplateDetails	=	$cardTemplateControllerObj->insertCardTemplate($_POST);
			$template_id			=	$insertTemplateDetails;
		}
		$_SESSION['tac_data']['template_id'] = $template_id;
		if(isset($_POST['groupNameCheck']))
		{
			$group_id				=	$cardGroupsControllerObj->insertGroup($_POST['groupName']);
			$insertCardGroupsDetail	=	$cardGroupsControllerObj->insertCardGroupsDetail($template_id, $group_id);
		}
		if(!empty($_POST['groups'])) {
			if(isset($_POST['templateId']) && $_POST['templateId'] != '')
			{
				$template_id		=	$_POST['templateId'];
				$deleteGroups		=	$cardGroupsControllerObj->deleteCardGroups($template_id);
			}
			$groups_arr = array();
			foreach($_POST['groups'] as $checkVal) {
				$groups_arr[] = array(
								  'user_id'     => $_SESSION['tac_data']['user_id'],
								  'template_id' => $template_id,
								  'group_id'    => $checkVal);
			}
			$insertMultipleGroups	=	$cardGroupsControllerObj->insertMultipleCardGroups($groups_arr);
		}
		
		/*	Domain Details	- Begins	*/
		if(isset($_POST['domain_name']))
			$_SESSION['domain_name']	=	$_POST['domain_name'];
		else
			$_SESSION['domain_name']	=	0;
		/*	Domain Details	- Ends	*/
		
		$_SESSION['template_page'] = 1;
		if(isset($_POST['templateId']) && $_POST['templateId'] != '') {
			if(isset($_POST['cardId']) && $_POST['cardId'] != '')
				header("Location:createCard?editId=".$_POST['cardId']);
			else
				header("Location:createCard");
			die();
		}
		else {
			header("Location:createCard");
			die();
		}
	}
	else if(isset($_GET['temp_id']) && $_GET['temp_id'] != '')
	{
		$template_id	=	$_GET['temp_id'];
		$iframe_dup		=	'&temp_id='.$template_id;
		$field_array	=	$cardTemplateControllerObj->getSelectedOptions($template_id);
		$field_array	=	(array) $field_array;
		$cardId			=	$field_array[0]->card_id;
		$i = 0;
		foreach($field_array[0] as $key => $f_val)
		{
			$post_value[$key]	=	$f_val;
		}
		$post_value['cardOption']	=	1;
		$cardGroups		=	$cardGroupsControllerObj->getCardGroups($template_id);
		if(isset($cardGroups) && count($cardGroups) > 0 && is_array($cardGroups))
		{
			foreach($cardGroups as $key => $value) {
				array_push($card_id_array,$value->fkGroupId);
			}
			$hidden_groups_id	=	1;
		}
		$domain_name = $_SESSION['domain_name'];
	}
	$groups_array		=	$cardGroupsControllerObj->getGroups();
	
	//$domain_details = $domainControllerObj->getDomainDetails();
	$domain_details = $domainControllerObj->getUserDomainInfo($_SESSION['tac_data']['user_id']);
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
				<?php subNav($type); ?>
				<!-- Subnav : End -->
				<!-- Create Card : Start -->
				<div class="card_details">
					<!-- Step : 1  -->
					<div class="create_card cardTemplate" style="display:block;">
					<table cellpadding="1" cellspacing="0" border="0" align="center" width="100%" >
						<tr><td height="20"></td></tr>							
						<tr>
							<td width="70%" valign="top">
							<form id="cardTemplate" name="cardTemplate" method="post" action="" enctype="multipart/form-data">								
								<input type="hidden" id="cardType" name="cardType" value="<?php echo $type; ?>">
								<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
									<tr><td>
										<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
											<tr>
												<?php if($type == 5) { ?>
												<td valign="top">
													<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
														<tr><td height="10"></td></tr>
														<tr><td class="title">SELECT MEDIA</td></tr>
														<tr><td height="10"></td></tr>
														<tr><td height="10"></td></tr>
														<tr><td class="cardgroup">
															<div class="relative tag">
																<div class="dropdown" id="mediatag" onclick="openDropdownMenu('media_option');cancelEvent(event);">
																	SELECT MEDIA  <b>V</b>
																</div>
																<div class="dropdown_option media_option" style="display:none;">
																	<ul>
																		<li><a href="javascript:void(0);" title="SELECT MEDIA" onclick="mediaDropdown(this,''); cancelEvent(event);">SELECT MEDIA</a></li>
																		<?php 
																			if(isset($media_array) && count($media_array) > 0 && is_array($media_array)) {
																				foreach($media_array as $key => $media) {
																		?>
																		<li><a href="javascript:void(0);" title="<?php echo strtoupper($media); ?>" onclick="mediaDropdown(this,<?php echo $key; ?>); cancelEvent(event);"><?php echo strtoupper($media); ?></a></li>
																		<?php } } ?>
																	</ul>
																</div>
															</div>
															<input type="hidden" id="mediaType" name="mediaType" value="<?php echo $post_value['mediaType']; ?>">										
														</td></tr>
														<tr><td height="20"><div id="mediaType_msg" class="error_msg error_align" style="display:none;"></div></td></tr>
													</table>
												</td>
												<?php } ?>
												<td valign="top">
													<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
														<tr><td class="title">GROUPS</td></tr>
														<tr><td height="20"></td></tr>
														<tr><td>
															<div class="relative cardname">
																<div class="dropdown">
																	<input type="text" autocomplete="off" id="groupName" name="groupName" class="inputbox" placeholder="CREATE GROUP" value="<?php echo $post_value['groupName']; ?>">
																	<b><input validationmsg="Group Name" type="checkbox" id="groupNameCheck" name="groupNameCheck" <?php if ($post_value['groupNameCheck'] == 1) { ?> checked <?php } ?> value="1"><label ></label></b>
																</div>
																<div id="groupName_msg" class="error_msg error_align" style="display:none;"></div>
															</div>
														</td></tr>
														<tr><td height="10"></td></tr>
														<tr><td class="cardgroup">
															<div class="relative template">
																<div class="dropdown" id="assigntag" onclick="openDropdownMenu('group_option');cancelEvent(event);">
																	ASSIGN TAG TO GROUP <b>V</b>
																</div>
																<div class="dropdown_option group_option" style="display:none;">
																	<ul>
																	<?php 
																	if(isset($groups_array) && count($groups_array) > 0 && is_array($groups_array)) {
																	  foreach($groups_array as $x => $group) {
																	?>
																		<li><a href="javascript:void(0);" title="BUSINESS CARDS" onclick="cancelEvent(event);">
																			<b><?php echo strtoupper($group->groupName); ?></b>
																			<input type="Checkbox" class="groupChkbox" <?php if(in_array($group->fkGroupId, $card_id_array)) echo 'checked= "checked"';?> id="card_<?php echo $group->fkGroupId; ?>" name="groups[]" value="<?php echo $group->fkGroupId; ?>" onclick="assignGroupValue(this,this.value);cancelEvent(event);" />
																			<label></label>
																		</a></li>
																	<?php } } ?>
																	</ul>
																</div>
															</div>
															<input type="hidden" id="hidden_group" name="hidden_group" value="<?php echo $hidden_groups_id; ?>">										
														</td></tr>
														<tr><td height="20"><div id="existGroupName_msg" class="error_msg error_align" style="display:none;"></div></td></tr>
													</table>
												</td>
											</tr>
										</table>
									</td></tr>	
									<tr><td height="10"></td></tr>
									<tr><td class="title">SELECT CARD OPTIONS</td></tr>										
									<tr><td height="5"></td></tr>
									<tr><td>
										<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
											<tr><td height="20"></td><td align="center"><div id="cardOption_msg" class="error_msg error_align" style="display:none;text-align:center"></div></td></tr>
											<tr>
												<td width="15%" valign="top" class="cardoption">
													<?php
														if(isset($contact_options_array[$type]) && count($contact_options_array[$type])> 0) {
															$contact_display = '1';
													?>
													<a href="javascript:void(0);" title="CONTACT" class="sel" onclick="openCardOptions('contact',this);"><strong>CONTACT</strong></a><br><br>
													<?php } if(isset($social_options_array[$type]) && count($social_options_array[$type])> 0) {?>
													<a href="javascript:void(0);" title="SOCIAL" onclick="openCardOptions('social',this);" <?php if($contact_display == 0) { ?> class="sel" <?php } ?> ><strong>SOCIAL</strong></a><br><br>
													<?php }  if(isset($utility_options_array[$type]) && count($utility_options_array[$type])> 0) {?>
													<a href="javascript:void(0);" title="UTILITIES" onclick="openCardOptions('utility',this);"><strong>UTILITIES</strong></a>
													<?php } ?>
												</td>
												<td width="80%" valign="top">													
													<div id="contact_option" class="contact_card_opt" style="display:<?php if($contact_display == 1) echo 'block'; else echo 'none'; ?>">
														<ul>
															<?php 
																foreach($contact_options_array[$type] as $c_key => $c_value) {
																	$className = $contact_class_name['class'][$c_value-1];
																	$fieldName = $contact_class_name['name'][$c_value-1];
															?>
																	<li class="<?php echo $className; ?>">
																	<label class="label" for="<?php echo $fieldName; ?>"><?php echo $contact_array[$c_value]; ?></label>
																	<input param="1" id="<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" class="chk_box contact" type="checkbox" <?php if($post_value[$fieldName] == 1) { ?> checked <?php } ?> value="<?php echo $c_value; ?>" onclick="setIconToPreview('<?php echo $fieldName; ?>');"><label></label>
																	</li>
															<?php } ?>
														</ul>
													</div>
													<div id="social_option" class="contact_card_opt" style="display:<?php if($contact_display == 0) echo 'block'; else echo 'none'; ?>">
														<ul>
															<?php 
																foreach($social_options_array[$type] as $s_key => $s_value) {
																	$className = $social_class_name['class'][$s_value-1];
																	$fieldName = $social_class_name['name'][$s_value-1];
															 ?>
																	<li class="<?php echo $className; ?>">
																	<label class="label" for="<?php echo $fieldName; ?>"><?php echo $social_array[$s_value]; ?></label>
																	<input param="2" id="<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" class="chk_box social" type="checkbox" <?php if($post_value[$fieldName] == 1) { ?> checked <?php } ?> value="<?php echo $s_value; ?>" onclick="setIconToPreview('<?php echo $fieldName; ?>');" ><label></label></li>
															<?php } ?>
														</ul>
													</div>
													<div id="utility_option" class="contact_card_opt" style="display:none">
														<ul>
															<?php
																foreach($utility_options_array[$type] as $u_key => $u_value) {
																	$className = $utility_class_name['class'][$u_value-1];
																	$fieldName = $utility_class_name['name'][$u_value-1];
															?>
																	<li class="<?php echo $className; ?>">
																	<label class="label" for="<?php echo $fieldName; ?>"><?php echo $utilities_array[$u_value]; ?></label>
																	<input param="3" id="<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" class="chk_box utility" type="checkbox" <?php if($post_value[$fieldName] == 1) { ?> checked <?php } ?> value="<?php echo $u_value; ?>" onclick="setIconToPreview('<?php echo $fieldName; ?>');"><label></label></li>
															<?php } ?>
														</ul>
													</div>
													<input type="hidden" id="cardOption" name="cardOption" value="<?php echo $post_value['cardOption']; ?>">													
												</td>
											</tr>
										</table>										
									</td></tr>
									<tr><td height="30"></td></tr>
									<tr><td class="title">CARD LAYOUT</td></tr>										
									<tr><td height="20"></td></tr>
									<tr><td>
										<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" class="cardbut_style">
											<tr>
												<td valign="top" width="30%">
													<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
														<tr><td><strong>BUTTON FORMAT</strong></td></tr>
														<tr><td height="10"></td></tr>
														<tr><td>
															<a id="tile_button" class="tiles<?php if($post_value['buttonFormat'] == 1) echo '_sel'; else echo '';?>" href="javascript:void(0);" title="TILES" onclick="setButtonLayout(1);"></a>
															<a id="row_button" class="rows<?php if($post_value['buttonFormat'] == 2) echo '_sel'; else echo '';?>" href="javascript:void(0);" title="ROWS" onclick="setButtonLayout(2);"></a>
															<input type="hidden" id="buttonFormat" name="buttonFormat" value="<?php echo $post_value['buttonFormat']; ?>">
															<div id="buttonFormat_msg" class="error_msg error_align" style="display:none;"></div>
														</td></tr>
													</table>
												</td>
												<td valign="top" width="30%">
													<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
														<tr><td><strong>BUTTON STYLE</strong></td></tr>
														<tr><td height="10"></td></tr>
														<tr><td>
															<a id="steel_button" class="steel<?php if($post_value['buttonStyle'] == 1) echo '_sel'; else echo '';?>" href="javascript:void(0);" title="STEEL" onclick="setStyleLayout(1);"></a>
															<a id="rubber_button" class="rubber<?php if($post_value['buttonStyle'] == 2) echo '_sel'; else echo '';?>" href="javascript:void(0);" title="RUBBER" onclick="setStyleLayout(2);"></a>
															<input type="hidden" id="buttonStyle" name="buttonStyle" value="<?php echo $post_value['buttonStyle']; ?>">
															<div id="buttonStyle_msg" class="error_msg error_align" style="display:none;"></div>
														</td></tr>
													</table>
												</td>
												<td valign="top">
													<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
														<tr><td><strong>ICON BACKGROUND COLOUR</strong></td></tr>															
														<tr><td height="10"></td></tr>
														<tr><td>
															<input type="text" autocomplete="off" readonly="readonly" id="cardColour_1" name="cardColour_1" class="fleft selectbox" placeholder="CREATE" value="<?php echo $post_value['cardColour']; ?>" >
															<div id="colorDiv_1" class="preview preview_1" style="background-color: <?php echo $post_value['cardColour']; ?>" onclick="setColorPicker(1);"></div>
															<div class="relative" style="z-index:10">
						            							<div class="colorpicker colorpicker_1" style="display:none">
						                							<canvas class="picker" id="picker_1" var="1" width="150" height="170"></canvas>
						                							<div class="controls">
																		<img id="close" src="<?php echo IMAGE_BUTTON_PATH; ?>close.png" width="10" height="10" alt="close " class="close cancel_colorpicker">
						                    							<div><label>R</label> <input type="text" id="rVal_1" /></div>
						                    							<div><label>G</label> <input type="text" id="gVal_1" /></div>
						                    							<div><label>B</label> <input type="text" id="bVal_1" /></div>
						                    							<div><label>HEX</label> <input type="text" id="hexVal_1" /></div>
																		<div class="mbg_color"><span id="temp_preview_colorpicker_1" style="background-color:#CBCBCB"></span></div>
																		<div><input type="button" class="cancel_colorpicker" alt="CANCEL" value="CANCEL" name="cancel_colorpicker" id="cancel_colorpicker" />&nbsp;<input type="button" value="SAVE" alt="SAVE" class="save_colorpicker" name="save_colorpicker" id="save_colorpicker" /></div>
						                							</div>
						            							</div>	
															</div>
														</td></tr>
														<tr><td height="10"></td></tr>
														<tr>
															<td valign="top">
																<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
																	<tr><td><strong>HEADER/BACKGROUND COLOUR</strong></td></tr>
																	<tr><td height="10"></td></tr>
																	<tr><td>
																		<input type="text" autocomplete="off" readonly="readonly" id="cardColour_2" name="cardColour_2" class="fleft selectbox" placeholder="CREATE" value="<?php echo $post_value['headerColour']; ?>" >
																		<div id="colorDiv_2" class="preview preview_2" style="background-color: <?php echo $post_value['headerColour']; ?>" onclick="setColorPicker(2);"></div>
																		<div class="relative" style="z-index:10">
									            							<div class="colorpicker colorpicker_2" style="display:none">
									                							<canvas class="picker" id="picker_2" var="1" width="150" height="170"></canvas>
									                							<div class="controls">
																					<img id="close" src="<?php echo IMAGE_BUTTON_PATH; ?>close.png" width="10" height="10" alt="close " class="close cancel_colorpicker">
									                    							<div><label>R</label> <input type="text" id="rVal_2" /></div>
									                    							<div><label>G</label> <input type="text" id="gVal_2" /></div>
									                    							<div><label>B</label> <input type="text" id="bVal_2" /></div>
									                    							<div><label>HEX</label> <input type="text" id="hexVal_2" /></div>
																					<div class="mbg_color">
																						<span id="temp_preview_colorpicker_2" style="background-color:#CBCBCB"></span>
																					</div>
																					<div><input type="button" class="cancel_colorpicker" alt="CANCEL" value="CANCEL" name="cancel_colorpicker" id="cancel_colorpicker" />&nbsp;<input type="button" value="SAVE" alt="SAVE" class="save_colorpicker" name="save_colorpicker" id="save_colorpicker" /></div>
									                							</div>
									            							</div>	
																		</div>
																	</td></tr>										
																</table>
															</td>
														</tr>
													</table>
												</td>
												<!--  -->
												
												<!--  -->
											</tr>
										</table>
									</td></tr>
									<tr><td height="30"></td></tr>
									<tr>
										<td>
											<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
												<tr><td class="title">Tick check box to choose the domain</td><tr>
												<tr><td height="10"></td></tr>
												<tr><td><div id="domain_name_msg" class="error_msg error_align" style="display:none;"></div></td></tr>
												<?php  	
												if(isset($domain_details) && is_array($domain_details) && count($domain_details)>0){  
												  foreach($domain_details as $key=>$val){ 	?>
													<tr><td height="40px">
													  <label></label>
													  <input id="domain_name_<?php  echo $val->id;  ?>" name="domain_name" class="chk_box domain" type="checkbox" onclick="selectOnlyThis(this,document.cardTemplate.domain_name);" value="<?php  echo $val->id;  ?>" <?php if($domain_name == $val->id) echo 'checked= "checked"';?> />
													  <label class="label" for="domain_name_<?php  echo $val->id;  ?>">&nbsp;&nbsp;<?php  echo $val->name;  ?></label>
													</td></tr>
												<?php } }  ?>
										<!-- <input id="domain_name" name="domain_name" class="chk_box" type="checkbox" value="1"> -->
											</table>
										</td>
									</tr>
									
								</table>
							</td>
							
							<td valign="top" width="30%">
								<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
									<tr><td class="title" align="left" style="padding-left: 55px;">CARD PREVIEW</td></tr>
									<tr><td height="20"></td></tr>
									<tr><td>
										<div class="largepreview">
											<div class="top"></div>									
											<div class="midframe">
												<div style="height:270px;background: #fff;width: 160px;margin:0 10px;">													
													 <iframe src="<?php echo SITE_PATH; ?>preview?small=1<?php echo $iframe_dup; ?>" id="cardPreview" height="260" width="160"  border="0" frameborder="0" marginheight="0" marginwidth="0"  scrolling="no"  name="cardPreview" allowfullscreen="" frameborder="0" ></iframe>
												</div>
											</div>
											<div class="bot"><img src="<?php echo IMAGE_PATH; ?>phone-hbottom.png"></div>
										</div>								
									</td></tr>
									<tr><td height="20"></td></tr>
									<tr><td align="center"><input type="button" class="greybut"  value="LARGE PREVIEW" onclick="largepreview('preview?card=<?php echo $type; ?>');"></td></tr>
									<tr><td height="20"></td></tr>
									<tr><td align="center">
										<?php if(isset($_GET['temp_id']) && $_GET['temp_id'] != '') { ?>
											<input type="hidden" id="templateId" name="templateId" value="<?php echo $_GET['temp_id']; ?>">
											<input type="hidden" id="cardId" name="cardId" value="<?php echo $cardId; ?>">
										<?php } ?>
										<input type="hidden" id="selectedOptions" name="selectedOptions" value="<?php echo $post_value['selectedOptions']; ?>">
										<input type="hidden" id="hid_colorpicker" name="hid_colorpicker" value="0">
										<input type="hidden" id="errorFlag" name="errorFlag" value="0">
										<input type="submit" id="cardSubmit" name="cardSubmit" class="yellowbut" value="SAVE AND CONTINUE" onclick="return validateCardTemplate();">
									</td></tr>
								</table>
							</td>
						</tr>
					</form>
					</table>
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
<script>
	function selectOnlyThis(chkBox, field) {
	    for ( var i = 0; i < field.length; i++) {
	        field[i].checked = false;
	    }
	   chkBox.checked = true;
	}

	
	function openCardOptions(id,obj)
	{
		$('.sel').removeClass('sel');
		$('.contact_card_opt').hide();
		$('#'+id+'_option').show();
		$(obj).addClass('sel');
	}
	function setButtonLayout(value)
	{
		if(value == 1) {
			$('#tile_button').attr('class','').addClass('tiles_sel');
			$('#row_button').attr('class','').addClass('rows');
		}
		else {
			$('#tile_button').attr('class','').addClass('tiles');
			$('#row_button').attr('class','').addClass('rows_sel');
		}
		$('#buttonFormat').val(value);
		setIconImage();
	}
	function setStyleLayout(value)
	{
		if(value == 1) {
			$('#steel_button').attr('class','').addClass('steel_sel');
			$('#rubber_button').attr('class','').addClass('rubber');
		}
		else {
			$('#steel_button').attr('class','').addClass('steel');
			$('#rubber_button').attr('class','').addClass('rubber_sel');
		}
		$('#buttonStyle').val(value);
		setIconImage();
	}
	function setIconImage()
	{
		var format_type		= $('#buttonFormat').val();
		var style_type		= $('#buttonStyle').val();
		var iframe_tile		= $("#cardPreview").contents().find('#tileicon');
		var iframe_row		= $("#cardPreview").contents().find('#rowicon');
		var img_path;
		if(format_type != '' && style_type != '') {
			if(format_type == 1 && style_type == 1) {
				img_path = '<?php echo IMAGE_FOLDER_PATH_SITE;?>'+'tileicon/metal/';
			}
			else if(format_type == 1 && style_type == 2) {
				img_path = '<?php echo IMAGE_FOLDER_PATH_SITE;?>'+'tileicon/rubber/';
			}
			else if(format_type == 2 && style_type == 1) {
				img_path = '<?php echo IMAGE_FOLDER_PATH_SITE;?>'+'rowicon/metal/';
				iframe_row.attr('class','').addClass('metal');
			}
			else if(format_type == 2 && style_type == 2) {
				img_path = '<?php echo IMAGE_FOLDER_PATH_SITE;?>'+'rowicon/rubber/';
				iframe_row.attr('class','').addClass('rubber');
			}
			if(format_type == 1)
			{
				iframe_tile.show();
				iframe_row.hide();
				var iframe_icon = $("#cardPreview").contents().find('.imageicon');
				$(iframe_icon).each(function(i,variable){
					var img_src = $(this).attr('src');
					img_name_array = img_src.split('/');
					img_name = img_name_array[img_name_array.length-1];
					$(this).attr('src',img_path+img_name);
				}); 
			}
			else
			{
				iframe_row.show();
				iframe_tile.hide();
			}
		}
		window.frames[0].scrollbar();
	}
</script>
