var e 			=	/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]{2,4}$/;
var lat_exp		=	/^([0-9.-]+).+?([0-9.-]+)$/;
var t			=	/^[0-9]+$/;
var url_reg		=	/^(http[s]?:\/\/|ftp:\/\/)?(www\.)?[a-zA-Z0-9-\.]+\.(com|org|net|mil|edu|ca|co.uk|com.au|gov)$/;



$(document).ready(function(){

	//Begin: validate login form when form is submitted
	$("#loginform").submit(function(){
		var username		= 	$("#username"),
		password			=	$("#password") ,
		field_focus			=	'',
		allContainerArray 	=	new Array('username_msg','password_msg','validate_msg');
		allFields 			=	$([]).add(username).add(password);
		allFields.removeClass('ui-state-error'); //Remove error class if any
		hideDomElement(allContainerArray); //Hide all error message container
		$("#errorFlag").val(0);
		checkBlank(username,"Username", "username_msg");
		checkBlank(password,"Password", "password_msg");
		if ( $("#errorFlag").val() == 1) {
			checkandSetFieldFocus();
			return false;  
		}
		else {	
			return true;
		}
	});
	//End: login validation
	
	
	
	//Begin: validate change password form when form is submitted
	$("#change_password_form").submit(function(){
		var username			= 	$("#name"),
			email				=	$("#email"),
			oldPassword			= 	$("#old_password"),
			newPassword			= 	$("#new_password"),
			confirmPassword		= 	$("#confirm_password"),
			field_focus			=	'',
			allContainerArray 	=	new Array('name_msg','email_msg','old_password_msg','new_password_msg','confirm_password_msg','validate_msg');
			allFields 			=	$([]).add(username).add(email).add(oldPassword).add(newPassword).add(confirmPassword);
		allFields.removeClass('ui-state-error'); //Remove error class if any
		hideDomElement(allContainerArray); //Hide all error message container
		$("#errorFlag").val(0);
		checkBlank(username,"Username", "name_msg");
		checkBlank(email,"Email", "email_msg");
		if( $("#email").val() != ''){
			 var result = $("#email").val().split(",");
 			for(var i = 0;i < result.length;i++){
				if ( !( e.test( result[i] ) ) ) {
					email.addClass('ui-state-error');
					updateTips('Email Format is invalid', 'email_msg',email);
					return false;
				} 
			}
    						
		}
		if((newPassword.val() != '' && newPassword.length > 0 ) || (confirmPassword.val() != '' && confirmPassword.length > 0)  || oldPassword.val() != '') {
			checkBlank(oldPassword,"Old Password", "old_password_msg");
			checkBlank(newPassword,"New Password", "new_password_msg");
			checkLengthof(newPassword,"New Password",5,12,"new_password_msg");
			checkBlank(confirmPassword,"Confirm Password", "confirm_password_msg");
			var result = compareElements(newPassword,confirmPassword,'* New Password and Confirm Password does not match','confirm_password_msg');
			if(result == false)
			{
				$("#new_password").val('');
				$("#confirm_password").val('');
				$('#new_password').addClass("ui-state-error");
				$("#errorFlag").val(1);
			}
		}
		if ( $("#errorFlag").val() == 1) {
			
			checkandSetFieldFocus();
			return false;  
		}
		else {	
			return true;
		}
	});
	//End: change password validation
	
		//Begin: Validate update staticcontent
	$("#staticcontent_frm").submit(function(){

		var heading      	= $("#heading"),
		allContainerArray 	= new Array('heading_msg');
		allFields 			= $([]).add(heading);		
		allFields.removeClass('ui-state-error'); //Remove error class if any
		hideDomElement(allContainerArray); //Hide all error message container
		$("#errorFlag").val(0);
		field_focus			= '';
		checkBlank(heading, "Heading", "heading_msg");
		if ( $("#errorFlag").val() == 1)
		{
			checkandSetFieldFocus();
			return false;
		}
		else 
			return true;
     });
	//End: Validate update staticcontent
	
	
		//Begin: Validate update staticcontent
	$("#news_form").submit(function(){

		var heading      	= $("#heading"),
		allContainerArray 	= new Array('heading_msg');
		allFields 			= $([]).add(heading);		
		allFields.removeClass('ui-state-error'); //Remove error class if any
		hideDomElement(allContainerArray); //Hide all error message container
		$("#errorFlag").val(0);
		field_focus			= '';
		checkBlank(heading, "Heading", "heading_msg");
		if ( $("#errorFlag").val() == 1)
		{
			checkandSetFieldFocus();
			return false;
		}
		else 
			return true;
     });
	//End: Validate update staticcontent
	//end document ready
});

/* validation - add and edit user */
function validateUserEdit(){
	var userName		=	$("#userName"),
	oldPassword			=	$("#oldPassword"),
	newPassword			=	$("#newPassword"),
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
	allContainerArray	=	new Array('userName_msg','password_msg','oldPassword_msg','newPassword_msg','confirmPassword_msg','firstName_msg','surName_msg','company_msg','telephone_msg','mobile_msg','email_msg','website_msg','streetName_msg','city_msg','state_msg','zipCode_msg','country_msg','billingStreetName_msg','billingCity_msg','billingState_msg','billingZipCode_msg','billingCountry_msg','billingCountry_msg','agree_msg');
	allFields			=	$([]).add(userName).add(password).add(oldPassword).add(newPassword).add(confirmPassword).add(firstName).add(surName).add(company).add(telephone).add(mobile).add(email).add(website).add(streetName).add(city).add(state).add(zipCode).add(country).add(billingStreetName).add(billingCity).add(billingState).add(billingZipCode).add(billingCountry).add(agree);
	allFields.removeClass('ui-state-error'); //Remove error class if any
	hideDomElement(allContainerArray); //Hide all error message container
	$("#errorFlag").val(0);
	checkBlank(userName,"User Name", "userName_msg");
	
	checkBlank(firstName,"First Name", "firstName_msg");
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
	//Billing Address
	if($("#billingStatus").val()== 0){
		checkBlank(billingStreetName,"Street Name", "billingStreetName_msg");
		checkBlank(billingCity,"City", "billingCity_msg");
		checkBlank(billingState,"State", "billingState_msg");
		checkBlank(billingZipCode,"Zip code", "billingZipCode_msg");
		checkBlank(billingCountry,"Country", "billingCountry_msg");
	}
	//if($('#img_type').val() == 0)
		 //$("#errorFlag").val(1)
	if($('#edit_status').val()== 0){
		checkBlank(newPassword,"Password", "newPassword_msg");
		$('#confirmPassword_msg').hide();
		checkBlank(confirmPassword,"Confirm password", "confirmPassword_msg");
		checkLengthof(newPassword,"New Password",6,15,"newPassword_msg");
		if($("#confirmPassword").val() != '' && $("#newPassword").val() != ''){
			if($("#confirmPassword").val() != $("#newPassword").val()){
				$('#confirmPassword_msg').html('* Password and confirm password should be same');
				$('#confirmPassword_msg').show();
				 $("#errorFlag").val(1);
			}
		}
		
	}
	else if($('#edit_status').val()== 1){
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
	if ( $("#errorFlag").val() == 1) {
		checkandSetFieldFocus();
		return false;
	}
	else
	{
			
			$('#users_form').attr('action','');
			$('#users_form').attr('target','');
			$('#users_form').submit();
			return true;
	}
}
/* validation - edit card */
function validateCard(){
	var shortUrl = $('#shortUrl'),
	field_focus 		= '',
	allContainerArray	=	new Array('shortUrl_msg');
	allFields			=	$([]).add(shortUrl);
	allFields.removeClass('ui-state-error'); //Remove error class if any
	hideDomElement(allContainerArray); //Hide all error message container
	$("#errorFlag").val(0);
	checkBlank(shortUrl,"Short url", "shortUrl_msg");
	if ( $("#errorFlag").val() == 1) {
		checkandSetFieldFocus();
		return false;
	}
	else
	{
		$('#cards_form').attr('action','');
		$('#cards_form').attr('target','');
		$('#cards_form').submit();
		return true;
	}
}
//Domain Validation Start
function validateDomainForm()
{
	var domainName 			= 	$("#domainName"),
		field_focus 		= 	'',
		allContainerArray	=	new Array('domainName_msg','exist_msg');
		allFields			=	$([]).add(domainName);
		allFields.removeClass('ui-state-error'); //Remove error class if any
		hideDomElement(allContainerArray); //Hide all error message container
		$("#errorFlag").val(0);	
		checkBlank(domainName,"Domain Name", "domainName_msg");
		if ( $("#errorFlag").val() == 1) {
			checkandSetFieldFocus();
			return false;  
		}
		else
		{
			$('#domain_form').submit();
			return true;
		}
}
//Domain Validation End