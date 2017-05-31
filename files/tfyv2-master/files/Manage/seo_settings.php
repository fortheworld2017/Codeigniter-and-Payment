<?php  ob_start();
	if (!session_id()) session_start();
	if(!$_SESSION['adminid'] )
			header("location:index.php");
	require ("../Includes/AdminCommonIncludes.php");
	$site_title 	= 	'';
	$keywords 		= 	'';
	$description 	= 	'';
	$msg			=   '';
	$errorclass 	=   '';
	if(isset($_POST['Submit']) && $_POST['Submit'] != '' ) {
		$site_title 	= 	$_POST['site_title'];
		$keywords 		= 	$_POST['keywords'];
		$description 	= 	$_POST['description'];
		seoSettingsFileWrite($site_title,$keywords,$description);
		header("Location:seo_settings.php?msg=1");
		die();
	}
	else 
	{
		$seosettings_content 	= seoSettingsFileRead();
		$explode_seo_settings 	= explode('*#*',$seosettings_content);
		if(count($explode_seo_settings) > 0) {
			$site_title 		= 	$explode_seo_settings[0];
			$keywords 			= 	$explode_seo_settings[1];
			$description 		= 	$explode_seo_settings[2];
		}
	}	
	if(isset($_GET['msg']) && $_GET['msg'] == '1') {
		$msg   		= 'Seo Settings Updated Successfully&nbsp; ';
		$errorclass = 'success_msg';
	}
?>

<?php adminHeaderInclude();?>
	<table cellpadding="0" cellspacing="0" width="100%" class="border_outer">
		<tr><td class="title">SEO Settings</td></tr>
		<tr><td align="center" height="10"><div id="validate_msg_container"  class="<?php echo $errorclass; ?>" ><strong><?php echo $msg; ?></strong></div></td></tr>
		<tr><td height="20"></td></tr>
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%" class="border" align="center">						
				<tr><td>
					<form name="seo_settings_form" id="seo_settings_form" method="post" action="" enctype="multipart/form-data">
						<table cellpadding="0" cellspacing="0" width="95%" align="center" class="filter">
							<tr><td colspan="2"></td></td><td ></td></tr>
							<tr><td height="7"></td></tr>
							<tr>
								<th align="left" valign="top" width="15%">Site Title</th>
								<th align="center" valign="top" width="5%">:</th>
								<td align="left">
									<input type="text" class="w230" style="width:540px;" tabindex="1" name="site_title" id="site_title" value="<?php echo $site_title;?>" maxlength="250"/>
									<div id="site_title_msg_container"><div id="site_title_msg" class="error_msg"></div></div>
								</td>
							</tr>
							<tr><td height="7"></td></tr>
							<tr>
								<th align="left" valign="top">Keywords</th>
								<th align="center" valign="top">:</th>
								<td><textarea name="keywords" id="keywords" style="width:540px;height:150px"><?php echo $keywords;?></textarea>
									<div id="keywords_msg_container"><div id="keywords_msg" class="error_msg"></div></div>
								</td>
							</tr>
							<tr><td height="7"></td></tr>
							<tr>
								<th align="left" valign="top">Description</th>
								<th align="center" valign="top">:</th>
								<td align="left"><textarea name="description" id="description" style="width:540px;height:150px"><?php echo $description;?></textarea>
									<div id="description_msg_container"><div id="description_msg" class="error_msg"></div></div>
								</td>
							</tr>
							<tr><td height="7"></td></tr>							
							<tr>
								<td colspan="2">&nbsp;</td></td>	
								<td>
									<input type="hidden" id="errorFlag" name="errorFlag" value="0">
									<input type="Submit" class="button" value="Update" title="Submit" alt="Submit" name="Submit" id="Submit" />
								</td>
							</tr>
						</table>
					</form>
				</td></tr>
			</table>
		</td></tr>
		<tr><td height="20"></td></tr>
	</table>
<?php adminFooterInclude();?>
