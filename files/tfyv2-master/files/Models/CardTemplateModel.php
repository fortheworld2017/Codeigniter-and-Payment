<?php 
class CardTemplateModel extends Model
{
	function insertCardTemplate($post_array)
	{
		$sql = "insert into `cardTemplate` set		fkUserId				=	?,
													cardType				=	?,
													buttonFormat 			=	?,
													buttonStyle				=	?,
													mediaType				=	?,
													
													cardColour				=	?,
													headerColour			=	?,
													phoneNumberSelected		=	?,
													websiteSelected			=	?,
													emailSelected			=	?,
													
													smsSelected				=	?,
													skypeSelected			=	?,
													addContactSelected		=	?,
													addWeblinkSelected		=	?,
													addressSelected			=	?,
													
													viberSelected			=	?,
													facebookSelected		=	?,
													twitterSelected			=	?,
													linkedinSelected		=	?,
													blogSelected			=	?,
													
													tumblrSelected			=	?,
													soundCloudSelected		=	?,
													youTubeSelected			=	?,
													googlePlusSelected		=	?,
													spotifySelected			=	?,
													
													promotionSelected		=	?,
													calenderSelected		=	?,
													customerServiceSelected	=	?,
													appStoreSelected		=	?,
													shareFilesSelected		=	?,
													
													requestMeetingSelected	=	?,
													ticketsSelected			=	?,
													playStoreSelected		=	?,
													selectedOptions			=	?,
													
													createdDate				=	now(),
													modifiedDate			=	now()";
		
		$bindParams = array(
						$_SESSION['tac_data']['user_id'],
						$post_array['cardType'],
						$post_array['buttonFormat'],
						$post_array['buttonStyle'],
						(isset($post_array['mediaType'])? $post_array['mediaType']:'0'),
						
						$post_array['cardColour_1'],
						$post_array['cardColour_2'],
						(isset($post_array['phoneNumberSelected'])?'1':'0'),
						(isset($post_array['websiteSelected'])?'1':'0'),
						(isset($post_array['emailSelected'])?'1':'0'),
						
						(isset($post_array['smsSelected'])?'1':'0'),
						(isset($post_array['skypeSelected'])?'1':'0'),
						(isset($post_array['addContactSelected'])?'1':'0'),
						(isset($post_array['addWeblinkSelected'])?'1':'0'),
						(isset($post_array['addressSelected'])?'1':'0'),
						
						(isset($post_array['viberSelected'])?'1':'0'),
						(isset($post_array['facebookSelected'])?'1':'0'),
						(isset($post_array['twitterSelected'])?'1':'0'),
						(isset($post_array['linkedinSelected'])?'1':'0'),
						(isset($post_array['blogSelected'])?'1':'0'),
						
						(isset($post_array['tumblrSelected'])?'1':'0'),
						(isset($post_array['soundCloudSelected'])?'1':'0'),
						(isset($post_array['youTubeSelected'])?'1':'0'),
						(isset($post_array['googlePlusSelected'])?'1':'0'),
						(isset($post_array['spotifySelected'])?'1':'0'),
						
						(isset($post_array['promotionSelected'])?'1':'0'),
						(isset($post_array['calenderSelected'])?'1':'0'),
						(isset($post_array['customerServiceSelected'])?'1':'0'),
						(isset($post_array['appStoreSelected'])?'1':'0'),
						(isset($post_array['shareFilesSelected'])?'1':'0'),
						
						(isset($post_array['requestMeetingSelected'])?'1':'0'),
						(isset($post_array['ticketsSelected'])?'1':'0'),
						(isset($post_array['playStoreSelected'])?'1':'0'),
						$post_array['selectedOptions'] );
		
		$result 	= $this->insertInto($sql, $bindParams);
		$insertedId = $this->sqlInsertId();
		return $insertedId;
	}
	function getSelectedOptions($template_id)
	{
		$sql = "select ct.*, cd.id as card_id from `cardTemplate` as ct left join `cardDetails` as cd on (ct.id = cd.fkCardTemplateId) where ct.fkUserId = ? and ct.id = ? ";
		
		$bindParams = array($_SESSION['tac_data']['user_id'], $template_id);
		
		$result = $this->sqlQueryArray($sql, $bindParams);
		return $result;
	}
	function getSelectedOptionsByCard($cardId)
	{
		$sql = "select ct.* from `cardTemplate` as ct left join `cardDetails` as cd on (ct.id = cd.fkCardTemplateId) where cd.fkUserId = ? and cd.id = ? ";
		$bindParams = array($_SESSION['tac_data']['user_id'], $cardId);
		$result = $this->sqlQueryArray($sql, $bindParams);
		return $result;
	}
	function updateCardTemplate($post_array, $template_id)
	{
		$bindParams = array(
						$post_array['cardType'],
						$post_array['buttonFormat'],
						$post_array['buttonStyle'],
						$post_array['cardColour_1'],
						$post_array['cardColour_2'],
						
						((isset($post_array['phoneNumberSelected']) && $post_array['phoneNumberSelected'] != '')?'1':'0'),
						((isset($post_array['websiteSelected']) && $post_array['websiteSelected'] != '')?'1':'0'),
						((isset($post_array['emailSelected']) && $post_array['emailSelected'] != '')?'1':'0'),
						((isset($post_array['smsSelected']) && $post_array['smsSelected'] != '')?'1':'0'),
						((isset($post_array['skypeSelected']) && $post_array['skypeSelected'] != '')?'1':'0'),
						
						((isset($post_array['addContactSelected']) && $post_array['addContactSelected'] != '')?'1':'0'),
						((isset($post_array['addWeblinkSelected']) && $post_array['addWeblinkSelected'] != '')?'1':'0'),
						((isset($post_array['addressSelected']) && $post_array['addressSelected'] != '')?'1':'0'),
						((isset($post_array['viberSelected']) && $post_array['viberSelected'] != '')?'1':'0'),
						((isset($post_array['facebookSelected']) && $post_array['facebookSelected'] != '')?'1':'0'),
						
						((isset($post_array['twitterSelected']) && $post_array['twitterSelected'] != '')?'1':'0'),
						((isset($post_array['linkedinSelected']) && $post_array['linkedinSelected'] != '')?'1':'0'),
						((isset($post_array['blogSelected']) && $post_array['blogSelected'] != '')?'1':'0'),
						((isset($post_array['tumblrSelected']) && $post_array['tumblrSelected'] != '')?'1':'0'),
						((isset($post_array['soundCloudSelected']) && $post_array['soundCloudSelected'] != '')?'1':'0'),
						
						((isset($post_array['youTubeSelected']) && $post_array['youTubeSelected'] != '')?'1':'0'),
						((isset($post_array['googlePlusSelected']) && $post_array['googlePlusSelected'] != '')?'1':'0'),
						((isset($post_array['spotifySelected']) && $post_array['spotifySelected'] != '')?'1':'0'),
						((isset($post_array['promotionSelected']) && $post_array['promotionSelected'] != '')?'1':'0'),
						((isset($post_array['calenderSelected']) && $post_array['calenderSelected'] != '')?'1':'0'),
						
						((isset($post_array['customerServiceSelected']) && $post_array['customerServiceSelected'] != '')?'1':'0'),
						((isset($post_array['appStoreSelected']) && $post_array['appStoreSelected'] != '')?'1':'0'),
						((isset($post_array['shareFilesSelected']) && $post_array['shareFilesSelected'] != '')?'1':'0'),
						((isset($post_array['requestMeetingSelected']) && $post_array['requestMeetingSelected'] != '')?'1':'0'),
						((isset($post_array['ticketsSelected']) && $post_array['ticketsSelected'] != '')?'1':'0'),
						
						((isset($post_array['playStoreSelected']) && $post_array['playStoreSelected'] != '')?'1':'0'),
						$post_array['selectedOptions'],
						$template_id );
	
		$sql = " update `cardTemplate` set		modifiedDate			=	now(),
												cardType				=	?,
												buttonFormat 			=	?,
												buttonStyle				=	?,
												cardColour				=	?,
												headerColour			=	?,
												
												phoneNumberSelected		=	?,
												websiteSelected			=	?,
												emailSelected			=	?,
												smsSelected				=	?,
												skypeSelected			=	?,
												
												addContactSelected		=	?,
												addWeblinkSelected		=	?,
												addressSelected			=	?,
												viberSelected			=	?,
												facebookSelected		=	?,
												
												twitterSelected			=	?,
												linkedinSelected		=	?,
												blogSelected			=	?,
												tumblrSelected			=	?,
												soundCloudSelected		=	?,
												
												youTubeSelected			=	?,
												googlePlusSelected		=	?,
												spotifySelected			=	?,
												promotionSelected		=	?,
												calenderSelected		=	?,
												
												customerServiceSelected	=	?,
												appStoreSelected		=	?,
												shareFilesSelected		=	?,
												requestMeetingSelected	=	?,
												ticketsSelected			=	?,
												
												playStoreSelected		=	?,
												selectedOptions			=	?
												where 	id				=	? ";
		$result 	= $this->updateInto($sql, $bindParams);
		return $insertedId;
	}
}
?>
