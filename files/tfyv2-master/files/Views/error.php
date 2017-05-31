<?php //ob_start();
	//if (!session_id()) session_start();
	//if(!$_SESSION['adminid'] )
		//header("location:index.php");
	require_once('Includes/CommonIncludes.php');
?>
<?php siteHeader(); ?>
	<div class="Bodycontent">
		<div class="Landing">
			<div class="static">
				<table align="center" cellpadding="0" cellspacing="0" border="0" width="95%">
					<tr><td height="20"></td></tr>
					<tr><td class="landtitle" valign="top">Error 403: Forbidden</td></tr>
					<tr><td height="20"></td></tr>
					<tr><td>
						<p>
							Your I.P. has been blocked due to too many false url attempts. <br />
							If you believe this was in error please contact us at 
							<a href="mailto:support@tactify.com">support@tactify.com</a>
						</p>
					</td></tr>
				</table>
			</div>
		</div>
	</div>
</div>
<?php siteFooter();?>
</div>
