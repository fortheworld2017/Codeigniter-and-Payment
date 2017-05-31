var field_focus = '';
/*
 * Function  : updateTips
 * Purpose   : Display error message or tips
 * Arguments : t - text to display, elmError - id of DOM element to dispaly message 
 */
function updateTips(t,elmError,element) {
	//alert('=====updateTips====t=======>'+t+'====elmError==='+elmError+'=====element===='+element);
	var container = elmError + '_container';
	if ( $('#errElementId').val()) {
	 	elmError = $('#errElementId').val();
	}
	$("#" + elmError).show(); //container
	$("#" + elmError).html(t);
	if(field_focus == '')
		field_focus = element;
	$("#errorFlag").val(1);
	
	//return false;
}
/*
 * Function :
 * Purpose  : Hide error container element
 * elmarray : dom element array
 *
 */
function hideDomElement(elmArray) {
	$.each(elmArray, function() {
		//container = this + '_container';
		container = this;
		$('#' + container).hide();
	 });
}

//BEGIN Is number
function isNumberKey(evt) {				
	var keyCode = (evt.which?evt.which:(evt.keyCode?evt.keyCode:0))
	//alert("++++++++++++"+keyCode+"++++++++++++");
	// backspace, delete, left arrow, right arrow, tab keys
	if ((keyCode == 8) || (keyCode == 46) || (keyCode == 37) || (keyCode == 9) || (keyCode == 13)) return true;
	if ((keyCode < 48) || (keyCode > 57)) return false;
	return true;
}
//End Is number


/*
*	Function : checkBlank
*	Purpose	: To check the element is null or not
*/
function checkBlank(element,text,elmError) {
	
	if($.trim($(element).val()) == "") {
		$(element).addClass('ui-state-error');
		//	element.addClass('ui-state-error');
		//alert("----------------------->false");
		updateTips(" *&nbsp;" + text + " is required", elmError, element);
		return false;
	} else {
		if($(field_focus).attr('id') == $(element).attr('id')){
			field_focus = '';
		}
		return true;
	}
}
function checkRegexp(element,regexp,text,elmError) {
	//var regexp		= 	/^(http[s]?:\/\/|ftp:\/\/)?(www\.)?[a-zA-Z0-9-\.]+\.(com|org|net|mil|edu|ca|co.uk|com.au|gov)+/;	
	if ( !( regexp.test( element.val() ) ) ) {
		element.addClass('ui-state-error');
		updateTips(text, elmError,element);
		return false;
	} else {
		return true;
	}
}
//Begin: Paging 
//set the newly selected per page value
setPerPage = function(obj) {
	$("#per_page").val(obj);
	$("#cur_page").val(1);
	$("#paging").submit();
}
//set paging control values - field name to sort, sorting type, current page
setPagingControlValues = function(cur_page, field_name, order_type) {
	$("#order_by").val(cur_page)
	$("#order_type").val(field_name)
	$("#cur_page").val(order_type)
	$("#paging").submit();
}
//End: Paging

// Function to check lenght of the character..
function checkLengthof(element,text,min,max,elmError) 
{
	if (checkBlank(element,text,elmError)) 
	{ //check for blank
		var tips = 0;
		var length = element.val().length;
		
		if ((min != 0 && max != 0) &&  ( length > max || length < min ) )
			//tips = "* Length of " + text + " must be between "+min+" to "+max+".";
			tips = "* Password must be greater than 6 character";
		else if((min !=0 && max == 0) && (length < min))
			//tips =  "* Length of " + text + " must be minimum "+min+" letters.";
			tips = "* Password must be greater than 6 character";
		else if((min == 0 && max != 0) && (length > max))
			//tips = "* Length of " + text + " must be maximum "+max+" letters."
			tips = "* Password must be greater than 6 character";
		
		if (tips != 0) {
			element.addClass('ui-state-error');
			updateTips(tips,elmError,element);
			return false;
		}
		else
		{
			if($(field_focus).attr('id') == $(element).attr('id'))
				field_focus = '';
			return true;
		}
	}
}
// End

// Begin : Function  to check max lenght of 30
function checkMaxLength(element,text,max,elmError)
{
	if(element.val().length > max )
	{
		element.addClass('ui-state-error');
		updateTips("* Length of " +text+" must be maximum "+max+" letters",elmError,element);
		return false;
	}
	else 
		return true;
}
// End



//  Begin: Function to compare 2 elements
function compareElements(element1, element2, text,elmError){
	if($.trim($(element2).val()) != $.trim($(element1).val()) ) {
		element1.addClass('ui-state-error');
		$("#errorFlag").val(1); 
		updateTips(text, elmError,element1);
		return false;
	} else {
		return true;
	}
}
// End  

function checkandSetFieldFocus()
{
	 
	if(field_focus != '')
	{
		$(field_focus).focus();
	}
	//console.log('----------->'+$(field_focus));
	//alert("++++++++++++"+$(field_focus).attr('name')+"++++++++++++");
}

//Begin: Field focus 
function fieldfocus(getField){
	if(document.getElementById(getField)){
		document.getElementById(getField).focus();
	}
}
//End : Field focus
//BEGIN : check and uncheck all the check box in the from
check = function(id)
{
	$("#checklist").hide();
	$("#unchecklist").hide();
	var frm = 	document.getElementById(id); 
	if (frm.titlecheckbox.checked)
	{
		checkAll(id);
		$("#checklist").hide();
		$("#unchecklist").show();
	}	
	else
	{
		uncheckAll(id);
		$("#checklist").show();
		$("#unchecklist").hide(); 
	}	
}

//Un check all the check box in the form submitSociale
checkAll = function(id)
{
	var frm = document.getElementById(id);
	for (var i = 0; i < frm.elements.length; i++) {
	  if (frm.elements[i].name.indexOf('[]') > 0)
 	 	  frm.elements[i].checked = true;
	 }
	if (frm.titlecheckbox)
		frm.titlecheckbox.checked = true;
}
linkcheck = function(id,getFlag)
{
	$("#checklist").hide();
	$("#unchecklist").hide();
	var frm = 	document.getElementById(id); 
	if(getFlag== '1') { 
		checkAll(id);
		$("#checklist").hide();
		$("#unchecklist").show();
	}
	if(getFlag== '0') { 
		uncheckAll(id);
		$("#checklist").show();
		$("#unchecklist").hide(); 
		
	}
}
//Un check all the check box in the form
uncheckAll = function(id)
{
	var frm = document.getElementById(id);
	for (var i = 0; i < frm.elements.length; i++) { 
	   if (frm.elements[i].name.indexOf('[]') > 0)
 	 	  frm.elements[i].checked = false;
	 }
	if (frm.titlecheckbox)
		frm.titlecheckbox.checked = false;
}
confirmDelete = function(frmname,fname)
{	
	flag=0;
	if(frmname.row_id.length>1) 
	{ 
		for (var i = 0; i < frmname.row_id.length; i++)
		{
		  if(frmname.row_id[i].checked){
				flag = 1;
				break;
		  }
		}
	}
	else if (frmname.row_id.checked) { 
		flag = 1;
	}
	if(flag==0) { 
		alert('Please select atleast a record to proceed with '+name+'deletion');
		return false;
	}
	if(flag==1)
		if(confirm('Are you sure to delete this selected '+fname+'?'))
			frmname.submit();
}

function checkOption(element1,element2,text,elmError){
	if(($(element1).is(':checked')) || ($(element2).is(':checked')))
		return true;
	else
	{
		updateTips(" * " + text + " is required.", elmError);
		return false;
	}
}
function checkboxOption(element1,element2,element3,text,elmError){
	if( ($(element1).is(':checked')) || ($(element2).is('checked')) || ($(element3).is('checked')) )
		return true;
	else
 	{
		updateTips(" * " + text + " is required.", elmError);
		return false;
	}
}
function getIdByName(tag, name) {
     var elem = document.getElementsByTagName(tag);
     var arr = new Array();
     for(i = 0,iarr = 0; i < elem.length; i++) {
          att = elem[i].getAttribute("name");
          if(att == name) {
               arr[iarr] = $(elem[i]).attr('id');
               iarr++;
          }
     }
     return arr;
}

function showDivTag(ele_id) {
	$("#"+ele_id).show();
}
function hideDivTag(ele_id) {
	$("#"+ele_id).hide();
}
function clearText(field){
    if (field.defaultValue == field.value) {
		field.value = '';			
	}
    else if (field.value == '') {			
		field.value = field.defaultValue
	};
}

function displayDiv(ele1,ele2) {
	$("#"+ele1).show();
	$("#"+ele2).hide();
}


/*
 * Function : checkDate
 * Purpose  : Check for valid date
 * element  : date element id
 * text     : error message
 * elmError : error message container element object
 */
function checkDateFormat(element,elmError) {
	var dtCh= "/";
	var dtStr = $.trim($(element).val());
	
	//var daysInMonth = DaysArray(12);
	
	var pos1=dtStr.indexOf(dtCh);
	var pos2=dtStr.indexOf(dtCh,pos1+1);
	var strDay=dtStr.substring(0,pos1);
	var strMonth=dtStr.substring(pos1+1,pos2);
	var strYear=dtStr.substring(pos2+1);
	strYr = strYear;
	if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1);
	if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1);
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1);
	}
	month = parseInt(strMonth);
	day   = parseInt(strDay);
	year  = parseInt(strYr);
	//alert('---------------           month '+month+'-----------'+day+'year---'+year);
	if (pos1==-1 || pos2==-1){
		element.addClass('ui-state-error');
		updateTips(" * Invalid date format",elmError,element);
		//alert("===========2");
		return false;
	}
	if (strYear.length != 4 || year==0 ){
		element.addClass('ui-state-error');
		updateTips(" * Invalid Date",elmError,element);
			//alert("===========4");
		return false;
	}
	if (strMonth.length<1 || month<1 || month>12){
		element.addClass('ui-state-error');
		updateTips(" * Invalid date",elmError,element);
			//alert("===========5");
		return false;
	}
	var d = new Date(year, month, 0);
	d.getDate() // last day  of month
	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > d.getDate()){
		element.addClass('ui-state-error');
		updateTips(" * Invalid date",elmError,element);
			//alert("===========6");
		return false;
	}
	return true;
}

// scroll bottom 
function toBottom(div_id)
{
	var object_pos = $('#'+div_id);			 
	var pos_top = object_pos.offset().top;
	window.scrollTo(0, pos_top - 20);
};



/*		Updated		*/

function checkCreditCard(cardnum, cardname,errorDiv)
{
	var ccErrorNo = 0;
	var ccErrors = new Array ()
	returnvalue = 0;
	/* Start : Can change Validation message Here */
	ccErrors [0] = "* Unknown card type";
	ccErrors [1] = "* No card number provided";
	ccErrors [2] = "* Card number is in invalid format";
	ccErrors [3] = "* Card number is invalid";
	ccErrors [4] = "* Card number has an inappropriate number of digits";
	/* End : Can change Validation message Here */
	returnvalue	= validateCreditCard (cardnum, cardname,errorDiv);
	if(returnvalue != 100) {
		cardnum.addClass('ui-state-error');
		updateTips("" + ccErrors[returnvalue] , errorDiv, cardnum);
		return false;
	}
	return true;
}

// Begin : Function  to check max lenght of 30
function checkMaxLength(element,text,max,elmError)
{
	if(element.val().length > max )
	{
		element.addClass('ui-state-error');
		updateTips("* Length of " +text+" must be maximum "+max+" letters",elmError,element);
		return false;
	}
	else 
		return true;
}
// End

//  Begin :check selected month is greater than current month
function checkMonth(element1,element2,elmError)
{
	var d = new Date(),
	month  = d.getMonth()+1;
	year = d.getFullYear();
	if((element2.val() < year))
	{
		
		element1.addClass('ui-state-error');
		updateTips("* Expiry Date is invalid",elmError,element1);
		return false;
	}
	else if((element1.val() < month) && (element2.val() <= year)) //&& (element2.val() <= year)
	{
		element1.addClass('ui-state-error');
		updateTips("* Expiry Date is invalid",elmError,element1);
		return false;
	}
	else
		return true;
}
// end

// Function to check lenght of the character..
function checkLengthof(element,text,min,max,elmError) 
{
	if (checkBlank(element,text,elmError)) 
	{ //check for blank
		var tips = 0;
		var length = element.val().length;
		
		if ((min != 0 && max != 0) &&  ( length > max || length < min ) )
			//tips = "* Length of " + text + " must be between "+min+" to "+max+".";
			tips = "* Password must be greater than 6 character";
		else if((min !=0 && max == 0) && (length < min))
			//tips =  "* Length of " + text + " must be minimum "+min+" letters.";
			tips = "* Password must be greater than 6 character";
		else if((min == 0 && max != 0) && (length > max))
			//tips = "* Length of " + text + " must be maximum "+max+" letters."
			tips = "* Password must be greater than 6 character";
		
		if (tips != 0) {
			element.addClass('ui-state-error');
			updateTips(tips,elmError,element);
			return false;
		}
		else
		{
			if($(field_focus).attr('id') == $(element).attr('id'))
				field_focus = '';
			return true;
		}
	}
}
// End


function validateCreditCard (cardnum, cardname,errorDiv) {
	var cardnumber 	= cardnum.val();
	var cardname 	= cardname.val();
  // Array to hold the permitted card characteristics
  var cards = new Array();
 // Define the cards we support. You may add addtional card types as follows.
  //  Name:         As in the selection box of the form - must be same as user's
  //  Length:       List of possible valid lengths of the card number for the card
  //  prefixes:     List of possible prefixes for the card
  //  checkdigit:   Boolean to say whether there is a check digit
  cards [0] = {name: "Visa", 
               length: "13,16", 
               prefixes: "4",
               checkdigit: true};
  cards [1] = {name: "Master Card", 
               length: "16", 
               prefixes: "51,52,53,54,55",
               checkdigit: true};
  cards [2] = {name: "DinersClub", 
               length: "14,16", 
               prefixes: "305,36,38,54,55",
               checkdigit: true};
  cards [3] = {name: "CarteBlanche", 
               length: "14", 
               prefixes: "300,301,302,303,304,305",
               checkdigit: true};
  cards [4] = {name: "AmEx", 
               length: "15", 
               prefixes: "34,37",
               checkdigit: true};
  cards [5] = {name: "Discover", 
               length: "16", 
               prefixes: "6011,622,64,65",
               checkdigit: true};
  cards [6] = {name: "JCB", 
               length: "16", 
               prefixes: "35",
               checkdigit: true};
  cards [7] = {name: "enRoute", 
               length: "15", 
               prefixes: "2014,2149",
               checkdigit: true};
  cards [8] = {name: "Solo", 
               length: "16,18,19", 
               prefixes: "6334,6767",
               checkdigit: true};
  cards [9] = {name: "Switch", 
               length: "16,18,19", 
               prefixes: "4903,4905,4911,4936,564182,633110,6333,6759",
               checkdigit: true};
  cards [10] = {name: "Maestro", 
               length: "12,13,14,15,16,18,19", 
               prefixes: "5018,5020,5038,6304,6759,6761",
               checkdigit: true};
  cards [11] = {name: "VisaElectron", 
               length: "16", 
               prefixes: "417500,4917,4913,4508,4844",
               checkdigit: true};
  cards [12] = {name: "LaserCard", 
               length: "16,17,18,19", 
               prefixes: "6304,6706,6771,6709",
               checkdigit: true};
  // Establish card type
  var cardType = -1;
  for (var i=0; i<cards.length; i++) {
	 // See if it is this card (ignoring the case of the string)
    if (cardname.toLowerCase () == cards[i].name.toLowerCase()) {
      cardType = i;
      break;
    }
  }
  // If card type not found, report an error
  if (cardType == -1) {
     ccErrorNo = 0;
     return ccErrorNo; 
  }
   
  // Ensure that the user has provided a credit card number
  if (cardnumber.length == 0)  {
     ccErrorNo = 1;
     return ccErrorNo; 
  }
    
  // Now remove any spaces from the credit card number
  cardnumber = cardnumber.replace (/\s/g, "");
  // Check that the number is numeric
  var cardNo = cardnumber
  var cardexp = /^[0-9]{13,19}$/;
  if (!cardexp.exec(cardNo))  {
     ccErrorNo = 2;
     return ccErrorNo; 
  }
  // Now check the modulus 10 check digit - if required
  if (cards[cardType].checkdigit) {
    var checksum = 0;                                  // running checksum total
    var mychar = "";                                   // next char to process
    var j = 1;                                         // takes value of 1 or 2
  
    // Process each digit one by one starting at the right
    var calc;
    for (i = cardNo.length - 1; i >= 0; i--) {
    
      // Extract the next digit and multiply by 1 or 2 on alternative digits.
      calc = Number(cardNo.charAt(i)) * j;
    
      // If the result is in two digits add 1 to the checksum total
      if (calc > 9) {
        checksum = checksum + 1;
        calc = calc - 10;
      }
    
      // Add the units element to the checksum total
      checksum = checksum + calc;
    
      // Switch the value of j
      if (j ==1) {j = 2} else {j = 1};
    } 
  
    // All done - if checksum is divisible by 10, it is a valid modulus 10.
    // If not, report an error.
    if (checksum % 10 != 0)  {
     ccErrorNo = 3;
     return ccErrorNo; 
    }
  }  

  // The following are the card-specific checks we undertake.
  var LengthValid = false;
  var PrefixValid = false; 
  var undefined; 

  // We use these for holding the valid lengths and prefixes of a card type
  var prefix = new Array ();
  var lengths = new Array ();
    
  // Load an array with the valid prefixes for this card
  prefix = cards[cardType].prefixes.split(",");
      
  // Now see if any of them match what we have in the card number
  for (i=0; i<prefix.length; i++) {
    var exp = new RegExp ("^" + prefix[i]);
    if (exp.test (cardNo)) PrefixValid = true;
  }
      
  // If it isn't a valid prefix there's no point at looking at the length
  if (!PrefixValid) {
     ccErrorNo = 3;
     return ccErrorNo; 
  }
    
  // See if the length is valid for this card
  lengths = cards[cardType].length.split(",");
  for (j=0; j<lengths.length; j++) {
    if (cardNo.length == lengths[j]) LengthValid = true;
  }
  
  // See if all is OK by seeing if the length was valid. We only check the length if all else was 
  // hunky dory.
  if (!LengthValid) {
     ccErrorNo = 4;
     return ccErrorNo; 
  };   
  // The credit card is in the required format.
  return 100;
}

function setIconToPreview(id) {
	var buttonFormat		= $('#buttonFormat').val();
	var iframe_tile			= $("#cardPreview").contents().find('#tileicon');
	var iframe_row			= $("#cardPreview").contents().find('#rowicon');
	var iframe_tile_icon	= $("#cardPreview").contents().find('#'+id+'_icon');
	var iframe_row_icon		= $("#cardPreview").contents().find('#'+id+'_row');
	if(buttonFormat != '' && buttonFormat == 1) {
		iframe_tile.show();
		iframe_row.hide();
	}
	else if(buttonFormat != '' && buttonFormat == 2) {
		iframe_row.show();
		iframe_tile.hide();
	}
	if(document.getElementById(id).checked) {
		//iframe_icon.fadeIn('slow');
		iframe_tile_icon.show();
		iframe_row_icon.show();
	}
	else {
		//iframe_icon.fadeOut('slow');
		iframe_tile_icon.hide();
		iframe_row_icon.hide();
	}
	window.frames[0].scrollbar(); //call the function inside the frame
}

function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}
function ajaxfileUpload(getname,fileName,type)
{
	$('#loader').show();
	$('#img_type').val(type);
	if(document.getElementById("preview_text"))
	{
		$('#preview_text').hide();
	}
	$('#loader_img').show();
	formName = getname;
	document.getElementById(formName).target 		=	'imguploadprint';
	document.getElementById(formName).action		=	'uploadAction?file_name='+fileName+'&type='+type+'&form='+formName;
	$('#'+formName).submit();
}
function getValues()
{
		//alert($("#draggable3").css("top"))
		$("#top").val($("#draggable3").css("top"));
		$("#left").val($("#draggable3").css("left"));	
		cropImage('cropform');
		return false;	
}
function nextBlock()
{
	var def_count = 0;
	$('.prevarrow img').show();
	var nav_count = $('#nav_count').val();
	nav_count = nav_count *1+1;
	$('#nav_count').val(nav_count);
	if($(window).width() > 1180)
		def_count = 0;
	else if( $(window).width() > 900)
		def_count = 1;
	else
		def_count = 2;
	if(def_count == nav_count)
	{
		$('.nextarrow img').hide();
		$('.nextarrow').attr('onclick','');
		$('.prevarrow').attr('onclick','prevBlock();');
	}
	var prev_left_val = $("#master_settings").css("left").slice(0,-2);
	if(prev_left_val < 0)
		prev_left_val = (prev_left_val * -1);
	if(nav_count == 1)
		var settings_width = $('#sitevisitsout').width();
	else if(nav_count == 2)
		var settings_width = $('.browser').width() - 26;

	//var settings_width = $('#sitevisitsout').width();
	var new_left_val = prev_left_val *1+ settings_width;
		$('#master_settings').animate({left:-new_left_val}, {
				 queue:true, 
				 duration: 500,
					 specialEasing: {
 							left: 'linear'
	    },
	    complete: function() {
	    }
	  });
}
function prevBlock()
{
	var def_count = 0;
	$('.nextarrow img').show();
	var nav_count = $('#nav_count').val();
	var prev_left_val = $("#master_settings").css("left").slice(0,-2);
	if(prev_left_val < 0)
		prev_left_val = (prev_left_val * -1);
	if(nav_count == 1)
		var settings_width = $('#sitevisitsout').width();
	else if(nav_count == 2)
		var settings_width = $('.browser').width() - 26;
	var new_left_val = prev_left_val - settings_width;
	$('#master_settings').animate({left:-new_left_val}, {
			 queue:true, 
			 duration: 500,
				 specialEasing: {
							right: 'linear'
    },
    complete: function() {
    }
  });
  	nav_count = nav_count - 1;
	$('#nav_count').val(nav_count);
	if(nav_count == 0)
	{
		$('.prevarrow img').hide();
		$('.prevarrow').attr('onclick','');
		$('.nextarrow').attr('onclick','nextBlock();');
	}
}

// start large preview
function largepreview(pagename)
{	
	myWindow=window.open(pagename,'tactify','location=no,menubar=0,status=0,width=1000,height=700,scrollbars=yes,resizable'); 
}
// end large preview

function openDropdownMenu(className)
{
	//$('.'+className).toggle();
	if($("."+className).is(':hidden')) {
		$('.dropdown_option').hide();
		$('.'+className).show();
	}
	else
		$('.'+className).hide();
}



function cancelEvent(event)
{
	if (window.event)
		window.event.cancelBubble = true;
	else
		event.cancelBubble = true;
}
$("html:not(.assigntag,.groupChkbox)").click(function(){
		$(".dropdown_option").hide();
});

function triggerautocomplete(){
	 $("#country_val").focus();
}
function shippingtriggerautocomplete(){
	 $("#shipping_country_val").focus();		
}
function sortListing(formName,orderBy,orderType)
{
	$('#sortBy').val(orderBy);
	$('#sortType').val(orderType);
	$('#'+formName).submit();
}
function assignGroupValue(obj,value,groupName)
{
	var headtitle = $('#edit_headtitle').html();
	//var count = 0;
	var count = $('#hidden_group').val();
	if(count == '')
		count = 0;
	if($(obj).is(":checked"))
		count = count *1+1;
	else
		count = count - 1;
	//if(count <= 0 || count == '')
	if(count <= 0)
		$('#hidden_group').val('');
	else
		$('#hidden_group').val(count);
}

function changeName(id)
{
	var iframe_name = $("#cardPreview").contents().find('#iframe_'+id);
	var name = $("#cardPreview").contents().find('#iframe_name');
	if($('#'+id).val() != '')
		iframe_name.show();
	else
		iframe_name.hide();
	iframe_name.html($('#'+id).val());
	if(id == "firstName" || id == "lastName")
		name.show();
}

function showimage(err,type,jsonval,org_img_name)
{
	img_id_array	= ["","logo","profile","card","banner","promotion","sharefile","sticker"];
	var img_id 		= img_id_array[type];
	/*if(type == 1)
		var img_id = 'logo';
	else if(type == 2)
		var img_id = 'profile';
	else if(type == 3)
		var img_id = 'card';
	else if(type == 4)
		var img_id = 'banner';
	else if(type == 5)
		var img_id = 'promotion';*/
	$('#loader_img').hide();
	err =$.trim(err);
	if(err=='')
	{	
		if(type == 1)
			$('.imageupload_inner').addClass('logo_thkbox');
		else
			$('.imageupload_inner').removeClass('logo_thkbox');
		var result_value = $.parseJSON(jsonval);
		var imgName = result_value.img_name;
		formName 	= result_value.form_name;
		var path = actionPath+'WebResources/Images/temp/'+imgName+'?'+Math.random();
		$('#'+img_id+'_upload').hide();
		$('#'+img_id+'_image').show();
		$('#'+img_id+'_image').html('<a href="javascript:void(0);" onclick="deleteImage('+"'"+imgName+"'"+','+type+');">'+org_img_name+ '&nbsp;&nbsp;&nbsp;&nbsp;X</a>');
		$('#draggable3').attr('src','');
		$('#draggable3').attr('src',path);
		$('#'+img_id+'_img_name').val(imgName);
		if(type == 1 || type == 2 || type == 3 || type == 7) {
			$('#imageupload_popup').show();
			$('body').css('overflow','hidden');
		}
		else if(type == 4) {
			var frm_name = 'banner';
			var imgName = $('#banner_img_name').val();
			var path = actionPath+'WebResources/Images/temp/';
			var img_n = imgName+'?'+Math.random();
			$("#cardPreview").contents().find('#iframe_'+frm_name).show();
			$("#cardPreview").contents().find('#iframe_'+frm_name).attr('src',path+img_n);
		}
		$('.imageheader h2').html('Upload a '+img_id+' image');
		//$('body').css('overflow','hidden');
		//alert('--height--'+result_value.resize_height+'--width--'+result_value.resize_width);
		$('#draggable3').attr('height',result_value.resize_height);
		$('#draggable3').attr('width',result_value.resize_width);
		$('#draggable3').css('top',result_value.top);
		$('#draggable3').css('left',result_value.left);
		$('#top').val(result_value.top);
		$('#left').val(result_value.left);
		$('#original_width').val(result_value.original_width);
		$('#original_height').val(result_value.original_height);
		$('#resize_height').val(result_value.resize_height);
		$('#resize_width').val(result_value.resize_width);
		$('#blur_image').val(result_value.blur_image);
		$('#hidden_image_name').val(result_value.img_name);
		$('#hidden_post_form_name').val(img_id);
		$("#"+formName).attr("target", "");
		$('#cointainer_height').val(result_value.cointainer_height);
		$('#cointainer_width').val(result_value.cointainer_width);
		$('#crop_height').val(result_value.crop_height);
		$('#crop_width').val(result_value.crop_width); // result_value.resize_height -- image height
		if(result_value.resize_height > result_value.crop_height) {
			var wrapper1_add	=	result_value.resize_height-result_value.crop_height;
			var wrapper1_height = 1*result_value.crop_height+(2*wrapper1_add);
			var wrapper1_top	= wrapper1_add-112;
			$('#containment-wrapper1').height(wrapper1_height);	
			wrapper1_top = -1*wrapper1_top;
			$('#containment-wrapper1').css('top',wrapper1_top);
		}
		else {
			$('#containment-wrapper1').height(result_value.crop_height);
			$('#containment-wrapper1').css('top','112px');
		}
		if(result_value.resize_width > result_value.crop_width) {
			var wrapper1_add	=	result_value.resize_width-result_value.crop_width;
			var wrapper1_width = 1*result_value.crop_width+(2*wrapper1_add);
			var wrapper1_left	= wrapper1_add-62;
			$('#containment-wrapper1').width(wrapper1_width);
			wrapper1_left = -1*wrapper1_left;
			$('#containment-wrapper1').css('left',wrapper1_left);
		}
		else {
			$('#containment-wrapper1').width(result_value.crop_width);
			$('#containment-wrapper1').css('left','61px');
		}
		$( "#draggable3" ).draggable({ containment: "#containment-wrapper1", scroll: false });	
		document.getElementById(formName).action	=	''; 
		$('.imageheader a').attr('onclick','closePopUp('+type+')');
		$('.imagefooter').find('a:first').attr('onclick','closePopUp('+type+')');
		var iframe_name = $("#cardPreview").contents().find('#iframe_span');
		iframe_name.removeClass('prev_left');
		if(type != 7) 
			window.frames[0].scrollbar(); //call the function inside the frame
	}
	 else
	 {
	 	$('#preview_text').show();
		alert(err);
		$('#image').val('')
		$('#image2').val('')
		$('#image3').val('')
		$('#image4').val('')
		$('#image5').val('')
		$('#image6').val('')
		$("#"+formName).attr("target", "");
		document.getElementById(formName).action	=	'';
	 }
	 $('#loader').hide();
}
$(document).ready(function(){
	$('#loader').hide();
});
function changeCampaign(campaign)
{
	$("#campaign").html(" > " + campaign);
}
function siteAnalysis()
{
	if( $(window).width() > 1180)
	{
		$('#nav_count').val(0);
		$('#master_settings').css('left','0px');
		$('.content').css('width','1220px');
		$('.graphheight').css('width','896px');
		$('.graphs').css('width','1000px');
		$('.nextarrow img').hide();
		$('.nextarrow').attr('onclick','');
		$('.prevarrow img').hide();
		$('.prevarrow').attr('onclick','');
	}
	else if( $(window).width() > 900)
	{
		//alert(' > 900');
		$('#nav_count').val(0);
		$('#master_settings').css('left','0px');
		$('.prevarrow img').hide();
		$('.prevarrow').attr('onclick','prevBlock();');
		$('.nextarrow img').show();
		$('.nextarrow').attr('onclick','nextBlock();');
		$('.content').css('width','920px');
		$('.graphheight').css('width','669px');
		$('.graphs').css('width','770px');
	}
	else {
		$('#nav_count').val(0);
		$('#master_settings').css('left','0px');
		$('.nextarrow img').show();
		$('.nextarrow').attr('onclick','nextBlock();');
		$('.prevarrow img').hide();
		$('.prevarrow').attr('onclick','prevBlock();');
		$('.content').css('width','720px');
		$('.graphheight').css('width','469px');
		$('.graphs').css('width','570px');
	}
}
function filterDate(filter_id)
{
	if(filter_id != "daterange"){
		$("#"+filter_id).val("1");
		$("#dateFilter").submit();
	}
}
function showProfileImage(path,err)
{
	$("#profilePic_msg").html('');
	if(err == 0){
		$('#noImage').hide();
		$('#hidden_img').show();
		$('#hidden_img').attr('src',path);
		$('#deleteImage').show();
		$('#img_type').val(1)
		//var ext = path.split('/');
		//alert("----------------------->" + ext);
	}
	else if(err == 1){
		$("#profilePic_msg").html('Please upload jpeg image only');
		$('#profileImage').val();
		$('#noImage').show();
		$('#hidden_img').hide();
		$('#hidden_img').attr('src','');
		$('#deleteImage').hide();
		$('#img_type').val(0);
		//$("#errorFlag").val(1);
	}
	else if(err == 2){
		$("#profilePic_msg").html('Please upload the image with dimension 300 X 300');
		$('#profileImage').val();
		$('#noImage').show();
		$('#hidden_img').hide();
		$('#hidden_img').attr('src','');
		$('#deleteImage').hide();
		$('#img_type').val(0)
		//$("#errorFlag").val(1);
	}
}
function deleteProfileImageSignup(){
	if(confirm('Are you sure to delete?'))
	{
		$("#deleteImage").hide();
		$("#hidden_img").hide();
		$("#noImage").show();
	}
	else{
	}
}
function addToDropdown(obj,id,value,hidden_id,quanId)
{
	var text = $(obj).html();
	$('#'+id).html(text+'<b>v</b>');
	$('#'+hidden_id).val(value);
	if(value == '')
		$('#totalPrice').val(0);
	if(text == 'CARD STYLE') {
		$('#c_style').html('');
		$('#tamount').html('');
		clearText();
		$('#'+quanId).html('');
	}
	else if(text == 'CARD TYPE') {
		$('#c_type').html('');
		$('#tamount').html('');
		clearText();
		$('#'+quanId).html('');
	}
	else {
		var card_style = {'1':'QR','2':'NFC'};
		var card_type = {'1':'CLEAR PLASTIC','2':'CARD STOCK'};
		var cs = $('#cardStyle').val()
		var ct = $('#cardType').val()
		if(cs != ''){
			var cs_text = card_style[cs];
			$('#c_style').html(cs_text+' Business Cards');
		}
		if(ct != ''){
			var ct_text = card_type[ct];
			$('#c_type').html(ct_text);
		}
		/*if(quanId == 'c_style')
			$('#'+quanId).html(text+' Business Cards');
		else
		{
			$('#'+quanId).html(text);
			//$('#cardPrice').val(price);
		}*/
	}
	if( $('#cardStyle').val()!= '' && $('#cardType').val()!= '' && $('#totalCards').val()!= '' )
		calculateTotal();
	addPreviewImage();
}

function stickerDropdown(obj,id,value,hidden_id,quanId)
{
	var text = $(obj).html();
	$('#'+id).html(text+'<b>v</b>');
	$('#'+hidden_id).val(value);
	if(value == '')
		$('#totalPrice').val(0);
	if(text == 'STICKER STYLE') {
		$('#c_style').html('');
		$('#tamount').html('');
		clearText();
		$('#'+quanId).html('');
		$('#c_size').hide();
	}
	else if(text == 'STICKER TYPE') {
		$('#c_type').html('');
		$('#tamount').html('');
		clearText();
		$('#'+quanId).html('');
		$('#c_size').hide();
	}
	else {
		/*var sticker_style = {'1':'QR','2':'NFC'};
		var sticker_type = {'1':'STICKER','2':'DECAL'};
		var ss = $('#cardStyle').val()
		var st = $('#cardType').val()
		if(ss != ''){
			var ss_text = sticker_style[ss];
			$('#c_style').html(ss_text+' Business Cards');
		}
		if(st != ''){
			var st_text = sticker_type[st];
			$('#c_type').html(st_text);
		}*/
		if(quanId == 'c_style') {
			$('#'+quanId).html(text+' Stickers');
			$('#c_size').show();
		}
		else {
			$('#'+quanId).html('');
		}
	}
	if( $('#stickerStyle').val()!= '' && $('#stickerType').val()!= '' && $('#totalCards').val()!= '' ) {
		calculateStickerTotal();
	}
	stickerPreviewImage();
}

function clearText()
{
	$('#c_type').html('');
	$('#c_style').html('');
	$('#c_count').html('');
	$('#tamount').html('');
}

// calculateTotal - begins
function calculateTotal()
{
	var card_value = {'11':1,'12':2,'21':3,'22':4};
	var total = '';
	var cardPrice = '';
	var quantity = ''
	if( $('#cardStyle').val()!= '' && $('#cardType').val()!= '' && $('#totalCards').val()!= '' )
	{
		var cs = $('#cardStyle').val();
		var ct = $('#cardType').val();
		quantity = $('#totalCards').val();
		$('#c_count').html(quantity+' x&nbsp;');
		//cardPrice = $('#cardPrice').val();
		cardPrice = card_value[cs+ct];
		total = quantity * cardPrice;
		$('#tamount').html('$'+total);
		$('#totalPrice').val(total);
	}
}
// calculateTotal - ends

function addPreviewImage()
{
	var style	= $('#cardStyle').val();
	var type	= $('#cardType').val();
	if( style != '' && type != '')
	{
		$('.frontview').html('<img src="'+path+'WebResources/Images/download_images/front'+style+'_'+type+'.jpg" width="200" height="115" alt="">');
		$('.backview').html('<img src="'+path+'WebResources/Images/download_images/back'+style+'_'+type+'.jpg" width="200" height="115" alt="">');
	}
	else
	{
		$('.frontview').html('FRONT');
		$('.backview').html('BACK');
	}
}
function addToquantity(obj,type)
{
	var quantity = $(obj).val();
	$('#totalCards').val(quantity);
	if(type == 1)
		calculateTotal();
	else if(type == 2)
		calculateStickerTotal();
	else
		calculateTagTotal();
}
// calculateTotal - begins
function calculateStickerTotal()
{
	var sticker_value = {'11':1,'12':2,'21':3,'22':4};
	var total = '';
	var cardPrice = '';
	var quantity = ''
	if( $('#stickerStyle').val()!= '' && $('#stickerType').val()!= '' && $('#totalCards').val()!= '' )
	{
		var ss = $('#stickerStyle').val();
		var st = $('#stickerType').val();
		quantity = $('#totalCards').val();
		$('#c_count').html(quantity+' x&nbsp;');
		cardPrice = sticker_value[ss+st];
		total = quantity * cardPrice;
		$('#tamount').html('$'+total);
		$('#totalPrice').val(total);
	}
}
// calculateTotal - ends
function stickerPreviewImage()
{
	var style	= $('#stickerStyle').val();
	var type	= $('#stickerType').val();
	if( style != '' && type != '') {
		$('.frontview').html('<img src="'+path+'WebResources/Images/download_images/sticker_'+style+'_'+type+'.jpg" width="200" height="115" alt="">');
	}
	else {
		$('.frontview').html('FRONT');
	}
}
function tagsDropdown(obj,value)
{
	var text = $(obj).html();
	if(text == 'TAG SIZE') {
		$('#c_count').html('');
		$('#tamount').html('');
		$('#totalPrice').val('');
		$('#c_size').hide();
	}
	$('#orderTag').html(text+'<b>v</b>');
	$('#tagSize').val(value);
	calculateTagTotal();
}
function calculateTagTotal()
{
	var tag_value = {'3':1,'5':2};
	var total;
	var cardPrice;
	var quantity;
	if( $('#tagSize').val()!= '' && $('#totalCards').val()!= '' )
	{
		var size = $('#tagSize').val();
		quantity = $('#totalCards').val();
		$('#c_count').html(quantity+' x&nbsp; Tags');
		$('#c_size').show();
		cardPrice = tag_value[size];
		total = quantity * cardPrice;
		$('#tamount').html('$'+total);
		$('#totalPrice').val(total);
	}
}
function mediaDropdown(obj,value)
{
	var text = $(obj).html();
	if(value == '')
		$('#mediaType').val('');
	$('#mediatag').html(text+'<b>v</b>');
	$('#mediaType').val(value);
	$('.media_option').hide();
}