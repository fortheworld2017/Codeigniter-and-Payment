<?php ob_start();
	if (!session_id()) session_start();
	if(!isset($_SESSION['adminid'])) header("location:index.php");
	require_once('../Includes/AdminCommonIncludes.php');
	require_once('../Controllers/UserController.php');
	$userControllerObj 	= 	new UserController();
	$id = $profile_path_abs = $userName = $firstName = $surName = $company = $telephone = $mobile = $email = $website = $streetName = $city = $state = $zipCode = $country = $billingStreetName = $billingCity = $billingState = $billingZipCode = $billingCountry = '';
	$cond = '';
	$bindParams = array();
	if(isset($_GET['id']) && $_GET['id'] != '')
	{
		$cond = " and id = ? ";
		$bindParams[] = $_GET['id'];
	}
	$user_details	=	$userControllerObj->getUserInfo($cond, $bindParams);
	$id 				= 	$user_details[0]->id;
	$userName 			= 	$user_details[0]->username;
	$firstName			=	$user_details[0]->firstName;
	$surName			=	$user_details[0]->surName;
	$company			=	$user_details[0]->company;
	$telephone			=	$user_details[0]->telephone;
	$mobile				=	$user_details[0]->mobile;
	$email				=	$user_details[0]->email;
	$website			=	$user_details[0]->website;
	$streetName			=	$user_details[0]->streetName;
	$city				=	$user_details[0]->city;
	$state				=	$user_details[0]->state;
	$zipCode			=	$user_details[0]->zipCode;
	$country			=	$user_details[0]->country;
	$billingStreetName	=	$user_details[0]->billingStreetName;
	$billingCity		=	$user_details[0]->billingCity;
	$billingState		=	$user_details[0]->billingState;
	$billingZipCode		=	$user_details[0]->billingZipCode;
	$billingCountry		=	$user_details[0]->billingCountry;
	if($user_details[0]->profileImage != '' && $user_details[0]->profileImageName !='')
		$profile_path_abs = ABS_IMAGE_PATH_PROFILE.$id.'.'.$user_details[0]->profileImage;
	if(file_exists($profile_path_abs))
		$profile_path = IMAGE_PATH_PROFILE.$id.'.'.$user_details[0]->profileImage;
	else
		$profile_path = "../WebResources/Images/common/noimage.jpg";
?>
<?php adminHeaderInclude(); ?>
	<!-- Content Start -->
	<table cellpadding="0" cellspacing="0" width="100%" class="border_outer">
		<tr><td class="title">View User</td></tr>
		<tr><td height="20"></td></tr>
		<tr><td>
			<table cellpadding="0" cellspacing="0" width="97%" class="border" align="center">					
				<tr><td><?php if(isset($error) && trim($error) != '') echo $error; ?></td></tr>
				<tr><td>
					<table cellpadding="0" cellspacing="0" width="95%" align="center" class="filter">
						<tr>
							<th align="left" width="10%" valign="top">USERNAME/PASSWORD</th>
							<th align="center" valign="top"></th>
							<td align="left"></td>
						</tr>
						<tr><td height="7"></td></tr>
						<tr> 
							<th align="left" width="10%">User Name</th>
							<th align="center" width="5%">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($userName);?></td>
						</tr>
						<tr><td height="7"></td></tr>
						<tr>
							<th align="left" width="10%" valign="top">CONTACT DETAILS</th>
							<th align="center" valign="top"></th>
							<td align="left"></td>
						</tr>
						<tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">First Name</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($firstName);?></td>
						</tr>
						<tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">Sur Name</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($surName);?></td>
						</tr>
						<tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">Company</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($company);?></td>
						</tr>
						<tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">Telephone</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($telephone);?></td>
						</tr>
						<tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">Mobile</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($mobile);?></td>
						</tr>
						<tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">Email</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($email);?></td>
						</tr>
						<tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">Website</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($website);?></td>
						</tr>
						</tr><tr><td height="7"></td></tr>
						<tr>
							<th align="left" width="11%" valign="top">POSTAL ADDRESS</th>
							<th align="center" valign="top"></th>
							<td align="left"></td>
						</tr>
						<tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">Street Name</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($streetName);?></td>
						</tr>
						<tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">City</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($city);?></td>
						</tr><tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">State</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($state);?></td>
						</tr>
						<tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">Zip Code</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($zipCode);?></td>
						</tr><tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">Country</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($country);?></td>
						</tr>
						</tr><tr><td height="7"></td></tr>
						<tr>
							<th align="left" width="10%" valign="top">BILLING ADDRESS</th>
							<th align="center" valign="top"></th>
							<td align="left"></td>
						</tr>
						<tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">Street Name</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($streetName);?></td>
						</tr>
						<tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">City</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($billingCity);?></td>
						</tr><tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">State</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($billingState);?></td>
						</tr>
						<tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">Zip Code</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($billingZipCode);?></td>
						</tr><tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">Country</th>
							<th align="center" valign="top">:</th>
							<td align="left"><?php	echo unEscapeSpecialCharacters($billingCountry);?></td>
						</tr>
						</tr><tr><td height="7"></td></tr>
						<tr>
							<th align="left" valign="top">Profile Picture</th>
							<th align="center" valign="top">:</th>
							<td align="left">
								<img src="<?php  echo $profile_path;  ?>" height="100" width="100" alt="image" title="image" style="display:block;" id="hidden_img" />
								<!-- <img src="../WebResources/Images/common/noimage.jpg" id="noImage" width="100" height="100" alt=""> -->
							</td>
						</tr>
						<tr><td height="10"></td></tr>
						<tr>
							<td colspan="2">&nbsp;</td></td>	
							<td>
								<input type="button" class="button" value="Edit" title="Edit" alt="Edit" name="edit" id="edit" onclick="location.href='edit_user.php?id=<?php echo $id; ?>&edit=1'"  />&nbsp;
								<input type="button" class="button" value="Back" title="Back" alt="Back" name="back" id="back" onclick="location.href='user_listing.php'" />
							</td>
						</tr>
						<tr><td height="10"></td></tr>
					</table>
				</td></tr>
			</table>
		</td></tr>
		<tr><td height="20"></td></tr>
	</table>
	<!-- Content End -->
<?php adminFooterInclude();?>
