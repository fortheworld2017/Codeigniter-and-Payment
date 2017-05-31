<?php ob_start();
	if (!session_id()) session_start();
	if(!isset($_SESSION['tac_data']['user_id']))
		header("Location:home");
	require_once('Includes/CommonIncludes.php');
	require_once('Controllers/CardDetailsController.php');
	$cardDetailsControllerObj 	= 	new CardDetailsController();
	
	//	variable declaration
	$g_id   = '';
	$userid = $_SESSION['tac_data']['user_id'];
	$groupListPending = $cardDetailsControllerObj->getExistGroupList($_SESSION['tac_data']['user_id'],0);
	
	if(isset($groupListPending) && count($groupListPending) > 0 && is_array($groupListPending)) {
		$firstGroup 		=	(array)$groupListPast[0];
	}
	
	$bindParams = array();
	
	$groupListPast = $cardDetailsControllerObj->getExistGroupList($_SESSION['tac_data']['user_id'],1);
	$condition     = ' 1 and cd.checkoutStatus = 1 and cd.deletedStatus = 1 and cd.fkUserid = ? ';
	$bindParams[]  = $userid;
	
	if(isset($_GET['groupid']) && $_GET['groupid'] != '')
	{
		$g_id          = $_GET['groupid'];
		$condition    .= ' and cg.fkGroupId = ? ';
		$bindParams[]  = $_GET['groupid'];
	}
	else if(isset($_GET['id']) && $_GET['id'] == 'all'){
		//$condition .= "  and cg.fkCardTemplateId = cd.fkCardTemplateId group by (cg.fkCardTemplateId)";
		$condition    .= "  and cg.fkUserId = ? ";
		$bindParams[]  = $userid;
	}
	else if(isset($firstGroup)){
		$condition    .= ' and cg.fkGroupId = '.$firstGroup['id'];
		$g_id          = $firstGroup['id'];
		$bindParams[]  = $firstGroup['id'];
	}
	$card_details = $cardDetailsControllerObj->getOrdersDetail($condition, $bindParams);
	$rows         = $cardDetailsControllerObj->getTotalRecordCount();
	
	$totalorder = 0;
	if(isset($card_details) && is_array($card_details) && count($card_details)>0){ 
		foreach($card_details as $key => $value){ 
			$totalorder = $totalorder + $value->totalPrice;
		}
	}
	$fields			= '*';
	$condition		= '1';
	$tableName		= 'cardType';
	$cardType		= $cardDetailsControllerObj->getData($fields, $tableName, $condition);
	foreach ($cardType as $key => $value) {
		$ct_array[$key+1] = $value->typeName;
	}
	$tableName		= 'cardStyle';
	$cardStyle		= $cardDetailsControllerObj->getData($fields, $tableName, $condition);
	foreach ($cardStyle as $key => $value) {
		$cs_array[$key+1] = $value->styleName;
	}
	$tableName		= 'stickerType';
	$stickerType	= $cardDetailsControllerObj->getData($fields, $tableName, $condition);
	foreach ($stickerType as $key => $value) {
		$st_array[$key+1] = $value->typeName;
	}
	$tableName		= 'stickerStyle';
	$stickerStyle	= $cardDetailsControllerObj->getData($fields, $tableName, $condition);
	foreach ($stickerStyle as $key => $value) {
		$ss_array[$key+1] = $value->styleName;
	}
?>
	<?php siteHeader(); ?>
	<div class="Bodycontent">	
		<!-- Left nav : Start -->
		<?php leftNav();?>
		<!-- Left nav : End -->	
		<div class="inner_container">		
				<div class="breadcrum" ><!-- style="display:<?php //echo $breadcrum_display; ?>;" -->
					<div class="">
						<?php if(isset($card_details) && is_array($card_details) && count($card_details)>0){ ?>
						<table id="header_yellow" cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="display:block;">
							<tr><td class="" style="color: #231F20; font-size: 14px; font-weight: bold; text-align: left; width: 300px; padding-top:10px; padding-left:5px;">PAST ORDERS > <?php echo strtoupper(date("F Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')))); ?></td>
								<!-- <td align="right" style="padding-top:8px;padding-right:5px; width:700px;">
									<a href="checkout?id=all" title="CHECKOUT ALL ORDERS" class="greybut">CHECKOUT ALL ORDERS</a>									
								</td> -->
							</tr>						
						</table>
						<?php } ?>
						<input type="hidden" id="hidden_total" name="hidden_total" value="<?php echo $totalorder; ?>" />
					</div>
				</div>
				<div class="content">
					<!-- Subnav : Start -->
					<div class="subnav" >
						<div class="cardmenu" ><!-- style="display:<?php //echo $cardmenu_display; ?>;" -->
							<ul id="ul_cardmenu" style="display:block;">
								<li><a href="order?id=all">ALL</a></li>
								<li class=""><a href="order" title="PENDING ORDERS" class="<?php if(isset($_GET['page']) && $_GET['page'] == 'order') { ?>sel<?php } ?>">PENDING ORDERS</a></li>
								<ul>
									<?php 
									if(isset($groupListPending) && count($groupListPending) > 0 && is_array($groupListPending)) {
									foreach($groupListPending as $key => $value)
									{
										$pending_gname_array[$value->id] = $value->groupName;
									?>
									<li>
										<a title="<?php echo $value->groupName;?>" href="order?groupid=<?php echo $value->id; ?>"><?php echo displayText($value->groupName,10);?></a>
									</li>
									<?php } }?>
								</ul>
								<li class=""><a href="past-order" title="PAST ORDERS" class="<?php if(isset($_GET['page']) && $_GET['page'] == 'past-order') { ?>sel<?php } ?>"> PAST ORDERS</a></li>
								<ul>
									<?php 
									if(isset($groupListPast) && count($groupListPast) > 0 && is_array($groupListPast)) {
									foreach($groupListPast as $key => $value)
									{
										$past_gname_array[$value->id] = $value->groupName;
									?>
									<li>
										<a title="<?php echo $value->groupName;?>" href="past-order?groupid=<?php echo $value->id; ?>"><?php echo displayText($value->groupName,10);?></a>
									</li>
									<?php } }?>
								</ul>
							</ul>
						</div>				
						<div class="clearh"></div>
					</div>
					<!-- Subnav : End -->
					<div align="center"></div>
					<div class="orderlist" style="display: block">
					<?php if(isset($card_details) && is_array($card_details) && count($card_details)>0){ 
								foreach($card_details as $key => $value){  
								?>
						<div id="order_<?php echo  $value->id; ?>" class="orders">
								<table cellpadding="0" cellspacing="0" align="center" border="0" width="80%" class="border">
									<tr><td>
										<table cellpadding="0" cellspacing="0" align="center" border="0" width="100%">	
											<tr>
												<th width="40%" align="left" class="date"><?php echo date(DATE_FORMAT_SLASH,strtotime($value->createdDate)); ?> &nbsp;&nbsp;&nbsp; ORDER #<?php echo $value->id; ?></th>
												<th width="40%" align="left" class="Otitle"><?php if(isset($past_gname_array[$g_id])) echo $past_gname_array[$g_id]; ?></th>
												<th width="20%" align="right" class="" ></th>
											</tr>
											<tr><td colspan="3" height="10"></td></tr>
											<tr>
												<td class="address" valign="top">
													<?php echo $value->name; ?><br>									
													<?php echo $value->title; ?><br>									
													<?php if($value->email != '')  echo $value->email; else echo '-';?><br>
													<?php if($value->phoneNumber != '')  echo $value->phoneNumber; else echo '-';?>
												</td>
												<?php if($value->cardType == 1 || $value->mediaType == 1) { ?>
													<td valign="top">
														<br><br>
														<?php echo $value->totalCards; ?> x <?php if(isset($ct_array[$value->cardDesignType])) echo $ct_array[$value->cardDesignType]; else echo '-'; ?><br><?php if(isset($cs_array[$value->cardDesignStyle])) echo $cs_array[$value->cardDesignStyle].' Business Cards'; else echo '-'; ?>
														<br><br>
														<b class="total">TOTAL $<?php echo $value->totalPrice; ?></b>
													</td>
												<?php } else if($value->cardType == 2 || $value->mediaType == 2) { ?>
													<td valign="top">
														<br><br>
														<?php echo $value->totalCards; ?> x <?php if(isset($st_array[$value->stickerType])) echo $st_array[$value->stickerType]; else echo '-'; ?><br><?php if(isset($ss_array[$value->stickerStyle])) echo $ss_array[$value->stickerStyle]. 'Stickers'; else echo '-'; ?>
														<br><br>
														<b class="total">TOTAL $<?php echo $value->totalPrice; ?></b>
													</td>
												<?php } else { ?>
													<td valign="top">
														<br><br>
														<?php echo $value->totalCards; ?> x test <br>testing
														<br><br>
														<b class="total">TOTAL $<?php echo $value->totalPrice; ?></b>
													</td>
												<?php } ?>
												<td class="buttons">
													<a href="javascript:void(0);" title="VIEW ORDER" class="greybut" onclick="largepreview('viewOrder?order_id=<?php echo $value->id; ?>&past=1');" >VIEW ORDER</a><br>
													<a href="viewInvoice?order_id=<?php echo $value->id; ?>" title="VIEW INVOICE" class="greybut">VIEW INVOICE</a><br>
													<a href="createCard?duplicate=<?php echo $value->id; ?>" title="DUPLICATE" class="greybut">DUPLICATE</a>
												</td>
											</tr>
											<tr><td colspan="3" height="10"></td></tr>								
										</table>
									</td></tr>
								</table>
						</div>
						<br>
				<?php 	    }  ?>
						<div id="err_order" class="error_msg" style="display:none; text-align:center;line-height: 93px;">No Order Found</div>
				<?php } else{ ?>
						<div class="error_msg" style="text-align:center;line-height: 93px;">No Order Found</div>
				<?php }?>				
				   </div>
			</div>
		</div>	
	</div>
	<div class="clearh"></div>
</div>
<?php siteFooter();?>
