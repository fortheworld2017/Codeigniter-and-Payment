<?php ob_start();
	if (!session_id()) session_start();
	if(!$_SESSION['adminid'] )
			header("location:index.php");
	require("../Includes/AdminCommonIncludes.php");
	require('../Controllers/StaticContentController.php');
	$StaticContentControllerObj	=	new StaticContentController();
	$show_id		=	1;
	if(isset($_GET['id']) && $_GET['id']!='') //id = 1 for features , id=2 for pricing
		$show_id	=	$_GET['id'];
	$staticcontent_detail	=	$StaticContentControllerObj->getContentdetail($show_id);
?>
<?php adminHeaderInclude(); ?>
	<table cellpadding="0" cellspacing="0" width="100%" class="border_outer">
		<tr><td class="grey_top"></td></tr>
		<tr>	<!-- Content -->
			<td width="100%" valign="top" class="grey_bg">
				<table align="left" cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">					
					<tr><td class="title"><?php echo ucfirst(unEscapeSpecialCharacters($staticcontent_detail[0]->heading)); ?></td></tr>
					<tr><td>
						<table width="97%" cellpadding="0" cellspacing="0" border="0" align="center">							
							<?php if(is_array($staticcontent_detail)&& count($staticcontent_detail)>0)	{ 
									$staticcontent_detail	=	unEscapeSpecialCharacters((array)$staticcontent_detail[0]); ?>
							<tr><td height="20"></td></tr>
							<tr><td>
								<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" class="listTable">
									<tr>
										<th colspan="2" align="center"><?php echo ucfirst($staticcontent_detail['heading']); ?></th>
										<th width="5%"><a href="staticpage_edit.php?id=<?php echo $staticcontent_detail['id']; ?>"><img src="<?php echo ADMIN_IMAGE_PATH; ?>edit_1.gif" width="15" height="15" alt="Edit <?php echo $staticcontent_detail['heading']; ?>" border="0" align="absmiddle" title="Edit <?php echo $staticcontent_detail['heading']; ?>"></a></th>
									</tr>
									<tr> <td  align="left" valign="top" colspan="3"><?php echo $staticcontent_detail['content']; ?></td>	 </tr>
								</table>
							</td></tr>
						    <?php }else{?>	
						    <tr><td align="center" valign="top" colspan="3">No Records Found</td></tr>
							<?php  } ?>
							<tr><td height="20"></td></tr> 
						</table> 	
					</td></tr> 
				</table>
			</td>
		</tr>
		<tr><td class="grey_bot"></td></tr>
	</table>
<?php adminFooterInclude();?>
