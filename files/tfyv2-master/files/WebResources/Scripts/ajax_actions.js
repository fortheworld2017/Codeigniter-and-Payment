var ajax_action_url = 'Models/AjaxAction.php';
var admin_ajax_action_url = '../Models/AjaxAction.php';
function cropImage(formname){
	$('#loader').show();
	var crop_data = $('#'+formname).serialize();
	$.post(ajax_action_url+'?action=CROP_IMAGE',crop_data,function(result){
		//if($.trim(result) == 1){
			var imgName = $('#hidden_image_name').val();
			var frm_name = $('#hidden_post_form_name').val();
			var path = actionPath+'WebResources/Images/crop/';
			var img_n = imgName+'?'+Math.random();
			 if($("#cardPreview").length>0) {
				if(frm_name == 'logo') {
					$("#cardPreview").contents().find('#iframe_'+frm_name).show();
					$("#cardPreview").contents().find('#iframe_'+frm_name).attr('src',path+'thumb/'+img_n);
				}
				else {
					$("#cardPreview").contents().find('#iframe_'+frm_name).show();
					$("#cardPreview").contents().find('#iframe_'+frm_name).attr('src',path+img_n);
				}
			}
			if($('#logo_hidden_img').length>0) {
				$('#logo_hidden_img').attr('src',path+img_n);
			}
			$('#edit_logo_img_name').val('');
			$('#loader').hide();
			$('#image').val('');
			$('#image2').val('');
			$('#image3').val('');
			$('#image4').val('');
			$('#image5').val('');
			$('#image6').val('');
	});
}
function deleteImage(imgName,type)
{
	img_id_array	= ["","logo","profile","card","banner","promotion","sharefile","sticker"];
	img_type_array	= ["","image","image2","image3","image4","image5","image6","image7"];
	var img_id		= img_id_array[type];
	var type_id		= img_type_array[type];
	if(confirm('Are you sure to delete this image?')){
		$.post(ajax_action_url+'?action=DELETE_TEMP_IMAGE',{img_name:imgName},function(result){
			$('#'+type_id).val('');
			$('#'+img_id+'_image').hide();
			$('#'+img_id+'_upload').show();
			$('#'+img_id+'_hidden_img').attr('src','')
			$('#'+img_id+'_img_name').val('');
		});
		if(type == 1 || type == 4)
		{
			var iframe_name = $("#cardPreview").contents().find('#iframe_span');
			iframe_name.addClass('prev_left');
		}
		if(type == 1 || type == 2 || type == 4)
		{
			var iframe_img = $("#cardPreview").contents().find('#iframe_'+img_id);
			iframe_img.hide();
			iframe_img.attr('src','');
		}
	}
	window.frames[0].scrollbar();
}
function closePopUp(val)
{
	$('body').css('overflow','auto');
	if(val != 0)
		deleteCropImage(val);
	else
	{
		$('#imageupload_popup').hide();
		$('#imageupload_outer').hide();
		$('#imageupload_inner').hide();
	}
}
function deleteCropImage(type)
{
	if(type == 1)
		var img_id = 'logo';
	else if(type == 2)
		var img_id = 'profile';
	else if(type == 3)
		var img_id = 'card';
	else if(type == 7)
		var img_id = 'sticker';
	var imgName = $('#'+img_id+'_img_name').val();
	if(confirm('Are you sure to delete this image?')){
		$.post(ajax_action_url+'?action=DELETE_TEMP_IMAGE',{img_name:imgName},function(result){
			$('#'+img_id+'_image').hide();
			$('#'+img_id+'_upload').show();
			$('#'+img_id+'_img_name').val('');
		});
		$('#imageupload_popup').hide();
		$('#imageupload_outer').hide();
		$('#imageupload_inner').hide();
		if(type == 1 || type == 2)
		{
			var iframe_name = $("#cardPreview").contents().find('#iframe_span');
			iframe_name.addClass('prev_left');
		}
		$('#loader').hide();
		$('#image').val('');
		$('#image'+type).val('');
		/*$('#image2').val('')
		$('#image3').val('')*/
	}
}
function deleteProfileImage(id,ext,flag){
	var ajax_path = ajax_action_url;
	if(flag == 1)
		ajax_path = ajax_action_url;
	else
		ajax_path = admin_ajax_action_url;
	if(confirm('Are you sure to delete?'))
	{
		$.post(ajax_path+'?action=DELETE_PROFILE_IMAGE',{user_id:id,image_ext:ext},function(result){
			if(result == 1)
			{
				$("#hidden_img").hide();
				$("#noImage").show();
				$("#deleteImage").hide();
			}
			else
			{
				$("#hidden_img").hide();
				$("#noImage").show();
				$("#deleteImage").hide();
			}
		});
	}
	else{
		return false;
	}
}
function ajaxProfileImageUpload(formName,user_id)
{
	$('#'+formName).attr('target','imguploadprintpic');
	if(user_id != ''){
		var ext = $('#profile_img_ext').val();
		$('#'+formName).attr('action','uploadAction?profile_pic=2&user_id='+user_id+'&ext='+ext);
		if(formName == 'users_form')
			$('#'+formName).attr('action','../uploadAction?profile_pic=2&user_id='+user_id+'&ext='+ext);
	}
	else{
		$('#'+formName).attr('action','uploadAction?profile_pic=1');
		if(formName == 'users_form')
			$('#'+formName).attr('action','../uploadAction?profile_pic=1');
	}
	$('#'+formName).submit();
}