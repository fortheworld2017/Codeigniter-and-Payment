var e 			=	/^[a-zA-ZÀ-ÿ0-9\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]{2,4}$/; // email reqular expression
var lat_exp		=	/^([0-9.-]+).+?([0-9.-]+)$/;
var t			=	/^[0-9]+$/;
var url_reg		= 	/^(http[s]?:\/\/|ftp:\/\/)?(www\.)?[a-zA-Z0-9-\.]+\.(com|org|net|mil|edu|ca|co.uk|com.au|gov|im)+/;	  
$(document).ready(function(){
	$('#vieworder_table input').each(function(){
			$(this).attr('disabled',true);
	});
	
	//Begin: validate SignIn form when form is submitted
	$("#signin_form").submit(function(){
		var email			= 	$("#signInEmail"),
		password			=	$("#SignInPassword") ;
		$("#errFlag").val(0);
		$(".hasError").removeClass('hasError');
		$(".error_msg").html('');
		checkBlankValue('errFlag',email,'signInEmail_msg','* Email is required');
		if($("#signInEmail").val()!='')
		{
			checkRegexpValue('errFlag',email,'signInEmail_msg','* Email format is invalid');
		}
		checkBlankValue('errFlag',password,'SignInPassword_msg','* Password is required');
		if($(password).val()!='')
		{
			if($(password).val().length < 6)
			{
				updateTipsValue('errFlag','SignInPassword_msg','* Password must be greater than 6 character');
			}
		}
		if ( $("#errFlag").val() == 1) {
			$('.hasError:first').prev().focus();
			return false;  
		}
		else {	
			return true;
		}
	});
	//End: SignIn form validation
});
function checkBlankValue(errFlagName,focusField,errorDiv,errorMessage)
{
	if($.trim(focusField.val())=='')
	{
		updateTipsValue(errFlagName,errorDiv,errorMessage);
		return false;
	}
	else
	{
		return true;
	}
}
function checkRegexpValue(errFlagName,focusField,errorDiv,errorMessage)
{
	if ( !( e.test( focusField.val() ) ) ) {
		updateTipsValue(errFlagName,errorDiv,errorMessage);
		return false;
	}
	else
	{
		return true;
	}
}
function updateTipsValue(errFlagName,errorDiv,errorMessage)
{
	$("#"+errFlagName).val(1);
	$('#'+errorDiv).show();	// newly added
	$('#'+errorDiv).html(errorMessage);
	$('#'+errorDiv).addClass('hasError');
	
}

// Begin
function homeSignupValidate(){
		var fullname        = $("#fullname"),
		email          		= $("#email"),
		password          	= $("#password");
		$("#errorFlag").val(0);
		$(".hasError").removeClass('hasError');
		$(".error_msg").html('');
		field_focus			= '';	
		checkBlankValue('errorFlag',fullname,'fullname_msg',' * Full Name is Required');
		checkBlankValue('errorFlag',email,'email_msg',' * Email is Required');
		if($("#email").val()!='')
			checkRegexpValue('errorFlag',email,"email_msg"," * Email format is invalid.");
		checkBlankValue('errorFlag',password,'password_msg',' * Password is Required');
		if($(password).val()!='')
		{
			if($(password).val().length < 6)
			{
				updateTipsValue('errorFlag','password_msg','* Password must be greater than 6 character.');
			}
		}
		if ( $("#errorFlag").val() == 1)
		{
			$('.hasError:first').prev().focus();
			return false;
		}
		else 
			return true;
		
}
// Ends
//Begin: validate signUp form when form is submitted
function validateSignUp(){
	var userName		=	$("#userName"),
	password			=	$("#password"),
	confirmPassword		=	$("#confirmPassword"),
	firstName			=	$("#firstName"),
	surName				=	$("#surName"),
	company				=	$("#company"),
	telephone			=	$("#telephone"),
	mobile				=	$("#mobile"),
	email				=	$("#email"),
	website				=	$("#website"),
	streetName			=	$("#streetName"),
	city				=	$("#city"),
	state				=	$("#state"),
	zipCode				=	$("#zipCode"),
	country				=	$("#country"),
	billingStreetName	=	$("#billingStreetName"),
	billingCity			=	$("#billingCity"),
	billingState		=	$("#billingState"),
	billingZipCode		=	$("#billingZipCode"),
	billingCountry		=	$("#billingCountry"),
	agree				=	$("#agree"),
	field_focus 		= '',
	allContainerArray	=	new Array('userName_msg','password_msg','confirmPassword_msg','firstName_msg','surName_msg','company_msg','telephone_msg','mobile_msg','email_msg','website_msg','streetName_msg','city_msg','state_msg','zipCode_msg','country_msg','billingStreetName_msg','billingCity_msg','billingState_msg','billingZipCode_msg','billingCountry_msg','billingCountry_msg','agree_msg');
	allFields			=	$([]).add(userName).add(password).add(confirmPassword).add(firstName).add(surName).add(company).add(telephone).add(mobile).add(email).add(website).add(streetName).add(city).add(state).add(zipCode).add(country).add(billingStreetName).add(billingCity).add(billingState).add(billingZipCode).add(billingCountry).add(agree);
	allFields.removeClass('ui-state-error'); //Remove error class if any
	hideDomElement(allContainerArray); //Hide all error message container
	$("#errorFlag").val(0);
	
	checkBlank(userName,"Username", "userName_msg");
	checkBlank(password,"Password", "password_msg");
	$('#confirmPassword_msg').hide();
	checkBlank(confirmPassword,"Confirm password", "confirmPassword_msg");
	if($("#confirmPassword").val() != '' && $("#password").val() != ''){
		if($("#confirmPassword").val() != $("#password").val()){
			$('#confirmPassword_msg').html('* Password and confirm password should be same');
			$('#confirmPassword_msg').show();
			 $("#errorFlag").val(1);
		}
	}
	checkBlank(firstName,"First name", "firstName_msg");
	checkBlank(surName,"Surname", "surName_msg");
	checkBlank(company,"Company", "company_msg");
	checkBlank(telephone,"Telephone", "telephone_msg");
	checkBlank(mobile,"Mobile", "mobile_msg");
	checkBlank(email,"Email", "email_msg");
	if( $("#email").val() != ''){
		checkRegexp(email,e,"Email format is invalid", "email_msg");
	}	
	//checkBlank(website,"Website", "website_msg");
	if($('#website').val() != ''){
		checkRegexp(website,url_reg,"Website format is invalid","website_msg");
	}
	checkBlank(streetName,"Street name", "streetName_msg");
	checkBlank(city,"City", "city_msg");
	checkBlank(state,"State", "state_msg");
	checkBlank(zipCode,"Zip code", "zipCode_msg");
	checkBlank(country,"Country", "country_msg");
	//checkBlank(agree,"agree", "agree_msg");
	//Billing Address
	if($("#billingStatus").val()== 0){
		checkBlank(billingStreetName,"Street name", "billingStreetName_msg");
		checkBlank(billingCity,"City", "billingCity_msg");
		checkBlank(billingState,"State", "billingState_msg");
		checkBlank(billingZipCode,"Zip code", "billingZipCode_msg");
		checkBlank(billingCountry,"Country", "billingCountry_msg");
	}
	//if($('#img_type').val() == 0)
		 //$("#errorFlag").val(1)
	$('#agree_msg').hide();
	if(!($('#agree').is(':checked'))){
			//checkBlank(agree,"Agree","agree_msg");
			$('#agree_msg').html('* Please check the terms and conditions');
			$('#agree_msg').show();
			$("#errorFlag").val(1);
	}
	if($(password).val()!='')
	{
		if($(password).val().length < 6)
		{
			updateTipsValue('errorFlag','password_msg','* Password must be greater than 6 character');
		}
	}
	if ( $("#errorFlag").val() == 1) {
		checkandSetFieldFocus();
		return false;  
	}
	else
	{
		$('#signUpForm').attr('action','');
		$('#signUpForm').attr('target','');
		$('#signUpForm').submit();
		return true;
	}
}
//End: signUp validation
function showForget(forgetpass){
	$('.errorFlag').val('');
	$(".hasError").removeClass('hasError');
	$(".error_msg").html('');
	$('#forgotEmail').val('');
	$('.signIn_div').hide();
	$('.'+forgetpass).show();
	$('#signinTitle').html('FORGOT PASSWORD');
	/*$('#signInEmail_msg_container').hide();	
	$('#SignInPassword_msg_container').hide();	*/
}

function forgetback(){
	$('.errorFlag').val('');
	$(".hasError").removeClass('hasError');
	$(".error_msg").html('');
	$('#signInEmail').val('');
	$('#SignInPassword').val('');
	$('.signIn_div').show();
	$('.forgotpass').hide();
	$('#forget_error').hide();
	$('#signinTitle').html('SIGN IN');
	//$('#forgotEmail_msg_container').hide();	
}
//Begin: forgetpassword
function forgotPassword(){
	var forgotEmail          	= $("#forgotEmail");
	$("#errFlag_forgot").val(0);
	$(".hasError").removeClass('hasError');
	$(".error_msg").html('');
	checkBlankValue('errFlag_forgot',forgotEmail,'forgotEmail_msg',' * Email is required');
	if($("#forgotEmail").val()!='')
		checkRegexpValue('errFlag_forgot',forgotEmail,"forgotEmail_msg"," * Email format is invalid.");
	if ( $("#errFlag_forgot").val() == 1)
	{
		$('.hasError:first').prev().focus();
		return false;
	}
	else 
	{
		$('#forgot_form').submit();
		return true;
	}
		
}
//End: forgetpassword

function validateAccountInfo(){
	//alert("----------------------->" + $('#profileImage').val());
	var userName		=	$("#userName"),
	oldPassword			=	$("#oldPassword"),
	newPassword			=	$("#newPassword"),
	confirmPassword		=	$("#confirmPassword"),
	firstName			=	$("#firstName"),
	surName				=	$("#surName"),
	company				=	$("#company"),
	telephone			=	$("#telephone"),
	mobile				=	$("#mobile"),
	email				=	$("#email"),
	website				=	$("#website"),
	streetName			=	$("#streetName"),
	city				=	$("#city"),
	state				=	$("#state"),
	zipCode				=	$("#zipCode"),
	country				=	$("#country"),
	billingStreetName	=	$("#billingStreetName"),
	billingCity			=	$("#billingCity"),
	billingState		=	$("#billingState"),
	billingZipCode		=	$("#billingZipCode"),
	billingCountry		=	$("#billingCountry"),
	agree				=	$("#agree"),
	field_focus 		= '',
	allContainerArray	=	new Array('userName_msg','oldPassword_msg','newPassword_msg','confirmPassword_msg','firstName_msg','surName_msg','company_msg','telephone_msg','mobile_msg','email_msg','website_msg','streetName_msg','city_msg','state_msg','zipCode_msg','country_msg','billingStreetName_msg','billingCity_msg','billingState_msg','billingZipCode_msg','billingCountry_msg','billingCountry_msg','agree_msg');
	allFields			=	$([]).add(userName).add(oldPassword).add(newPassword).add(confirmPassword).add(firstName).add(surName).add(company).add(telephone).add(mobile).add(email).add(website).add(streetName).add(city).add(state).add(zipCode).add(country).add(billingStreetName).add(billingCity).add(billingState).add(billingZipCode).add(billingCountry).add(agree);
	allFields.removeClass('ui-state-error'); //Remove error class if any
	hideDomElement(allContainerArray); //Hide all error message container
	$("#errorFlag").val(0);
	//username / password
	if($('#userHidden').val()==1){
		checkBlank(userName,"Username", "userName_msg");
		$('#confirmPassword_msg').hide();
		if($("#confirmPassword").val() != '' && $("#newPassword").val() != ''){
			if($("#confirmPassword").val() != $("#newPassword").val()){
				$('#confirmPassword_msg').html('* Password and confirm password should be same');
				$('#confirmPassword_msg').show();
				 $("#errorFlag").val(1)
			}
		}
		if((newPassword.val() != '' && newPassword.length > 0 ) || (confirmPassword.val() != '' && confirmPassword.length > 0)  || oldPassword.val() != '') {
			checkBlank(oldPassword,"Old Password", "oldPassword_msg");
			checkBlank(newPassword,"New Password", "newPassword_msg");
			checkLengthof(newPassword,"New Password",6,15,"newPassword_msg");
			checkBlank(confirmPassword,"Confirm Password", "confirmPassword_msg");
			var result = compareElements(newPassword,confirmPassword,'* New password and confirm password does not match','confirmPassword_msg');
			if(result == false)
			{
				$("#newPassword").val('');
				$("#confirmPassword").val('');
				//$('#newPassword').addClass("ui-state-error");
				$("#errorFlag").val(1);
			}
		}
	}
	if($('#contactHidden').val()==1){
		checkBlank(firstName,"First name", "firstName_msg");
		checkBlank(surName,"Surname", "surName_msg");
		checkBlank(company,"Company", "company_msg");
		checkBlank(telephone,"Telephone", "telephone_msg");
		checkBlank(mobile,"Mobile", "mobile_msg");
		checkBlank(email,"Email", "email_msg");
		if( $("#email").val() != ''){
			checkRegexp(email,e,"Email format is invalid", "email_msg");
		}	
		
		if($('#website').val() != ''){
			checkRegexp(website,url_reg,"Website format is invalid","website_msg");
		}
	}
	if($('#postalHidden').val()==1){
		checkBlank(streetName,"Street name", "streetName_msg");
		checkBlank(city,"City", "city_msg");
		checkBlank(state,"State", "state_msg");
		checkBlank(zipCode,"Zip code", "zipCode_msg");
		checkBlank(country,"Country", "country_msg");
	}
	//Billing Address
	if($('#billingHidden').val()==1){
		checkBlank(billingStreetName,"Street name", "billingStreetName_msg");
		checkBlank(billingCity,"City", "billingCity_msg");
		checkBlank(billingState,"State", "billingState_msg");
		checkBlank(billingZipCode,"Zip code", "billingZipCode_msg");
		checkBlank(billingCountry,"Country", "billingCountry_msg");
	}
	
	$('.ui-state-error').removeClass('ui-state-error');
	if ( $("#errorFlag").val() == 1) {
		checkandSetFieldFocus();
		return false;
	}
	else
	{
		if($('#userHidden').val()==0 && $('#billingHidden').val()==0 && $('#postalHidden').val()==0 && $('#contactHidden').val()==0 && ($('#img_type').val() == 0 || $('#img_type').val() == '')){
			/*$("#error_div").html('Fields not changed');
			$("#error_div").attr("class","error_msg");
			$("#error_div").show();	*/
			$("#account_submit").attr("disabled","disabled");
			return false;
		}
		else{
			$("#account_submit").removeAttr("disabled");
			$('#accountInfoForm').attr('action','');
			$('#accountInfoForm').attr('target','');
			$('#accountInfoForm').submit();
			return true;
		}
	}
}

/*												 23-2-13													*/
function validateCardTemplate()
{
	$('#cardOption').val('');
	var groupName		=	$("#groupName"),
	exist_group			=	$("#hidden_group"),
	cardOption			=	$("#cardOption"),
	buttonFormat		=	$("#buttonFormat"),
	buttonStyle			=	$("#buttonStyle"),
	domain_name			=	$("domain_name"),
	field_focus 		= '',
	allContainerArray	=	new Array('groupName_msg','existGroupName_msg','cardOption_msg','buttonFormat_msg','buttonStyle_msg','domain_name_msg');
	allFields			=	$([]).add(groupName).add(exist_group).add(cardOption).add(buttonFormat).add(buttonStyle).add(domain_name);
	allFields.removeClass('ui-state-error'); //Remove error class if any
	hideDomElement(allContainerArray); //Hide all error message container
	$("#errorFlag").val(0);
	var contact = social = utility = '';
	var cardType = $('#cardType').val();
	if(cardType == 5)
	{
		var mediaType		=	$("#mediaType");
		checkBlank(mediaType,"Media type","mediaType_msg");
	}
	if($('#groupNameCheck').is(':checked'))
		checkBlank(groupName,"Group name","existGroupName_msg");
	else
		checkBlank(exist_group,"Group name","existGroupName_msg");
	$('.chk_box').each(function(){
		if($(this).attr('type') == 'checkbox' && $(this).attr('param') == 1) {
			if($(this).is(':checked')) {
				$('#cardOption').val(1);
				contact	+= $(this).val()+',';
			}
		}
		else if($(this).attr('type') == 'checkbox' && $(this).attr('param') == 2) {
			if($(this).is(':checked')) {
				$('#cardOption').val(1);
				social	+= $(this).val()+',';
			}
		}
		else if($(this).attr('type') == 'checkbox' && $(this).attr('param') == 3) {
			if($(this).is(':checked')) {
				$('#cardOption').val(1);
				utility	+= $(this).val()+',';
			}
		}
	});
	var domain_flag = 0;
	$('.domain').each(function(){
		if($(this).attr('type') == 'checkbox')
		if($(this).is(':checked')) {
			domain_flag = 1;
		}
	});
	if(domain_flag == 0){
		updateTipsValue('errorFlag','domain_name_msg','* Domain is required');
	}
	if(contact == '')
		contact = 'NULL';
	else
		contact = contact.slice(0,-1);
	if(social == '')
		social = 'NULL';
	else
		social = social.slice(0,-1);
	if(utility == '')
		utility = 'NULL';
	else
		utility = utility.slice(0,-1);
	var fields = contact+'##'+social+'##'+utility;
	$('#selectedOptions').val(fields);
	checkBlank(cardOption,"Card options", "cardOption_msg");
	checkBlank(buttonFormat,"Button format", "buttonFormat_msg");
	checkBlank(buttonStyle,"Button style", "buttonStyle_msg");
	if ( $("#errorFlag").val() == 1) {
		checkandSetFieldFocus();
		return false;  
	}
	else
		return true;
}
function validateCardCreation()
{
	$("#errorFlag").val(0);
	$('.ui-state-error').removeClass('ui-state-error');
	$('.error_msg').hide();
	$('.required').each(function(){
		var id = $(this).attr('id');
		var err_msg	= $(this).attr('validationmsg');
		checkBlank($("#"+id),err_msg,id+"_msg");
	});
	$('.url').each(function(){
		var id = $(this).attr('id');
		var err_msg	= $(this).attr('validationmsg');
		if(checkBlank($("#"+id),err_msg,id+"_msg"))
			checkRegexp($("#"+id),url_reg, err_msg+" is invalid",id+"_msg");
	});
	$('.email').each(function(){
		var id = $(this).attr('id');
		var err_msg	= $(this).attr('validationmsg');
		if(checkBlank($("#"+id),err_msg,id+"_msg"))
			checkRegexp($("#"+id),e,"* Email format is invalid",id+"_msg");
	});
	if ( $("#errorFlag").val() == 1) {
		checkandSetFieldFocus();
		//$('.ui-state-error:first').focus();
		return false;  
	}
	else
		return true;
}

// validateDesignCreation - begins
function validateDesignCreation()
{
	var cardStyle 			= 	$("#cardStyle"),
		cardType 			= 	$("#cardType"),
		totalCards			= 	$("#totalCards"),
		field_focus 		= 	'',
		allContainerArray	=	new Array('cardStyle_msg','cardType_msg','totalCards_msg');
		allFields			=	$([]).add(cardStyle).add(cardType).add(totalCards);
		allFields.removeClass('ui-state-error'); //Remove error class if any
		hideDomElement(allContainerArray); //Hide all error message container
		$("#errorFlag").val(0);	
		checkBlank(cardStyle,"Card style", "cardStyle_msg");
		checkBlank(cardType,"Card type", "cardType_msg");
		checkBlank(totalCards,"Quantity", "totalCards_msg");
		if ( $("#errorFlag").val() == 1) {
			checkandSetFieldFocus();
			return false;  
		}
		else
		{
			$('#cardDesign').submit();
			return true;
		}
}

// validateDesignCreation - ends

// validateStickerDesign - begins
function validateStickerDesign()
{
	var stickerStyle 			= 	$("#stickerStyle"),
		stickerType 			= 	$("#stickerType"),
		totalCards			= 	$("#totalCards"),
		field_focus 		= 	'',
		allContainerArray	=	new Array('stickerStyle_msg','stickerType_msg','totalCards_msg');
		allFields			=	$([]).add(stickerStyle).add(stickerType).add(totalCards);
		allFields.removeClass('ui-state-error'); //Remove error class if any
		hideDomElement(allContainerArray); //Hide all error message container
		$("#errorFlag").val(0);	
		checkBlank(stickerStyle,"Sticker style", "stickerStyle_msg");
		checkBlank(stickerType,"Sticker type", "stickerType_msg");
		checkBlank(totalCards,"Quantity", "totalCards_msg");
		if ( $("#errorFlag").val() == 1) {
			checkandSetFieldFocus();
			return false;  
		}
		else
		{
			$('#stickerDesign').submit();
			return true;
		}
}
// validateStickerDesign - ends

function validateTagDesignForm()
{
	var tagSize 			= 	$("#tagSize"),
		totalCards			= 	$("#totalCards"),
		field_focus 		= 	'',
		allContainerArray	=	new Array('tagSize_msg','totalCards_msg');
		allFields			=	$([]).add(tagSize).add(totalCards);
		allFields.removeClass('ui-state-error'); //Remove error class if any
		hideDomElement(allContainerArray); //Hide all error message container
		$("#errorFlag").val(0);	
		checkBlank(tagSize,"Tag size", "tagSize_msg");
		checkBlank(totalCards,"Quantity", "totalCards_msg");
		if ( $("#errorFlag").val() == 1) {
			checkandSetFieldFocus();
			return false;  
		}
		else
		{
			$('#tagDesignForm').submit();
			return true;
		}
}
// validateStickerDesign - ends

