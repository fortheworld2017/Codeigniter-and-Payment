<?php
	ob_start();
	if (!session_id()) session_start();
	if(!isset($_SESSION['tac_data']['user_id']))
		header("Location:home");
	$_SESSION['create_page'] = 1;
	require_once('Controllers/CardDetailsController.php');
	$cardDetailsControllerObj 	= 	new CardDetailsController();
	require_once('Controllers/MonitorController.php');
	$MonitorControllerObj 		= new MonitorController();
	/*	variable declaration - begins	*/
	$total_site_visits = 0;
	/*	variable declaration - ends	*/
	
	$field		=	"*, DATE_FORMAT( browsedDate,'%m' ) as month ,DATE_FORMAT(browsedDate,'%H') as bTime";
	$condition	=	" and fkUserId = ? ";
	$getSiteDetails	= $MonitorControllerObj->getSiteVisitDetail($field,$condition, array($_SESSION['tac_data']['user_id']));
	if(isset($getSiteDetails) && is_array($getSiteDetails) && count($getSiteDetails) > 0) {
		$total_site_visits = count($getSiteDetails);
		foreach($getSiteDetails as $key => $value)
		{
			$time_visit_array[]		= $value->bTime;
			$browser_visit_array[]	= $value->browser;
		}
	}
	if(isset($browser_visit_array) && count($browser_visit_array) >0 )
	{
		$browser_visit_array = array_count_values($browser_visit_array);
		ksort($browser_visit_array);
		$total_browser = array_sum($browser_visit_array);
	}
	
	if(isset($time_visit_array) && count($time_visit_array) >0 )
	{
		$time_visit_array = array_count_values($time_visit_array);
		krsort($time_visit_array);
		$total_visits = array_sum($time_visit_array);
	}
	$field		=	"sum(phoneNumber) as phoneNumber, sum(website) as website, sum(email) as email, sum(sms) as sms, sum(skype) as skype, sum(addContact) as addContact, sum(addWeblink) as addWeblink, sum(address) as address, sum(viber) as viber, sum(facebook) as facebook, sum(twitter) as twitter, sum(linkedin) as linkedin,	sum(blog) as blog,	sum(tumblr) as tumblr,	sum(soundCloud) as soundCloud,	sum(youTube) as youTube, sum(googlePlus) as googlePlus,	sum(spotify) as spotify, sum(promotion) as promotion, sum(calender) as calender,sum(customerService) as customerService, sum(appStore) as appStore, sum(shareFile) as shareFile, sum(requestMeeting) as requestMeeting, sum(tickets) as tickets, sum(playStore) as playStore";
	$condition	=	" and fkUserId = ? ";
	$exitClickDetails	= $MonitorControllerObj->getexitClickDetails($field,$condition, array($_SESSION['tac_data']['user_id']));
	if(isset($exitClickDetails) && is_array($exitClickDetails) && count($exitClickDetails) > 0) {
		foreach($exitClickDetails[0] as $key => $value) {
			$exit_click_array[$key]	=	$value;
		}
		$total_clicks = array_sum($exit_click_array);
		if($total_clicks == 0)
			$total_clicks = 1;
		arsort($exit_click_array);
	}
	$interactionDetails		= $MonitorControllerObj->getInteractionDetails();
	$recentActivityDetails	= $cardDetailsControllerObj->getRecentActivityDetails();
?>

	<?php siteHeader(); ?>
	<!-- Content : Start -->
	<div class="Bodycontent">
		<!-- Left nav : Start -->
		<?php leftNav();?>
		<!-- Left nav : End -->
		<div class="inner_container">
			<!-- Breadcrum : Start -->
			<?php breadCrumb();?>
			<!-- Breadcrum : End -->
			<div class="content">
				<!-- Create Card : Start -->
				<div class="card_details">
					<!-- Step : 1  -->
					<div class="graphs" style="width:950px">
						<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
							<tr>
								<td width="33%" valign="top">
									<table cellpadding="0" cellspacing="0" align="left" width="100%">
										<tr><td class="title" align="center" colspan="2">ANALYTICS OVERVIEW</td></tr>
										<tr><td height="15"></td></tr>
										<tr>
											<td align="center" valign="top">
												<div class="overview_block time_part">
													<h3>TOTAL SITE VISITS</h3>
													<span><?php echo $total_site_visits; ?></span>
													<!-- <ul>
														<li><span class="or_txt">00:00</span><span class="or_value">22%</span></li>
														<li><span class="or_txt">01:00</span><span class="or_value">25%</span></li>
														<li><span class="or_txt">02:00</span><span class="or_value">33%</span></li>
														<li><span class="or_txt">03:00</span><span class="or_value">43%</span></li>
													</ul> -->
												</div>
											</td>
											<td align="center">
												<div class="overview_block">
													<h3>BROWSERS</h3>
													<ul>
														<?php foreach($browser_name_array as $key=>$value) { ?>
														<li>
															<span class="or_txt"><?php echo $value; ?></span>
															<span class="or_value">
																<?php
																	if(isset($browser_visit_array[$key])) {
																		$ios = ($browser_visit_array[$key]/$total_browser)*100;
																		echo number_format((float) $ios, 2, '.', '').'%';
																	}
																	else
																		echo '0%'
																?>
															</span>
														</li>
														<?php } ?>
														<!-- <li><span class="or_txt">ANDROID</span><span class="or_value">25%</span></li>
														<li><span class="or_txt">WINDOWS</span><span class="or_value">33%</span></li>
														<li><span class="or_txt">OTHER</span><span class="or_value">43%</span></li> -->
													</ul>
												</div>
											</td>
										</tr>
										<tr><td height="15"></td></tr>
										<tr>
											<td align="center">
												<div class="overview_block time_part">
													<h3>TIME OF VISIT</h3>
													<ul>
														<?php
															$j = 0;
															if(isset($time_visit_array) && count($time_visit_array) >0 ) {
																foreach($time_visit_array as $key => $value) {
																	$j++;
																	$perc = ($value/$total_visits)*100;
																	if($j <= 4) {
																?>
																<li><span class="or_txt"><?php  echo timeFormat($key); ?></span><span class="or_value"><?php echo number_format((float) $perc, 2, '.', '').'%'; ?></span></li>
																<?php
																	}
																}
															}
														?>
														<!-- <li><span class="or_txt">00:00</span><span class="or_value">22%</span></li>
														<li><span class="or_txt">01:00</span><span class="or_value">25%</span></li>
														<li><span class="or_txt">02:00</span><span class="or_value">33%</span></li>
														<li><span class="or_txt">03:00</span><span class="or_value">43%</span></li> -->
													</ul>
												</div>
											</td>
											<td align="center">
												<div class="overview_block">
													<h3>EXIT CLICKS</h3>
													<ul>
														<?php
															$i = 0;
															foreach($exit_click_array as $key => $value) {
																if($key == 'phoneNumber') $key = 'Phone number';
																elseif($key == 'addContact') $key = 'Add contact';
																elseif($key == 'addWeblink') $key = 'Add Weblink';
																elseif($key == 'requestMeeting') $key = 'Request meeting';
																elseif($key == 'playStore') $key = 'Play store';
																elseif($key == 'googlePlus') $key = 'Google plus';
																$i++;
																$perc = ($value/$total_clicks)*100;
																if($i <= 4) {
														?>
															<li><span class="or_txt"><?php echo strtoupper($key); ?></span><span class="or_value"><?php echo number_format((float) $perc, 2, '.', '').'%'; ?></span></li>
														<?php } } ?>
														<!-- <li><span class="or_txt">FACEBOOK</span><span class="or_value">22%</span></li>
														<li><span class="or_txt">WEBSITE</span><span class="or_value">25%</span></li>
														<li><span class="or_txt">TWITTER</span><span class="or_value">33%</span></li>
														<li><span class="or_txt">OTHER</span><span class="or_value">43%</span></li> -->
													</ul>
												</div>
											</td>
										</tr>
										<tr><td height="15"></td></tr>
										<tr>
											<td colspan="2" align="center">
												<div class="or_blk_bg">
													<h3>HIGHEST NUMBER OF INTERACTIONS</h3>
													<ul>
														<?php if(isset($interactionDetails) && is_array($interactionDetails) && count($interactionDetails) > 0) {
																foreach($interactionDetails as $key => $value) {
														?>
														<li>
															<img src="<?php echo IMAGE_PATH; ?>small_icon_<?php echo $value->cardType; ?>.png" width="26" height="19" alt="">
															<span><?php echo strtoupper($value->company); ?></span>
															<p><?php echo $value->points; ?></p>
														</li>
														<?php } } ?>
													</ul>
												</div>
											</td>
										</tr>
									</table>
								</td>
								<td width="67%" align="center" valign="top">
									<table border="0" cellpadding="0" cellspacing="0" align="center" class="recent_activity" width="95%">
										<tr><td class="title">RECENT ACTIVITY</td></tr>
										<tr><td height="15"></td></tr>
										<tr>
											<td>
												<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
													<?php
														if(isset($recentActivityDetails) && is_array($recentActivityDetails) && count($recentActivityDetails) > 0) {
															foreach($recentActivityDetails as $r_key => $r_value) {
																if($r_key %2 == 0)
																	$class = 'row1';
																else
																	$class = 'row';
													?>
													<tr class="<?php echo $class; ?>">
														<td width="10%"><img src="<?php echo IMAGE_PATH; ?>small_icon_<?php echo $r_value->cardType; ?>.png" width="20" height="16" alt=""></td>
														<td width="20%"><?php echo strtoupper($r_value->cardName); ?></td>
														<td width="53%" align="center"><?php echo strtoupper($r_value->activity); ?></td>
														<td width="17%" align="left"><?php echo dashboardDateFormat($r_value->date); ?></td>
													</tr>
													<?php } } else { ?>
														<tr class="row1"><td align="center" colspan="4" style="color:red;"> No Recent activities found</td></tr>
													<?php } ?>
													<!-- <tr class="row">
														<td><img src="<?php echo IMAGE_PATH; ?>small_icon_2.png" width="20" height="16" alt=""></td>
														<td>[NAME OF STICKER]</td>
														<td align="center">[EDITED/CREATED]</td>
														<td>[DATE]</td>
													</tr> -->
													<!-- <tr class="row1">
														<td><img src="<?php echo IMAGE_PATH; ?>small_icon_3.png" width="22" height="17" alt=""></td>
														<td>[NAME OF CAMAIGN]</td>
														<td align="center">[EDITED/CREATED]</td>
														<td></td>
													</tr> -->
													<!-- <tr class="row">
														<td><img src="<?php echo IMAGE_PATH; ?>small_icon_4.png" width="22" height="22" alt=""></td>
														<td>[NAME OF PROMOTION]</td>
														<td align="center">[EDITED/CREATED]</td>
														<td>[DATE]</td>
													</tr> -->
													<!-- <tr class="row1">
														<td><img src="<?php echo IMAGE_PATH; ?>small_icon_5.png" width="26" height="19" alt=""></td>
														<td>[NAME OF EVENT]</td>
														<td align="center">EVENT DATE CHANGED TO 7PM 12/03/13	</td>
														<td>[DATE]</td>
													</tr> -->
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
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
	function openCardOptions(id)
	{
		$('.contact_card_opt').hide();
		$('#'+id+'_option').show();
	}
</script>
