<?php
	require_once('../Includes/QRgenerator.php');
	/*if(isset($_GET['file']))
	{
		$fileName	= $_GET['file'];
		$fileExt	= getFileExtension($fileName);
		$filePath	= ABS_IMAGE_PATH_DOWNLOAD.'/'.$fileName;
		$fileSize	= filesize($filePath);
		forcedownload($fileName, $filePath, $fileSize, $fileExt);
	}
	else */ if(isset($_GET['url'])) {
		downLoadQRCode($_GET['url'],$_GET['image_name']);
	}
?>