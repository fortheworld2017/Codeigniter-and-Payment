<?php ob_start();
	if (!session_id()) session_start();
	if(!$_SESSION['adminid'] )
			header("location:index.php");
	require ("../Includes/AdminCommonIncludes.php");
	
	require("../WebResources/FCKeditor/fckeditor.php");
	require('../Controllers/StaticContentController.php');
	$StaticContentControllerObj	=	new StaticContentController();
	
	$heading	 			= '';
	$content_data			= '';
	$error_msg				= '';
	$cid					=	1;

	if(isset($_GET['id']) && $_GET['id']!='')
	{
		$cid	=	$_GET['id'];
		//Save static content
		if(isset($_POST['contentSave']))
		{
			if(isset($_POST['Content'])&&(trim(strip_tags($_POST['Content']))!='') )
			{
				$staticcontent_edit	=	$StaticContentControllerObj->updateStaticContent(escapeSpecialCharacters($_POST),$cid);
				header("Location:staticpage.php?id=".$cid);
			}
			else {
				$error_msg	=	"* Content is required";
				$heading		=	$_POST['heading'];
				$content_data	=	$_POST['Content'];
			}
		}
		else { //Fetch static content
			$staticcontent_detail	=	$StaticContentControllerObj->getContentdetail($cid);
			
			if(is_array($staticcontent_detail)&& count($staticcontent_detail)>0)
			{
				$staticcontent_detail[0]= 	(array)$staticcontent_detail[0];
				$staticcontent_detail	= 	unEscapeSpecialCharacters($staticcontent_detail[0]);
				$heading				=	$staticcontent_detail['heading'];
				$content_data			=	$staticcontent_detail['content'];
			}
		}
	}
?>

	<?php adminHeaderInclude(); ?>
	<table cellpadding="0" cellspacing="0" width="100%" class="border_outer">
		<tr><td height="20"></td></tr>
		<tr><td class="grey_top"></td></tr>
		<tr>	<!-- Content -->
			<td width="100%" valign="top" class="grey_bg">
				<table align="left" cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">			
					<form name="staticcontent_frm" id="staticcontent_frm" action="" method="post"> 				
					<tr><td>
						<table width="960" cellpadding="0" cellspacing="0" border="0" align="center">
							<tr><td class="Title"><?php echo ucfirst(stripslashes($heading)); ?></td></tr>
							<tr><td height="20"></td></tr>
							
							<tr><td>
								<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" class="listTable">
									<tr><th colspan="3" align="center" class="formlable1">Edit Content</th></tr>
									<tr><td height="20" colspan="3"></td></tr>
									<tr>
										<td  align="right" valign="top" class="formlable1"><strong>Heading</strong></td>													
										<td align="center" width="5%" valign="top"><strong>:</strong></td>
										<td align="left" class="textfield">
											<input id="heading" type="Text" maxlength="50" size="30" class="input" name="heading" value="<?php echo ucfirst($heading); ?>" tabindex="1">&nbsp;<span class="error_msg" id="heading_errmsg">*</span>
											<!-- <div id="heading_msg_container" style="display:none;"> --><div id="heading_msg" class="error_msg" ></div><!-- </div> -->
										</td>
									</tr>	
									<tr><td colspan="3" height="10"></td></tr>												
									<tr>
										<td align="center" colspan="3">
											<?php
												$sBasePath  = FCKEDITOR_PATH;
												$oFCKeditor = new FCKeditor('Content') ;
												$oFCKeditor->BasePath = $sBasePath ;
												$oFCKeditor->Config['SkinPath'] = $sBasePath . 'editor/skins/silver/' ;
												$oFCKeditor->Width  = 700;
												$oFCKeditor->Height = 450;
												$oFCKeditor->TabIndex	=	2;
												$mess=$content_data;
												$oFCKeditor->Value = $mess ;
												$oFCKeditor->Create() ;
											?>
											 <span class="star">*</span> 
										</td>
									</tr>
									<?php if($error_msg!='') {?>
									<!-- <tr><td  height="15"></td></tr> -->
									<tr><td  height="15" align="center" class="error_msg" style="text-align:center; padding-left:30px;"><span id="exist_text" class="error_msg"> <?php echo $error_msg; ?> </span> </td></tr>
									<!-- <tr><td  height="15"></td></tr> -->
									<?php } ?>
									<tr><td height="10"></td></tr>
									<tr>
										<td colspan="4" align="center">
											<input type="Hidden" name="errorFlag" id="errorFlag" value="0" >
											<input type="Submit" name="contentSave"  class="w2" value="Save" title="Save" alt="Save" tabindex="3">
											<input type="Button" class="w2" name="cancel" id="cancel" onclick="location.href='staticpage.php?id=<?php echo $cid; ?>'" value="Back" alt="Back" title="Back" tabindex="4"/>
										</td>
									</tr>
									<tr><td height="20"></td></tr>
								</table>
							</td></tr>
							<tr><td height="20"></td></tr> 
						</table> 	
					</td> </tr> 
					</form>
				</table>
			</td>
		</tr>
		<tr><td class="grey_bot"></td></tr>
	</table>
<?php adminFooterInclude();?>
