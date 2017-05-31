<?php
	require_once(ABS_PATH.'Includes/CommonIncludes.php');
	//echo "<br>++><pre>"; print_r($_FILES); echo "</pre><++";die();
	//echo "<br>++><pre>"; print_r($_POST); echo "</pre><++";die();
	if(isset($_GET['profile_pic']) && ($_GET['profile_pic'] == 1 || $_GET['profile_pic'] == 2) ){
		if(is_array($_FILES))
		{
			if(isset($_GET['profile_pic']) && $_GET['profile_pic'] == 2)
			{
				$profile_path = "";
				$path = ABS_IMAGE_PATH_PROFILE.$_GET['user_id'].'.'.$_GET['ext'];
				$path_thumb = ABS_IMAGE_PATH_PROFILE.'thumb/'.$_GET['user_id'].'.'.$_GET['ext'];
				if(file_exists($path_thumb)){
					unlink($path_thumb);
				}
				if(file_exists($path)){
					unlink($path);
				}
			}
			$err = '0';
			$profile_img_array 			=	explode(".",$_FILES['profileImage']['name']);
			$profile_ext				=	end($profile_img_array);
			$profile_name				=	$profile_img_array[0];
			$path 					= 	ABS_PATH.'WebResources/Images/temp/'.$_FILES['profileImage']['name'];
			$pic_path				=	IMAGE_FOLDER_PATH_SITE.'temp/'.$_FILES['profileImage']['name'];
			$allowed 				= 	array("jpg","JPG","jpeg", "JPEG");
			list($width, $height, $type, $attr) = getimagesize($_FILES['profileImage']['tmp_name']);
			if(!in_array($profile_ext, $allowed))
				$err	=	 '1';
			else if($width > '300' || $height > '300' )
				$err 	= 	'2';
			else if(copy($_FILES['profileImage']['tmp_name'],$path))
			{ 
				$err = '0';
			}
		?>
		<script>
			window.top.window.showProfileImage('<?php echo $pic_path; ?>','<?php echo $err; ?>');
		</script>
		<?php
		}
	} 
	else if(isset($_FILES) && is_array($_FILES) && count($_FILES)>0)
	{
		$AbsFolderpath = $file_name = $img_name = $Sitepath = $error_file_type = '';
		$AbsFolderpath = ABS_PATH.'/WebResources/Images/temp/';
		if (isset($_GET['file_name']) && $_GET['file_name'] != ""){
			$file_name	= $_GET['file_name'];
			$type		= $_GET['type'];
			$form_name	= $_GET['form'];
		}
		$org_img_name		=	$_FILES[$file_name]['name'];
		$logo_img_array		= 	explode(".", $org_img_name);
		$logo_ext			=	end($logo_img_array);
		//$img_name 			= 	'logo_'.date('dmyHis').rand().'_'.$_FILES[$file_name]['name'];
		$img_name 			= 	uniqid().".".$logo_ext;
		$temp_Abspath		= 	IMAGE_FOLDER_PATH.'temp/';
		$crop_Abspath		= 	IMAGE_FOLDER_PATH.'crop/';
		$crop_thumb_Abs		=	IMAGE_FOLDER_PATH.'crop/thumb/';
		//$Sitepath = SITE_PATH.'/WebResources/Images/temp/'.$img_name;
		$error_file_type = checkForFiles($_FILES,$file_name,$AbsFolderpath,$type,$img_name);
		if($error_file_type == '')
		{
			copy($_FILES[$file_name]['tmp_name'],$temp_Abspath.$img_name);
			$_SESSION['sess_temp'] = $img_name;
			$result_array['type'] = $type;
			$result_array['form_name'] = $form_name;
			$result_array['original_height'] = $form_name;
			$original_size 		= getWidthandHeight($temp_Abspath.$img_name);
			$original_height 	= $original_size['height'];
			$original_width		= $original_size['width'];
			$blur_image = 0;
			if($type == 1) {
				$constant = 250;
			}
			else
				$constant = 300;
			if($original_height > 470){
				$original_height 	= 470;
				$blur_image 		= 1;
			}
			else if($original_height<$constant) {
				$blur_image 		= 1;
				$original_height 	= $constant;
			}
			if($original_width > 600){
				$blur_image 		= 1;
				$original_width 	= 600;
			}
			else if($original_width<$constant) {
				$blur_image 		= 1;
				$original_width 	= $constant;
			}
			$cointainer_height 					= $cointainer_width	= ($constant+100);
			$top 								= ($cointainer_height - $original_height)/2;
			$left 								= ($cointainer_width - $original_width)/2;
			$result_array['left']				= $left;
			$result_array['top']				= $top;
			$result_array['cointainer_height'] 	= $cointainer_height;
			$result_array['cointainer_width']	= $cointainer_width;
			$result_array['original_height'] 	= $original_size['height'];
			$result_array['original_width']		= $original_size['width'];
			$result_array['resize_height'] 		= $original_height;
			$result_array['resize_width']		= $original_width;
			$result_array['blur_image']			= $blur_image;
			$result_array['img_name']			= $img_name;
			$result_array['crop_height']		= $constant;
			$result_array['crop_width']			= $constant;
			$result_json 						= json_encode($result_array);
			?>
			 <script>
					window.top.window.showimage('<?php echo $error_file_type; ?>','<?php echo $type; ?>','<?php echo $result_json; ?>','<?php echo $org_img_name; ?>');
			</script>
	<?php } else { ?>
			 <script>
					window.top.window.showimage('<?php echo $error_file_type; ?>','','','');
			</script>
	<?php }
	}
?>