<?php
	ob_start();
	if (!session_id()) session_start();
	if(!isset($_SESSION['tac_data']['user_id']))
		header("Location:home");
	if(!isset($_SESSION['tac_data']['cardId']) || !isset($_SESSION['designSticker']))
		header("Location:home");
	require_once('Controllers/CardDetailsController.php');
	$cardDetailsControllerObj 	= 	new CardDetailsController();
	require_once('Controllers/CardTemplateController.php');
	$cardTemplateControllerObj 	= 	new CardTemplateController();
	require_once('Controllers/CardGroupsController.php');
	$cardGroupsControllerObj 	= 	new CardGroupsController();
	
	/* variable declaration - begins*/
	$orderBy 			=	'order by cd.modifiedDate desc';
	$stickerstyle_val	=	'STICKER STYLE';
	$stickertype_val	=	'STICKER TYPE';
	$front_view			=	'FRONT';
	$cardPrice			=	'';
	$post_value			= array(
					   				'totalCards'	=> '',
									'stickerStyle'	=> '',
									'stickerType'	=> '',
									'totalPrice'	=> '',
									'shortUrl'		=> ''
					   			);
	$stick_img_name		=	'';
	$sticker_ext		=	'';
	/* variable declaration - ends	*/
	if(isset($_POST['stickerStyle']))
	{
		if(isset($_POST['sticker_img_name']) && $_POST['sticker_img_name'] != ''  ) {
			$sticker_img_array =	explode(".",$_POST['sticker_img_name']);
			$sticker_ext		=	end($sticker_img_array);
			$stick_img_name		=	getImageName($sticker_img_array[0]);
			$sticker_image		=	$_SESSION['tac_data']['cardId'].'.'.$sticker_ext;
			$temp_path	 	=  ABS_PATH.'WebResources/Images/temp/'.$_POST['sticker_img_name'];
			$sticker_Abspath	= 	ABS_IMAGE_PATH_STICKER.$sticker_image;
			copy($temp_path,$sticker_Abspath);
			$thumbPath		= ABS_IMAGE_PATH_STICKER.'thumb/'.$sticker_image;
			thumbnail($sticker_Abspath,$thumbPath,THUMB_IMAGE);
		}
		$update_sticker		= $cardDetailsControllerObj->updateStickerDesignDetails($_POST, $stick_img_name, $sticker_ext);
		$_SESSION['tac_data']['price']	= $_POST['totalPrice'];
		header("Location:homepage");
		die();
	}
	$fields			= '*';
	$condition		= '1';
	$tableName		= 'stickerType';
	$stickerType	= $cardDetailsControllerObj->getData($fields, $tableName, $condition);
	$tableName		= 'stickerStyle';
	$stickerStyle	= $cardDetailsControllerObj->getData($fields, $tableName, $condition);
	foreach($stickerStyle as $key => $val) {
		$stickerstyle_array[$key+1] = $val->styleName;
	}
	/* Dont Delete - For Edit */
	
	/*if(isset($_GET['id']) && $_GET['id'] != '')
	{
		$card_id	=	$_GET['id'];
		$_SESSION['tac_data']['cardId']	=	$card_id;
		$fields		=	'cd.id, cd.totalCards, cd.stickerStyle, cd.stickerType, cd.totalPrice, cd.shortUrl';
		$condition	=	'and cd.fkUserId = '.$_SESSION['tac_data']['user_id'].' and cd.checkoutStatus = 0 and cd.deletedStatus = 0 and cd.id = '.$_GET['id'];
		$listingDetails		=	$cardDetailsControllerObj->getCardDetails($fields, $condition, $orderBy);
		if(isset($listingDetails) && count($listingDetails[0]) > 0)
		{
			foreach($listingDetails[0] as $key => $val) {
				if($val == 0 && $key != 'shortUrl' && $key!= 'totalPrice')
					$val = '';
				$post_value[$key] = stripslashes($val);
			}
			$_SESSION['tac_data']['shorturl']	=	$post_value['shortUrl'];
			foreach($stickerStyle as $key => $val) {
				$stickerstyle_array[$key+1] = $val->styleName;
			}
			foreach($stickerStyle as $key => $val) {
				$stickertype_array[$key+1] = $val->typeName;
			}
			if($post_value['stickerStyle'] != '')
				$stickerstyle_val	= $stickerstyle_array[$post_value['stickerStyle']];
			if($post_value['stickerType'] != '')
				$stickertype_val	= $stickertype_array[$post_value['stickerType']];

			$front_path = ABS_IMAGE_PATH_DOWNLOAD.'sticker_'.$post_value['stickerStyle'].'_'.$post_value['stickerType'].'.jpg';
			if(file_exists($front_path))
				$front_view	= '<img src='.IMAGE_PATH_DOWNLOAD.'/sticker_'.$post_value['stickerStyle'].'_'.$post_value['stickerType'].'.jpg width="200" height="115" alt="">';
		}
		else
			header("Location:order");
	}*/
	/*if(isset($_GET['cardid'])  && $_GET['cardid'] != '')
	{
		$card_id 	= $_GET['cardid'];
		$fields 	= '*';
		$tableName = 'cardDetails';
		$condition = '1 and id = '.$card_id;
		$logoImage	= $cardDetailsControllerObj->getData($fields, $tableName, $condition);
		
		$logo_img_path = IMAGE_PATH_LOGO."".$card_id."".$logoImage;
	}*/
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
					<form id="stickerDesign" name="stickerDesign" method="post" action="" enctype="multipart/form-data">
						<table cellpadding="0" cellspacing="0" border="0" align="center" width="95%" style="padding-left: 40px">
							<tr><td height="20"></td></tr>							
							<tr>
								<td width="35%" valign="top">
									<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
										<tr><td class="title">DESIGN STICKER</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td>
											<div class="relative cardstyle" onclick="openDropdownMenu('stickerstyle_option');cancelEvent(event);">
												<div class="dropdown" id="stickerstyle">
													<?php echo strtoupper($stickerstyle_val); ?>
													<b>v</b>
												</div>
												<div class="dropdown_option stickerstyle_option" style="display: none">
													<ul>
													<?php if(isset($stickerStyle) && is_array($stickerStyle) && count($stickerStyle) > 0 ) { ?>
													<li><a href="javascript:void(0);" title="STICKER STYLE" onclick="stickerDropdown(this,'stickerstyle','','stickerStyle','c_style');">STICKER STYLE</a></li>
													<?php foreach($stickerStyle as $key => $value) { ?>
													<li><a href="javascript:void(0);" title="<?php echo strtoupper($value->styleName); ?>" onclick="stickerDropdown(this,'stickerstyle',<?php echo $key+1; ?>,'stickerStyle','c_style');"><?php echo strtoupper($value->styleName); ?></a></li>
													<?php } } ?>
													</ul>	
												</div>
											</div>
											<input type="hidden" id="stickerStyle" name="stickerStyle" value="<?php echo $post_value['stickerStyle']; ?>">
											<div id="stickerStyle_msg" class="error_msg" style="display:none;"></div>
										</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td align="left">
										<input type="button" class="greybut" value="DOWNLOAD QR CODE" onclick="window.location.href='<?php echo SITE_PATH; ?>Views/download.php?url=<?php echo SITE_PATH ?><?php echo $_SESSION['tac_data']['shorturl']; ?>&image_name=<?php echo $_SESSION['tac_data']['shorturl'].'.png'; ?>'">
										</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td>
											<div class="relative cardtype" onclick="openDropdownMenu('stickertype_option');cancelEvent(event);">
												<div class="dropdown" id="stickertype">
													<?php echo strtoupper($stickertype_val); ?>
													<b>v</b>
												</div>
												<div class="dropdown_option stickertype_option" style="display:none;">
													<ul>
													<?php if(isset($stickerType) && is_array($stickerType) && count($stickerType) > 0 ) { ?>
													<li><a href="javascript:void(0);" title="STICKER TYPE" onclick="stickerDropdown(this,'stickertype','','stickerType','c_type');">STICKER TYPE</a></li>
													<?php foreach($stickerType as $key => $val) { ?>
													<li><a href="javascript:void(0);" title="<?php echo strtoupper($val->typeName) ; ?>" onclick="stickerDropdown(this,'stickertype',<?php echo $key+1; ?>,'stickerType','c_type');"><?php echo strtoupper($val->typeName) ; ?></a></li>
													<?php } } ?>
													</ul>	
												</div>
											</div>
											<input type="hidden" id="stickerType" name="stickerType" value="<?php echo $post_value['stickerType']; ?>">
										<div id="stickerType_msg" class="error_msg" style="display:none;"></div>
										</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td>Upload a Sticker Artwork</td></tr>
										<tr><td height="10"></td></tr>
										<tr><td>
										<a href="javascript:void(0);" title="Download Card Template" class="download"><em>Download Sticker Size Template</em></a>
										<!-- <a href="javascript:void(0);" title="Download Card Template" class="download" onclick="window.location.href='<?php //echo SITE_PATH; ?>Views/download.php?file=card.jpg'"><em>Download Card Template</em></a> -->
										</td></tr>
										<tr><td height="10"></td></tr>
										<tr><td height="25" valign="top">
											<div class="relative" id="sticker_upload" style="display:block;">
												<input type="file" class="file_photo" onchange="ajaxfileUpload('stickerDesign','image7',7)" id="image7" name="image7">
												<span class="fakefile_photo">
													<input type="text" value="" class="browsebut">
												</span>
											</div>
											<div id="sticker_image" style="display:none;"></div>
											<input type="hidden" id="sticker_img_name" name="sticker_img_name" value="" />
											<input type="hidden" id="img_type" name="img_type" value="" />
										</td></tr>										
									</table>
								</td>
								<td valign="top" width="25%">
									<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
										<tr><td class="title" align="center">CARD PREVIEW</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td>
											<div class="cardpreview frontview"><?php echo $front_view; ?></div>
										</td></tr>
										<tr><td height="5"></td></tr>
										<tr><td>FRONT</td></tr>
										<tr><td height="10"></td></tr>
										<tr><td align="center"><input type="button" class="greybut"  value="LARGE PREVIEW" ></td></tr>
									</table>
								</td>
								<td valign="top" width="40%">
									<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="padding-left: 50px;">
										<tr><td class="title" align="center">QUANTITY</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td>
											SELECT THE NUMBER OF CARDS YOU WOULD LIKE TO ORDER
										</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td class="orderoption">
											<table cellpadding="0" cellspacing="0" border="0" align="center" width="80%">
												<tr>
													<td><input type="radio" name="quantity" id="quantity1" <?php if($post_value['totalCards'] == 150) { ?> checked <?php } ?> value="150" onclick="addToquantity(this,2);"><label for="quantity1">150</label></td>
												</tr>
												<tr><td height="10"></td></tr>
												<tr>
													<td><input type="radio" name="quantity" value="250" <?php if($post_value['totalCards'] == 250) { ?> checked <?php } ?> id="quantity2" onclick="addToquantity(this,2);"><label for="quantity2">250</label></td>
												</tr>
												<tr><td height="10"></td></tr>
												<tr>
													<td><input type="radio" name="quantity" value="500" <?php if($post_value['totalCards'] == 500) { ?> checked <?php } ?> id="quantity3"  onclick="addToquantity(this,2);"><label for="quantity3">500</label></td>
												</tr>
												<tr><td height="10"></td></tr>
												<tr>
													<td><input type="radio" name="quantity" value="1000" <?php if($post_value['totalCards'] == 1000) { ?> checked <?php } ?> id="quantity4"  onclick="addToquantity(this,2);"><label for="quantity4">1000</label></td>
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
												<span id="c_count"></span>
												<span id="c_style"></span><br>
												<span style="display:none" id="c_size">15cm X 30cm</span>
											</span>
											<strong id="tamount" class="tamount"></strong>
										<?php } else { ?>
											<span>
												<span id="c_count"></span>
												<span id="c_style"></span><br>
												<span style="display:none" id="c_size">15cm X 30cm</span>
											</span>
											<strong id="tamount" class="tamount"></strong>
										<?php } ?>
											<input type="hidden" id="totalPrice" name="totalPrice" value="<?php echo $post_value['totalPrice']; ?>">
										</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td align="center"><a href="javascript:void(0);" class="yellowbut" title="ORDER NOW" onclick="return validateStickerDesign();">ORDER NOW</a></td> </tr>
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
	<div class="clearh"></div>
</div>
<?php
	siteFooter(); // call siteFooter from template
	iframe();
?>
