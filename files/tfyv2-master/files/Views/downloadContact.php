<?php 	require_once('../Includes/CommonIncludes.php');
		require_once('vcfdownload.php');
		$downloadVCF	= new createVCF();
		$download		= $downloadVCF->downloadVCF(VCF_FOLDER_PATH,$_GET['card_id'],$_GET['browser'],$_GET['card_name']); 
?>