<?php 
	/**
	 * configuration variables
	 * This file has constants and global variable used through out the application.
	  */
	/**
	 * @var string  site title displayed in browser
	 */
	define('SITE_TITLE', 'Tactify');
	
	if (isset($_SERVER['HTTPS']) && ($_SERVER["HTTPS"] == 'on' ) )
		$site = 'https://';
	else
		$site = 'http://';
	/**
	 * @var string  Absolute HTTP Path
	 */
	if ($_SERVER['HTTP_HOST'] == $_SERVER['TFY_TEST_IP_ADDR']){ // Local
		define('SITE_PATH',  $site.$_SERVER['HTTP_HOST'].'/tactify/'); 
		define('ABS_PATH',  '/var/www/html/tactify/');
		define('FROM_EMAIL_TEXT', 'bremavathi@gmail.com');
		define('PRIMARY_DOMAIN','test-tactify.elasticbeanstalk.com'); 
		define('SECONDARY_DOMAIN','172.21.4.101'); 
	}
	else
	{
		define('SITE_PATH',  $site.$_SERVER['HTTP_HOST'].'/'); 
		define('ABS_PATH',  '/var/app/current/files/');
		define('FROM_EMAIL_TEXT', 'info@bondiadvertising.com');
		define('PRIMARY_DOMAIN','test-tactify.elasticbeanstalk.com'); 
		define('SECONDARY_DOMAIN','www.tfy.im'); 
	}
	
	define('VCF_FOLDER_PATH', ABS_PATH.'WebResources/vcf/');
	define('IMAGE_FOLDER_PATH', ABS_PATH.'WebResources/Images/');
	define('IMAGE_FOLDER_PATH_SITE', SITE_PATH.'WebResources/Images/');
	define('IMAGE_PATH', SITE_PATH.'WebResources/Images/common/');
	define('IMAGE_BUTTON_PATH', SITE_PATH.'WebResources/Images/buttons/');
	define('ADMIN_IMAGE_PATH', SITE_PATH.'WebResources/Images/Manage/');
	define('FCKEDITOR_PATH', SITE_PATH."/WebResources/FCKeditor/");
	
	define('IMAGE_PATH_DOWNLOAD', SITE_PATH.'WebResources/Images/download_images/');
	define('ABS_IMAGE_PATH_DOWNLOAD', ABS_PATH.'WebResources/Images/download_images/');
		
	/**
	define('IMAGE_PATH_LOGO', SITE_PATH.'WebResources/Images/logo/');
	define('ABS_IMAGE_PATH_LOGO', ABS_PATH.'WebResources/Images/logo/');
	define('IMAGE_PATH_PROFILE', SITE_PATH.'WebResources/Images/profile/');
	define('ABS_IMAGE_PATH_PROFILE', ABS_PATH.'WebResources/Images/profile/');
	define('IMAGE_PATH_CARD', SITE_PATH.'WebResources/Images/card/');
	define('ABS_IMAGE_PATH_CARD', ABS_PATH.'WebResources/Images/card/');
	define('IMAGE_PATH_TEMPLATE', SITE_PATH.'WebResources/Images/template/');
	define('ABS_IMAGE_PATH_TEMPLATE', ABS_PATH.'WebResources/Images/template/');
	
	define('IMAGE_PATH_BANNER', SITE_PATH.'WebResources/Images/banner/');
	define('ABS_IMAGE_PATH_BANNER', ABS_PATH.'WebResources/Images/banner/');
	
	define('IMAGE_PATH_PROMOTION', SITE_PATH.'WebResources/Images/promotion/');
	define('ABS_IMAGE_PATH_PROMOTION', ABS_PATH.'WebResources/Images/promotion/');
	
	define('IMAGE_PATH_SHAREFILE', SITE_PATH.'WebResources/Images/share_file/');
	define('ABS_IMAGE_PATH_SHAREFILE', ABS_PATH.'WebResources/Images/share_file/');
	
	define('IMAGE_PATH_STICKER', SITE_PATH.'WebResources/Images/sticker/');
	define('ABS_IMAGE_PATH_STICKER', ABS_PATH.'WebResources/Images/sticker/');
	
	**/
	
	// Uploaded images stored in Amazon S3
	// CDN using Cloudfront
	define('S3_BUCKET_SITE_PATH', 'http://d3ec3txkdh9tcy.cloudfront.net/');
	define('S3_BUCKET_ABS_PATH',  's3://tactify-images/');
	
	// Images used in card.php
	define('IMAGE_PATH_LOGO', S3_BUCKET_SITE_PATH.'logo/');
	define('ABS_IMAGE_PATH_LOGO', S3_BUCKET_ABS_PATH.'logo/');
	
	define('IMAGE_PATH_PROFILE', S3_BUCKET_SITE_PATH.'profile/');
	define('ABS_IMAGE_PATH_PROFILE', S3_BUCKET_ABS_PATH.'profile/');
	
	define('IMAGE_PATH_BANNER', S3_BUCKET_SITE_PATH.'banner/');
	define('ABS_IMAGE_PATH_BANNER', S3_BUCKET_ABS_PATH.'banner/');
	
	define('IMAGE_PATH_PROMOTION', S3_BUCKET_SITE_PATH.'promotion/');
	define('ABS_IMAGE_PATH_PROMOTION', S3_BUCKET_ABS_PATH.'promotion/');
	
	// Need to check
	define('IMAGE_PATH_CARD', S3_BUCKET_SITE_PATH.'card/');
	define('ABS_IMAGE_PATH_CARD', S3_BUCKET_ABS_PATH.'card/');
	define('IMAGE_PATH_TEMPLATE', S3_BUCKET_SITE_PATH.'template/');
	define('ABS_IMAGE_PATH_TEMPLATE', S3_BUCKET_ABS_PATH.'template/');
	define('IMAGE_PATH_SHAREFILE', S3_BUCKET_SITE_PATH.'share_file/');
	define('ABS_IMAGE_PATH_SHAREFILE', S3_BUCKET_ABS_PATH.'share_file/');
	define('IMAGE_PATH_STICKER', S3_BUCKET_SITE_PATH.'sticker/');
	define('ABS_IMAGE_PATH_STICKER', S3_BUCKET_ABS_PATH.'sticker/');
	
	//define('IMAGE_ICON_PATH', SITE_PATH.'WebResources/Images/');
	
	/* Style Path */
	define('STYLE_PATH', SITE_PATH.'WebResources/Styles/');
	define('ADMIN_STYLE_PATH', SITE_PATH.'WebResources/Styles/Manage/');
	
	define('SCRIPT_PATH', SITE_PATH.'WebResources/Scripts/');
	define('ADMIN_SCRIPT_PATH', SITE_PATH.'WebResources/Scripts/Manage/');
	define('LANDING_VIDEO','http://www.youtube.com/embed/xYia42zxslM?theme=light&amp;showinfo=0&amp;modestbranding=1&amp;autohide=1&amp;loop=0&amp;modestbranding=0&amp;start=0');
	
	/**
	 * @var string default number of records displayed per page
	 */
	define('ADMIN_PER_PAGE_LIMIT', 10);
	$admin_per_page_array = array(5,10,15,20,25,30);
	define('CARD_PER_PAGE_LIMIT', 10);
	$card_per_page_array = array(5,10,15,20,25,30);
	
	/**
	 * MAX_CARD_ATTEMPTS: Maximum number of wrong card URL attempts
	 * MAX_LOGIN_FAILS: Maximum number of login fails (per IP) in LOGIN_FAILS_TIMEOUT_MIN minutes
	 * LOGIN_FAILS_TIMEOUT_MIN: Timeout for the login fails blocking in minutes
	 */
	define('MAX_CARD_ATTEMPTS', 3);
	define('MAX_LOGIN_FAILS', 3);
	define('LOGIN_FAILS_TIMEOUT_MIN', 5);
	
	/**
	 * Constant array contain choice of number of items displayed per page
	 */
	define('ADMIN_PER_PAGE_ARRAY', 'return ' . var_export($admin_per_page_array, 1) . ';');//define constant array
	define('CARD_PER_PAGE_ARRAY', 'return ' . var_export($card_per_page_array, 1) . ';');//define constant array
	//send mail
	define('GREETING_TEXT', 'The Tactify Team');
	define('FORGET_LINK', SITE_PATH);
	
	define('DATE_FORMAT','d-m-Y');
	define('DATE_FORMAT_SLASH','d/m/Y');
	define('DATE_EVENT_LIST','l, dS F Y');
	define('SHIPPING_CHARGE', 35);
	global $month_array;
	$month_array = array	(
								'0' => 'JAN',
								'1' => 'FEB',
								'2' => 'MAR',
								'3' => 'APR',
								'4' => 'MAY',
								'5' => 'JUN',
								'6' => 'JUL',
								'7' => 'AUG',
								'8' => 'SEP',
								'9' => 'OCT',
								'10' => 'NOV',
								'11' => 'DEC',
							);
	global $browser_name_array;
	$browser_name_array = array	(
									'1' => 'WINDOWS',
									'2' => 'IOS',
									'3' => 'ANDROID',
									'4' => 'OTHERS' //iPhone
								) ;
	global $exit_name_array;
	$exit_name_array = array	(
									'0' => 'PHONECALL',
									'1' => 'MESSAGE',
									'2' => 'EMAIL',
									'3' => 'CONTACT',
									'4' => 'FACEBOOK',
									'5' => 'SKYPE',
									'6' => 'TWITTER',
									'7' => 'LINKED IN',
									'8' => 'WEBSITE'
								);
	global $time_array;
	$time_array = array	(	'0'=>'00:00',
							'1'=>'01:00',
							'2'=>'02:00',
							'3'=>'03:00',
							'4'=>'04:00',
							'5'=>'05:00',
							'6'=>'06:00',
							'7'=>'07:00',
							'8'=>'08:00',
							'9'=>'09:00',
							'10'=>'10:00',
							'11'=>'11:00',
							'12'=>'12:00',
							'13'=>'13:00',
							'14'=>'14:00',
							'15'=>'15:00',
							'16'=>'16:00',
							'17'=>'17:00',
							'18'=>'18:00',
							'19'=>'19:00',
							'20'=>'20:00',
							'21'=>'21:00',
							'22'=>'22:00',
							'23'=>'23:00'
						);
global	$country_array;
$country_array = array(
					"1" => "Afghanistan",
					"2" => "Albania",
					"3" => "Algeria",
					"4" => "Andorra",
					"5" => "Angola",
					"6" => "Anguilla",
					"7" => "Antarctica",
					"8" => "Antigua and Barbuda",
					"9" => "Argentina",
					"10" => "Armenia",
					"11" => "Aruba",
					"12" => "Australia",
					"13" => "Austria",
					"14" => "Azerbaijan",
					"15" => "Bahamas",
					"16" => "Bahrain",
					"17" => "Bangladesh",
					"18" => "Barbados",
					"19" => "Belarus",
					"20" => "Belgium",
					"21" => "Belize",
					"22" => "Benin",
					"23" => "Bermuda",
					"24" => "Bhutan",
					"25" => "Bolivia",
					"26" => "Bosnia-Herzegovina",
					"27" => "Botswana",
					"28" => "Bouvet Island",
					"29" => "Brazil",
					"30" => "British Indian Ocean Territory",
					"31" => "Brunei Darussalam",
					"32" => "Bulgaria",
					"33" => "Burkina Faso",
					"34" => "Burundi",
					"35" => "Cambodia",
					"36" => "Cameroon",
					"37" => "Canada",
					"38" => "Cape Verde",
					"39" => "Cayman Islands",
					"40" => "Central African Republic",
					"41" => "Chad",
					"42" => "Chile",
					"43" => "China",
					"44" => "Christmas Island",
					"45" => "Cocos (Keeling) Islands",
					"46" => "Colombia",
					"47" => "Comoros",
					"48" => "Congo",
					"49" => "Cook Islands",
					"50" => "Costa Rica",
					"51" => "Croatia",
					"52" => "Cyprus",
					"53" => "Czech Republic",
					"54" => "Denmark",
					"55" => "Djibouti",
					"56" => "Dominica",
					"57" => "Dominican Republic",
					"58" => "East Timor",
					"59" => "Ecuador",
					"60" => "Egypt",
					"61" => "El Salvador",
					"62" => "Equatorial Guinea",
					"63" => "Eritrea",
					"64" => "Estonia",
					"65" => "Ethiopia",
					"66" => "Falkland Islands",
					"67" => "Faroe Islands",
					"68" => "Fiji",
					"69" => "Finland",
					"70" => "Former USSR",
					"71" => "France",
					"72" => "French Guyana",
					"73" => "French Southern Territories",
					"74" => "Gabon",
					"75" => "Gambia",
					"76" => "Georgia",
					"77" => "Germany",
					"78" => "Ghana",
					"79" => "Gibraltar",
					"80" => "Greece",
					"81" => "Greenland",
					"82" => "Grenada",
					"83" => "Guadeloupe (French)",
					"84" => "Guatemala",
					"85" => "Guinea",
					"86" => "Guinea Bissau",
					"87" => "Guyana",
					"88" => "Haiti",
					"89" => "Heard and McDonald Islands",
					"90" => "Honduras",
					"91" => "Hong Kong",
					"92" => "Hungary",
					"93" => "Iceland",
					"94" => "India",
					"95" => "Indonesia",
					"96" => "Iraq",
					"97" => "Ireland",
					"98" => "Israel",
					"99" => "Italy",
					"100" => "Jamaica",
					"101" => "Japan",
					"102" => "Jordan",
					"103" => "Kazakhstan",
					"104" => "Kenya",
					"105" => "Kiribati",
					"106" => "Kuwait",
					"107" => "Kyrgyzstan",
					"108" => "Laos",
					"109" => "Latvia",
					"110" => "Lebanon",
					"111" => "Lesotho",
					"112" => "Liberia",
					"113" => "Libya",
					"114" => "Liechtenstein",
					"115" => "Lithuania",
					"116" => "Luxembourg",
					"117" => "Macau",
					"118" => "Macedonia",
					"119" => "Madagascar",
					"120" => "Malawi",
					"121" => "Malaysia",
					"122" => "Maldives",
					"123" => "Mali",
					"124" => "Malta",
					"125" => "Marshall Islands",
					"126" => "Martinique (French)",
					"127" => "Mauritania",
					"128" => "Mauritius",
					"129" => "Mayotte",
					"130" => "Mexico",
					"131" => "Micronesia",
					"132" => "Moldavia",
					"133" => "Monaco",
					"134" => "Mongolia",
					"135" => "Montserrat",
					"136" => "Morocco",
					"137" => "Mozambique",
					"138" => "Myanmar, Union of (Burma)",
					"139" => "Namibia",
					"140" => "Nauru",
					"141" => "Nepal",
					"142" => "Netherlands",
					"143" => "Netherlands Antilles",
					"144" => "Neutral Zone",
					"145" => "New Caledonia (French)",
					"146" => "New Zealand",
					"147" => "Nicaragua",
					"148" => "Niger",
					"149" => "Nigeria",
					"150" => "Niue",
					"151" => "Norfolk Island",
					"152" => "Northern Mariana Islands",
					"153" => "Norway",
					"154" => "Oman",
					"155" => "Pakistan",
					"156" => "Palau",
					"157" => "Panama",
					"158" => "Papua New Guinea",
					"159" => "Paraguay",
					"160" => "Peru",
					"161" => "Philippines",
					"162" => "Pitcairn Island",
					"163" => "Poland",
					"164" => "Polynesia (French)",
					"165" => "Portugal",
					"166" => "Qatar",
					"167" => "Reunion (French)",
					"168" => "Romania",
					"169" => "Russian Federation",
					"170" => "Rwanda",
					"171" => "S. Georgia &amp; S. Sandwich Islands",
					"172" => "Saint Helena",
					"173" => "Saint Kitts &amp; Nevis Anguilla",
					"174" => "Saint Lucia",
					"175" => "Saint Pierre and Miquelon",
					"176" => "Saint Tome and Principe",
					"177" => "Saint Vincent &amp; Grenadines",
					"178" => "Samoa",
					"179" => "San Marino",
					"180" => "Saudi Arabia",
					"181" => "Senegal",
					"182" => "Seychelles",
					"183" => "Sierra Leone",
					"184" => "Singapore",
					"185" => "Slovakia",
					"186" => "Slovenia",
					"187" => "Solomon Islands",
					"188" => "Somalia",
					"189" => "South Africa",
					"190" => "South Korea",
					"191" => "Spain",
					"192" => "Sri Lanka",
					"193" => "Suriname",
					"194" => "Svalbard and Jan Mayen Islands",
					"195" => "Swaziland",
					"196" => "Sweden",
					"197" => "Switzerland",
					"198" => "Tadjikistan",
					"199" => "Taiwan",
					"200" => "Tanzania",
					"201" => "Thailand",
					"202" => "Togo",
					"203" => "Tokelau",
					"204" => "Tonga",
					"205" => "Trinidad and Tobago",
					"206" => "Tunisia",
					"207" => "Turkey",
					"208" => "Turkmenistan",
					"209" => "Turks and Caicos Islands",
					"210" => "Tuvalu",
					"211" => "Uganda",
					"212" => "United Kingdom",
					"213" => "Ukraine",
					"214" => "United Arab Emirates",
					"215" => "Uruguay",
					"216" => "United States",
					"217" => "US Minor Outlying Islands",
					"218" => "Uzbekistan",
					"219" => "Vanuatu",
					"220" => "Vatican City",
					"221" => "Venezuela",
					"222" => "Vietnam",
					"223" => "Virgin Islands (British)",
					"224" => "Virgin Islands (US)",
					"225" => "Wallis and Futuna Islands",
					"226" => "Western Sahara",
					"227" => "Yemen",
					"228" => "Yugoslavia",
					"229" => "Zaire",
					"230" => "Zambia",
					"231" => "Zimbabwe"
					);
global $card_type;
$card_type		 = array(
						"1"		=>	"Visa",
						"2"		=>	"Master Card",
						"3"		=>	"Discover",
						"4"		=>	"American Express"
					);
global $month_array;
$month_array	=	array(
							'1'		=>	'01',
							'2'		=>	'02',
							'3'		=>	'03',
							'4'		=>	'04',
							'5'		=>	'05',
							'6'		=>	'06',
							'7'		=>	'07',
							'8'		=>	'08',
							'9'		=>	'09',
							'10'	=>	'10',
							'11'	=>	'11',
							'12'	=>	'12'
						);
global $year_array;
$year_array	=	array(
							'1'		=>	'2012',
							'2'		=>	'2013',
							'3'		=>	'2014',
							'4'		=>	'2015',
							'5'		=>	'2016'
						);
define('THUMB_IMAGE','82x82');
define('THUMB_WIDTH','40');	//171
define('THUMB_HEIGHT','40');//111
define('SHORT_URL_LEN','8');

global $cardstyle_array;
$cardstyle_array		 = array(
						"1"		=>	"QR",
						"2"		=>	"NFC"
					);


global $cardtype_array;
$cardtype_array		 = array(
						"1"		=>	"Clear Plastic",
						"2"		=>	"Card Stock"
					);

					
global $cardPrice_array;
$cardPrice_array	 = array(
						"11"		=>	"1",
						"12"		=>	"2",
						"21"		=>	"3",
						"22"		=>	"4"
					);

/*		new			*/
global $social_array;
$social_array		=	array(
									'1'=>'FACEBOOK',
									'2'=>'TWITTER',
									'3'=>'LINKED-IN',
									'4'=>'BLOG',
									'5'=>'TUMBLR',
									'6'=>'SOUNDCLOUD',
									'7'=>'YOUTUBE',
									'8'=>'GOOGLE +',
									'9'=>'SPOTIFY'
							);
global $contact_array;
$contact_array		=	array(
								'1'=>'PHONE NUMBER',
								'2'=>'WEBSITE',
								'3'=>'EMAIL',
								'4'=>'SMS',
								'5'=>'SKYPE',
								'6'=>'ADD CONTACT',
								'7'=>'ADD WEB LINK',
								'8'=>'ADDRESS',
								'9'=>'VIBER'
						);
global $utilities_array;
$utilities_array	=	array(
								'1'=>'PROMOTION',
								'2'=>'CALENDAR',
								'3'=>'CUSTOMER SERVICE',
								'4'=>'APPLE APP STORE',
								'5'=>'SHARE FILES',
								'6'=>'REQUEST MEETING',
								'7'=>'TICKETS',
								'8'=>'GOOGLE PLAY STORE'
						);

global $contact_options_array;
$contact_options_array[1]	=	array(1,2,3,4,5,6,7,8,9);
$contact_options_array[2]	=	array(1,2,3,6,7,8);
$contact_options_array[3]	=	array(1,2,3,6,7,8);
$contact_options_array[4]	=	array();
$contact_options_array[5]	=	array(2,7,8);

global $social_options_array;
$social_options_array[1]	=	array(1,2,3,4,5,6,7,8,9);
$social_options_array[2]	=	array(1,2,3,4,5,6,7,8,9);
$social_options_array[3]	=	array(1,2,3,4,5,6,7,8,9);
$social_options_array[4]	=	array(1);
$social_options_array[5]	=	array(1,2,3,4,5,6,7,8,9);

global $utility_options_array;
$utility_options_array[1]	=	array(1,2,3,5,6);
$utility_options_array[2]	=	array(1,2,3,4,7,8);
$utility_options_array[3]	=	array(1,2,3,4,7,8);
$utility_options_array[4]	=	array(1);
$utility_options_array[5]	=	array(2,4,7,8);

global $tagsize_array;
$tagsize_array		 = array(
						"5"		=>	"5CM",
						"3"		=>	"3CM"
					);
global $media_array;
$media_array		= array(
						"1"		=>	"CARD",
						"2"		=>	"STICKER",
						"3"		=>	"TAGS"
					);
?>
