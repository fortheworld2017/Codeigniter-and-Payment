<?php
	ob_start();
	if (!session_id()) session_start();
	if(!isset($_SESSION['tac_data']['user_id']))
		header("Location:home");
	if(!isset($_SESSION['tac_data']['cardId']) || !isset($_SESSION['designTag']))
		header("Location:home");
	require_once('Controllers/CardDetailsController.php');
	$cardDetailsControllerObj 	= 	new CardDetailsController();
	require_once('Controllers/CardTemplateController.php');
	$cardTemplateControllerObj 	= 	new CardTemplateController();
	require_once('Controllers/CardGroupsController.php');
	$cardGroupsControllerObj 	= 	new CardGroupsController();
	
	/* variable declaration - begins*/
	$orderBy 			=	'order by cd.modifiedDate desc';
	$cardPrice			=	'';
	$tagSize_val		=	'TAG SIZE';
	$post_value			= array(
					   				'totalCards'	=> '',
									'totalPrice'	=> '',
									'tagSize'		=> ''
					   			);
	/* variable declaration - ends	*/
	if(isset($_POST['tagSize']))
	{
		$update_sticker		= $cardDetailsControllerObj->updateTagDesignDetails($_POST);
		$_SESSION['tac_data']['price']	= $_POST['totalPrice'];
		header("Location:homepage");
		die();
	}
	if(isset($_SESSION['tac_data']['cardType']))
		$cardType = $_SESSION['tac_data']['cardType'];
	else
		$cardType = 1;
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
					<!-- step -2 -->
					<div id="" class="design_card" style="display:block">
					<form id="tagDesignForm" name="tagDesignForm" method="post" action="" enctype="multipart/form-data">
						<table cellpadding="0" cellspacing="0" border="0" align="center" width="95%" style="padding-left: 40px">
							<tr><td height="20"></td></tr>							
							<tr>
								<td width="35%" valign="top">
									<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
										<tr><td class="title">ORDER TAGS</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td>
											<div class="relative cardstyle" onclick="openDropdownMenu('stickerstyle_option');cancelEvent(event);">
												<div class="dropdown" id="orderTag">
													<?php echo strtoupper($tagSize_val); ?>
													<b>v</b>
												</div>
												<div class="dropdown_option stickerstyle_option" style="display: none">
													<ul>
													<?php if(isset($tagsize_array) && is_array($tagsize_array) && count($tagsize_array) > 0 ) { ?>
													<li><a href="javascript:void(0);" title="TAG SIZE" onclick="tagsDropdown(this);">TAG SIZE</a></li>
													<?php foreach($tagsize_array as $key => $value) { ?>
													<li><a href="javascript:void(0);" title="<?php echo strtoupper($value); ?>" onclick="tagsDropdown(this,<?php echo $key; ?>);"><?php echo strtoupper($value); ?></a></li>
													<?php } } ?>
													</ul>	
												</div>
											</div>
											<input type="hidden" id="tagSize" name="tagSize" value="<?php echo $post_value['tagSize']; ?>">
											<div id="tagSize_msg" class="error_msg" style="display:none;"></div>
										</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td align="left">
										<input type="button" class="greybut" value="DOWNLOAD QR CODE" onclick="window.location.href='<?php echo SITE_PATH; ?>Views/download.php?url=<?php echo SITE_PATH ?><?php echo $_SESSION['tac_data']['shorturl']; ?>&image_name=<?php echo $_SESSION['tac_data']['shorturl'].'.png'; ?>'">
										</td></tr>
									</table>
								</td>
								<td valign="top" width="40%">
									<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="padding-left: 50px;">
										<tr><td class="title" align="center">QUANTITY</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td>
											SELECT THE NUMBER OF CARDS <br>YOU WOULD LIKE TO ORDER
										</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td class="orderoption">
											<table cellpadding="0" cellspacing="0" border="0" align="center" width="80%">
												<tr>
													<td><input type="radio" name="quantity" id="quantity1" <?php if($post_value['totalCards'] == 150) { ?> checked <?php } ?> value="150" onclick="addToquantity(this,3);"><label for="quantity1">150</label></td>
												</tr>
												<tr><td height="10"></td></tr>
												<tr>
													<td><input type="radio" name="quantity" value="250" <?php if($post_value['totalCards'] == 250) { ?> checked <?php } ?> id="quantity2" onclick="addToquantity(this,3);"><label for="quantity2">250</label></td>
												</tr>
												<tr><td height="10"></td></tr>
												<tr>
													<td><input type="radio" name="quantity" value="500" <?php if($post_value['totalCards'] == 500) { ?> checked <?php } ?> id="quantity3"  onclick="addToquantity(this,3);"><label for="quantity3">500</label></td>
												</tr>
												<tr><td height="10"></td></tr>
												<tr>
													<td><input type="radio" name="quantity" value="1000" <?php if($post_value['totalCards'] == 1000) { ?> checked <?php } ?> id="quantity4"  onclick="addToquantity(this,3);"><label for="quantity4">1000</label></td>
												</tr>
											</table>
											<input type="hidden" id="totalCards" name="totalCards" value="<?php echo $post_value['totalCards']; ?>">
											<div id="totalCards_msg" class="error_msg" style="display:none;"></div>											
										</td></tr>										
										<tr><td height="20"></td></tr>
										<tr><td class="title" align="center">TOTAL</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td class="tamount">
										<?php if(isset($_GET['id']) && $_GET['id'] != '') { ?>
											<span>
												<span id="c_count"></span><span id="c_type"></span><br>
												<span id="c_style"></span>
												<span style="display:none" id="c_size">15cm X 30cm</span>
											</span>
											<strong id="tamount" class="tamount"></strong>
										<?php } else { ?>
											<span>
												<span id="c_count"></span><span id="c_type"></span><br>
												<span id="c_style"></span>
												<span style="display:none" id="c_size">15cm X 30cm</span>
											</span>
											<strong id="tamount" class="tamount"></strong>
										<?php } ?>
											<input type="hidden" id="totalPrice" name="totalPrice" value="<?php echo $post_value['totalPrice']; ?>">
										</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td align="center"><a href="javascript:void(0);" class="yellowbut" title="ORDER NOW" onclick="return validateTagDesignForm();">ORDER NOW</a></td> </tr>
									</table>
								</td>
							</tr>
							<tr><td height="30"><input type="hidden" id="errorFlag" name="errorFlag" value="0"></td></tr>
						</table>
						</form>
					</div>
				</div>
				<!-- Contact Details : Start -->
			</div>
		</div>
	</div>
	<!-- Content : End -->
	
	<!-- Footer : Start -->
	<div class="Footer">
		
	</div>
	<!-- Footer : End -->
	<div class="clearh"></div>
</div>
<?php
	siteFooter(); // call siteFooter from template
	iframe();
?>
