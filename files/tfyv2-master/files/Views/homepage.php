<?php
	ob_start();
	if (!session_id()) session_start();
	if(!isset($_SESSION['tac_data']['user_id']))
		header("Location:home");
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
				<?php subNav('');?>
				<!-- Subnav : End -->
				<!-- Create Card : Start -->
				<div class="card_details">
					<div class="create_interaction">
						<table cellpadding="0" cellspacing="0" align="center" width="90%">
							<tr><td class="title">CREATE AN INTERACTION</td></tr>
							<tr><td align="left"><b>SELECT AN OPTION FROM THE LEFT HAND MENU TO GET STARTED!</b></td></tr>
							<tr><td height="20"></td></tr>
							<tr><td><strong>BUSSINESS CARD</strong></td></tr>
							<tr><td>Create a custom NFC business card and monitor interactions.</td></tr>
							<tr><td height="20"></td></tr>
							<tr><td><strong>STICKER</strong></td></tr>
							<tr><td>Create a custom NFC business card and monitor interactions.</td></tr>
							<tr><td height="20"></td></tr>
							<tr><td><strong>CAMPAIGN</strong></td></tr>
							<tr><td>Create a custom NFC business card and monitor interactions.</td></tr>
							<tr><td height="20"></td></tr>
							<tr><td><strong>PROMOTION</strong></td></tr>
							<tr><td>Create a custom NFC business card and monitor interactions.</td></tr>
							<tr><td height="20"></td></tr>
							<tr><td><strong>EVENT</strong></td></tr>
							<tr><td>Create a custom NFC business card and monitor interactions.</td></tr>
						 </table>
					</div>
				</div>
				<!-- Contact Details : Start -->
			</div>
		</div>
	</div>
	<!-- Content : End -->
	<div class="clearh"></div>
</div>
</div>
<?php 
	iframe();
	siteFooter(); 
?>