<?php
	ob_start();
	if (!session_id()) session_start();
	if(!isset($_SESSION['tac_data']['user_id'])) {
		header("Location:home");
		die();
	}
	if(!isset($_SESSION['tac_data']['cardId']) || !isset($_SESSION['designCard'])) {
		header("Location:home");
		die();
	}
	require_once('Controllers/CardDetailsController.php');
	$cardDetailsControllerObj 	= 	new CardDetailsController();
	require_once('Controllers/CardTemplateController.php');
	$cardTemplateControllerObj 	= 	new CardTemplateController();
	require_once('Controllers/CardGroupsController.php');
	$cardGroupsControllerObj 	= 	new CardGroupsController();
	
	$domainUrl  = $cardDetailsControllerObj->getCardDomain($_SESSION['tac_data']['shorturl']);
	
	
	/* variable declaration - begins*/
	$orderBy 			=	'order by cd.modifiedDate desc';
	$cardstyle_val		=	'CARD STYLE';
	$cardtype_val		=	'CARD TYPE';
	$front_view			=	'FRONT';
	$back_view			=	'BACK';
	$cardPrice			=	'';
	$post_value			= array(
					   				'totalCards'	=> '',
									'cardStyle'		=> '',
									'cardType'		=> '',
									'totalPrice'	=> '',
									'shortUrl'		=> ''
					   			);
	/* variable declaration - ends	*/
	if(isset($_POST['cardStyle']))
	{
		if(isset($_POST['card_img_name']) && $_POST['card_img_name'] != ''  ) {
			$card_img_array =	explode(".",$_POST['card_img_name']);
			$card_ext		=	end($card_img_array);
			$card_image		=	$_SESSION['tac_data']['cardId'].'.'.$card_ext;
			$temp_path	 	=  ABS_PATH.'WebResources/Images/temp/'.$_POST['card_img_name'];
			$card_Abspath	= 	ABS_IMAGE_PATH_CARD.$card_image;
			copy($temp_path,$card_Abspath);
			$thumbPath		= ABS_IMAGE_PATH_CARD.'thumb/'.$card_image;
			thumbnail($card_Abspath,$thumbPath,THUMB_IMAGE);
		}
		$update_card		= $cardDetailsControllerObj->updateCardDesignDetails($_POST);
		$_SESSION['tac_data']['price']	= $_POST['totalPrice'];
		//header("Location:checkout?id=".$_GET['id']);
		header("Location:homepage");
		die();
	}
	$fields		= '*';
	$condition	= '1';
	$tableName	= 'cardType';
	$cardType	= $cardDetailsControllerObj->getData($fields, $tableName, $condition);
	$tableName	= 'cardStyle';
	$cardStyle	= $cardDetailsControllerObj->getData($fields, $tableName, $condition);

	/* Dont Delete - For Edit */
	
	/*if(isset($_GET['id']) && $_GET['id'] != '')
	{
		$card_id	=	$_GET['id'];
		$_SESSION['tac_data']['cardId']	=	$card_id;
		$fields		=	'cd.id, cd.totalCards, cd.cardStyle, cd.cardType, cd.totalPrice, cd.shortUrl';
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
			//foreach($cardType as $key => $cardVal) {
				//if($cardVal->id == $post_value['cardType'])
					//$cardPrice = $cardVal->price;
			//}
			if($post_value['cardStyle'] != '')
				$cardstyle_val	= $cardstyle_array[$post_value['cardStyle']];
			if($post_value['cardType'] != '')
				$cardtype_val	= $cardtype_array[$post_value['cardType']];

			$front_path = ABS_IMAGE_PATH_DOWNLOAD.'front'.$post_value['cardStyle'].'_'.$post_value['cardType'].'.jpg';
			$back_path = ABS_IMAGE_PATH_DOWNLOAD.'back'.$post_value['cardStyle'].'_'.$post_value['cardType'].'.jpg';
			if(file_exists($front_path))
				$front_view	= '<img src='.IMAGE_PATH_DOWNLOAD.'/front'.$post_value['cardStyle'].'_'.$post_value['cardType'].'.jpg width="200" height="115" alt="">';
			if(file_exists($back_path))
				$back_view	= '<img src='.IMAGE_PATH_DOWNLOAD.'/back'.$post_value['cardStyle'].'_'.$post_value['cardType'].'.jpg width="200" height="115" alt="">';
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
		$card_type = $_SESSION['tac_data']['cardType'];
	else
		$card_type = 1;
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
				<?php subNav($card_type); ?>
				<!-- Subnav : End -->
				<!-- Create Card : Start -->
				<div class="card_details">
					<!-- step -2 -->
					<div id="editDesign" class="design_card" style="display:block">
					<form id="cardDesign" name="cardDesign" method="post" action="" enctype="multipart/form-data"><!-- checkout -->
						<table cellpadding="0" cellspacing="0" border="0" align="center" width="95%" style="padding-left: 40px">
							<tr><td height="20"></td></tr>							
							<tr>
								<td width="35%" valign="top">
									<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
										<tr><td class="title">DESIGN CARD</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td>
											<div class="relative cardstyle" onclick="openDropdownMenu('cardstyle_option');cancelEvent(event);">
												<div class="dropdown" id="cardstyle">
													<?php echo strtoupper($cardstyle_val); ?>
													<b>v</b>
												</div>
												<div class="dropdown_option cardstyle_option" style="display: none">
													<ul>
													<?php if(isset($cardStyle) && is_array($cardStyle) && count($cardStyle) > 0 ) { ?>
													<li><a href="javascript:void(0);" title="CARD STYLE" onclick="addToDropdown(this,'cardstyle','','cardStyle','c_style');">CARD STYLE</a></li>
													<?php foreach($cardStyle as $key => $value) { ?>
													<li><a href="javascript:void(0);" title="<?php echo $value->styleName; ?>" onclick="addToDropdown(this,'cardstyle',<?php echo $key+1; ?>,'cardStyle','c_style');"><?php echo $value->styleName; ?></a></li>
													<?php } } ?>
													</ul>	
												</div>
											</div>
											<input type="hidden" id="cardStyle" name="cardStyle" value="<?php echo $post_value['cardStyle']; ?>">
											<div id="cardStyle_msg" class="error_msg" style="display:none;"></div>
										</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td align="left">
										<input type="button" class="greybut" value="DOWNLOAD QR CODE" onclick="window.location.href='<?php echo SITE_PATH; ?>Views/download.php?url=<?php echo $domainUrl; ?><?php echo $_SESSION['tac_data']['shorturl']; ?>&image_name=<?php echo $_SESSION['tac_data']['shorturl'].'.png'; ?>'">
										</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td>
											<div class="relative cardtype" onclick="openDropdownMenu('cardtype_option');cancelEvent(event);">
												<div class="dropdown" id="cardtype">
													<?php echo strtoupper($cardtype_val); ?>
													<b>v</b>
												</div>
												<div class="dropdown_option cardtype_option" style="display:none;">
													<ul>
													<?php if(isset($cardType) && is_array($cardType) && count($cardType) > 0 ) { ?>
													<li><a href="javascript:void(0);" title="CARD TYPE" onclick="addToDropdown(this,'cardtype','','cardType','c_type');">CARD TYPE</a></li>
													<?php foreach($cardType as $key => $val) { ?>
													<li><a href="javascript:void(0);" title="<?php echo strtoupper($val->typeName) ; ?>" onclick="addToDropdown(this,'cardtype',<?php echo $key+1; ?>,'cardType','c_type');"><?php echo strtoupper($val->typeName) ; ?></a></li>
													<?php } } ?>
													</ul>	
												</div>
											</div>
											<input type="hidden" id="cardType" name="cardType" value="<?php echo $post_value['cardType']; ?>">
											<input type="hidden" id="cardPrice" name="" value="<?php echo $cardPrice; ?>">
										<div id="cardType_msg" class="error_msg" style="display:none;"></div>
										</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td>Upload a Card Artwork</td></tr>
										<tr><td height="10"></td></tr>
										<tr><td>
										<a href="javascript:void(0);" title="Download Card Template" class="download"><em>Download Card Template</em></a>
										<!-- <a href="javascript:void(0);" title="Download Card Template" class="download" onclick="window.location.href='<?php //echo SITE_PATH; ?>Views/download.php?file=card.jpg'"><em>Download Card Template</em></a> -->
										</td></tr>
										<tr><td height="10"></td></tr>
										<tr><td height="25" valign="top">
											<div class="relative" id="card_upload" style="display:block;">
												<input type="file" class="file_photo" onclick="return false;"><!--  onchange="ajaxfileUpload('cardDesign','image',3)" id="image" name="image" -->
												<span class="fakefile_photo">
													<input type="text" value="" class="browsebut">
												</span>
											</div>
											<div id="card_image" style="display:none;"></div>
											<input type="hidden" id="card_img_name" name="card_img_name" value="" />
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
										<tr><td height="25" valign="top">
											<div class="cardpreview backview"><?php echo $back_view; ?></div>
										</td></tr>
										<tr><td height="5"></td></tr>
										<tr><td>BACK</td></tr>
										<tr><td height="20"></td></tr>
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
													<td><input type="radio" name="quantity" id="quantity1" <?php if($post_value['totalCards'] == 150) { ?> checked <?php } ?> value="150" onclick="addToquantity(this,1);"><label for="quantity1">150</label></td>
												</tr>
												<tr><td height="10"></td></tr>
												<tr>
													<td><input type="radio" name="quantity" value="250" <?php if($post_value['totalCards'] == 250) { ?> checked <?php } ?> id="quantity2" onclick="addToquantity(this,1);"><label for="quantity2">250</label></td>
												</tr>
												<tr><td height="10"></td></tr>
												<tr>
													<td><input type="radio" name="quantity" value="500" <?php if($post_value['totalCards'] == 500) { ?> checked <?php } ?> id="quantity3"  onclick="addToquantity(this,1);"><label for="quantity3">500</label></td>
												</tr>
												<tr><td height="10"></td></tr>
												<tr>
													<td><input type="radio" name="quantity" value="1000" <?php if($post_value['totalCards'] == 1000) { ?> checked <?php } ?> id="quantity4"  onclick="addToquantity(this,1);"><label for="quantity4">1000</label></td>
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
												<span id="c_count"><?php if($post_value['totalCards'] != '') echo $post_value['totalCards'].'&nbsp;x&nbsp;'; ?></span><span id="c_type"><?php if($cardtype_val != 'CARD TYPE') echo strtoupper($cardtype_val); ?></span><br>
												<span id="c_style"><?php if($cardstyle_val != 'CARD STYLE') echo strtoupper($cardstyle_val).' Business Cards'; ?></span>
											</span>
											<strong id="tamount" class="tamount"><?php if($post_value['totalPrice'] != 0) echo '$'.$post_value['totalPrice']; ?></strong>
										<?php } else { ?>
											<span>
												<span id="c_count"></span><span id="c_type"></span><br>
												<span id="c_style"></span>
											</span>
											<strong id="tamount" class="tamount"></strong>
										<?php } ?>
											<input type="hidden" id="totalPrice" name="totalPrice" value="<?php echo $post_value['totalPrice']; ?>">
										</td></tr>
										<tr><td height="20"></td></tr>
										<tr><td align="center"><a href="javascript:void(0);" class="yellowbut" title="ORDER NOW" onclick="return validateDesignCreation();">ORDER NOW</a></td> </tr>
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
	<!-- <div class="Footer"></div> -->
	<!-- Footer : End -->
	<div class="clearh"></div>
</div>
<?php
	siteFooter(); // call siteFooter from template
	iframe();
?>
