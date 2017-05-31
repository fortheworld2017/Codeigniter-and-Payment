<?php error_reporting(0);
require_once('../Includes/AjaxCommonIncludes.php');
require_once('../Includes/CommonFunctions.php');
require_once('../Models/Config/cfg.constants.php');
session_start();
if(isset($_GET['action']) && $_GET['action'] =='IMG_UPLOAD')
{
		echo'<pre>';print_r($_FILES);echo'</pre>';
		list($name,$ext) = explode('.',$_FILES['image']['name']);
		$image_name_time = time().$_FILES['image']['name'];
		$image_path = ABS_IMAGE_PATH_LOGO.$image_name_time;
		$abs_path = ABS_IMAGE_PATH_LOGO;
		$err = checkForFiles($_FILES,$image_path,"image",$abs_path);
		//echo "<br>==================>".$err;
		 $image_path_show = IMAGE_PATH_LOGO.$image_name_time;
		 //echo "<br>==================>".$image_path_show;
		 echo "<br>==================>".$err;
		//$_SESSION['temp_image_path'] = $image_path_show;
		if($err == '')
		{
			copy($_FILES['image']['tmp_name'],$image_path); 
			echo $image_path_show;
			echo  ";var status='2'";
		}
		else{
			
		}
			
	
}

// to get card details
if(isset($_GET['action']) && $_GET['action'] =='GET_CARD_DETAILS')
{
	require_once("../Controllers/CardDetailsController.php");
	$cardDetailsControllerObj	= new CardDetailsController();
	require_once('../Controllers/CardGroupsController.php');
	$cardGroupsControllerObj 	= 	new CardGroupsController();
	require_once('../Controllers/CardTemplateController.php');
	$cardTemplateControllerObj 	= 	new CardTemplateController();
	$ids		=	'';
	$card_id	=	 $_POST['card_id'];
	$fields		=	'*';
	$condition	=	'and id = '.$card_id;
	//$orderBy = '';//'order by modifiedDate desc';
	$card_details = $cardDetailsControllerObj->getParticularCardDetails($fields, $condition);
	if(isset($card_details) && count($card_details) > 0)
	{
		echo json_encode($card_details); //echo $card_details;
		echo '##**##';
		$cardGroups		=	$cardGroupsControllerObj->getCardGroups($card_id);
		
		if(isset($cardGroups) && count($cardGroups) > 0 && is_array($cardGroups))
		{
			foreach($cardGroups as $key => $value) {
				$ids .=	$value->fkGroupId.',';
			}
		echo $ids;
		}
		$template_id = (array)$card_details[0];
		if(isset($template_id['fkCardTemplateId']) && $template_id['fkCardTemplateId'] != 0){
			$templates_array	=	$cardTemplateControllerObj->getTemplateDetails($template_id['fkCardTemplateId']);
			$templates_array 	= 	(array)$templates_array[0];
			$templateName		=	$templates_array['templateName'];
			echo '##**##'.$templateName;
		}
	}
}
if(isset($_GET['action']) && $_GET['action'] =='DELETE_TEMP_IMAGE')
{
	$imageName	=	 $_POST['img_name'];
	$Abspath = ABS_PATH.'/WebResources/Images/temp/'.$imageName;
	if(file_exists($Abspath))
		unlink($Abspath);
}
if(isset($_GET['action']) && $_GET['action'] =='CROP_IMAGE')
{	
	$Abspath = ABS_PATH.'/WebResources/Images/';
	$crop_width			= $_POST["crop_width"];
	$crop_height		= $_POST["crop_height"];
	$large_image_location =  $_POST["hidden_image_name"];
	$temp_abspath = $Abspath.'/temp/';
	$original_image_name = $large_image_location;
	$blur_path = 'temp/';
	if($_POST["blur_image"] == 1){
		$re_width			= $_POST["resize_width"];
		$re_height			= $_POST["resize_height"];
		blurResize($Abspath.'blur/blur_'.$large_image_location, $temp_abspath.$large_image_location, $re_width, $re_height);
		$blur_path =  'blur/blur_';
	}
	$large_image_location = $Abspath.$blur_path.$_POST["hidden_image_name"];
	$original_size 		= getWidthandHeight($large_image_location);
	$original_height 	= $original_size['height'];
	$original_width		= $original_size['width'];
	$cointainer_height  = $_POST["cointainer_height"];
	$cointainer_width	= $_POST["cointainer_width"];
	$crop_width			= $_POST["crop_width"];
	$crop_height		= $_POST["crop_height"];
	//echo "<pre>"; print_r($_POST); echo "</pre>";
	$calculate_height = ($cointainer_height - $crop_height)/2;
	$calculate_width = ($cointainer_width - $crop_width)/2;
	/*if($original_height > $cointainer_height) {
		$calculate_height = $calculate_height + (($original_height - $cointainer_height)/2);
	}*/
	/*else {
		$calculate_height = ($cointainer_height - $crop_height)/2;
	}*/
	$top 					= trim($_POST["top"],'px');
	$left 					= trim($_POST["left"],'px');
	$calculate_start_height = $calculate_height - $top;
	$calculate_start_width 	= $calculate_width - $left;
	if($calculate_start_height < 0 ) {
		$calculate_start_height = 0;
	}
	if($calculate_start_width < 0 ) {
		$calculate_start_width = 0;
	}
	$x1 		= $calculate_start_width;
	$y1 		= $calculate_start_height;
	$w 			= $crop_width;
	$h 			= $crop_height;
	$scale		= 1;
	$thumb_image_location = $Abspath.'crop/'.$original_image_name;
	$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
	$large_image_location = $thumb_image_location;
	$thumb_image_location = $Abspath.'crop/thumb/'.$original_image_name;
	$w = THUMB_WIDTH;
	$h = THUMB_HEIGHT;
	 
	$cropped = blurResize($thumb_image_location, $large_image_location,$w,$h);
	if($cropped) {
		if(file_exists($Abspath.'blur/'.$original_image_name))
			unlink($Abspath.'blur/'.$original_image_name);
		if(file_exists($Abspath.'temp/'.$original_image_name))
			unlink($Abspath.'temp/'.$original_image_name);
	}
	echo 1;
}
if(isset($_GET['action']) && $_GET['action'] =='TEMPATE_DETAILS')
{
	require_once('../Controllers/CardTemplateController.php');
	$cardTemplateControllerObj 	= 	new CardTemplateController();
	$id	=	 $_POST['temp_id'];
	$templateDetails	=	$cardTemplateControllerObj->getTemplateDetails($id);
	if(isset($templateDetails) && count($templateDetails) > 0 && is_array($templateDetails))
	{
		echo json_encode($templateDetails[0]);
	}
}

if(isset($_GET['action']) && $_GET['action'] =='CHECK_EXISTS')
{
	require_once("../Controllers/CardDetailsController.php");
	$cardDetailsControllerObj	= new CardDetailsController();
	
	$cardName	= $_POST['card_name'];
	$fields		= 'id,cardName';
	$condition	= ' cardName = ? and cardName != "" ';
	
	$check_exists = $cardDetailsControllerObj->checkExist($fields, $condition, array($cardName));
	if(isset($check_exists) && is_array($check_exists) && count($check_exists[0]) > 0)
		echo '0';
	else
		echo '1';
}

if(isset($_GET['action']) && $_GET['action'] =='DELETE_PROFILE_IMAGE')
{
	//echo "<br>++><pre>"; print_r($_POST); echo "</pre><++";
	require_once("../Controllers/UserController.php");
	$UserControllerObj	= new UserController();
	$path = ABS_IMAGE_PATH_PROFILE.$user_id.'.'.$image_ext;
	$path_thumb = ABS_IMAGE_PATH_PROFILE.'thumb/'.$user_id.'.'.$image_ext;
	if(file_exists($path_thumb)){
		unlink($path_thumb);
	}
	if(file_exists($path)){
		$cond = "profileImage		=	'',
				profileImageName	=	'',";
		$UserControllerObj->updateUserAccount($cond,$user_id);
		unlink($path);
		echo 1;
	}
}
if(isset($_GET['action']) && $_GET['action'] =='CLICK_COUNT')
{
	require_once("../Controllers/MonitorController.php");
	$MonitorControllerObj	= new MonitorController();
	$check_exists = $MonitorControllerObj->checkExists($_POST);
	if(isset($check_exists) && is_array($check_exists) && count($check_exists) > 0) {
		$update_count = $MonitorControllerObj->updateClickcount($_POST);
	}
	else {
		$insert = $MonitorControllerObj->insertClickDetails($_POST);
	}
	//die();
}
?>