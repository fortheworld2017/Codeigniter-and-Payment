<?php 
class CardDetailsModel extends Model
{
	function getTotalRecordCount()
	{
		$result = $this->sqlCalcFoundRows();
		return $result;
	}
	
	function checkExist($fields, $condition, $bindParams = null)
	{
		$sql = "select ".$fields. " from `cardDetails` where 1 and ".$condition;
		$result = $this->sqlQueryArray($sql, $bindParams);
		if(count($result) == 0)
			return false;
		else
			return $result;
	}
	
	function insertCardDetails($post_array,$shorturl)
	{
		$sql = "insert into `cardDetails` set	fkUserId			=	?,
												fkCardTemplateId	=	?,
												name 				=	?,
												title				=	?,
												position			=	?,
												
												company				=	?,
												shortUrl			=	?,
												logoName			=	?,
												logoExt				=	?,
												profileName			=	?,
												
												profileExt			=	?,
												bannerName			=	?,
												bannerExt			=	?,
												promotionImgName	=	?,
												promotionExt		=	?,
												
												phoneNumber			=	?,
												website				=	?,
												email				=	?,
												sms					=	?,
												skype				=	?,
												
												addContact			=	?,
												addWeblink			=	?,
												address				=	?,
												viber				=	?,
												facebook			=	?,
												
												twitter				=	?,
												linkedin			=	?,
												blog				=	?,
												tumblr				=	?,
												soundCloud			=	?,
												
												youTube				=	?,
												googlePlus			=	?,
												spotify				=	?,
												calender			=	?,
												customerService		=	?,
												
												appStore			=	?,
												shareFile			=	?,
												shareFileExt		=	?,
												requestMeeting		=	?,
												tickets				=	?,
												
												playStore			=	?,
												createdDate			=	now(),
												modifiedDate		=	now(),
												deletedStatus		=	1";
		
		$bindParams = array(
						$_SESSION['tac_data']['user_id'],
						$_SESSION['tac_data']['template_id'],
						(isset($post_array['name'])? $post_array['name']:''),
						(isset($post_array['title'])? $post_array['title']:''),
						(isset($post_array['position'])? $post_array['position']:''),
						
						(isset($post_array['company'])? $post_array['company']:''),
						$shorturl,
						(isset($post_array['logoName'])? $post_array['logoName']:''),
						(isset($post_array['logoExt'])? $post_array['logoExt']:''),
						(isset($post_array['profileName'])? $post_array['profileName']:''),
						
						(isset($post_array['profileExt'])? $post_array['profileExt']:''),
						(isset($post_array['bannerName'])? $post_array['bannerName']:''),
						(isset($post_array['bannerExt'])? $post_array['bannerExt']:''),
						(isset($post_array['promotionImgName'])? $post_array['promotionImgName']:''),
						(isset($post_array['promotionExt'])? $post_array['promotionExt']:''),
						
						(isset($post_array['phoneNumber'])? $post_array['phoneNumber']:''),
						(isset($post_array['website'])? $post_array['website']:''),
						(isset($post_array['email'])? $post_array['email']:''),
						(isset($post_array['sms'])? $post_array['sms']:''),
						(isset($post_array['skype'])? $post_array['skype']:''),
						
						(isset($post_array['addContact'])? $post_array['addContact']:''),
						(isset($post_array['addWeblink'])? $post_array['addWeblink']:''),
						(isset($post_array['address'])? $post_array['address']:''),
						(isset($post_array['viber'])? $post_array['viber']:''),
						(isset($post_array['facebook'])? $post_array['facebook']:''),
						
						(isset($post_array['twitter'])? $post_array['twitter']:''),
						(isset($post_array['linkedin'])? $post_array['linkedin']:''),
						(isset($post_array['blog'])? $post_array['blog']:''),
						(isset($post_array['tumblr'])? $post_array['tumblr']:''),
						(isset($post_array['soundCloud'])? $post_array['soundCloud']:''),
						
						(isset($post_array['youTube'])? $post_array['youTube']:''),
						(isset($post_array['googlePlus'])? $post_array['googlePlus']:''),
						(isset($post_array['spotify'])? $post_array['spotify']:''),
						(isset($post_array['calender'])? $post_array['calender']:''),
						(isset($post_array['customerService'])? $post_array['customerService']:''),
						
						(isset($post_array['appStore'])? $post_array['appStore']:''),
						(isset($post_array['shareFile'])? $post_array['shareFile']:''),
						(isset($post_array['shareFileExt'])? $post_array['shareFileExt']:''),
						(isset($post_array['requestMeeting'])? $post_array['requestMeeting']:''),
						(isset($post_array['tickets'])? $post_array['tickets']:''),
						
						(isset($post_array['playStore'])? $post_array['playStore']:'') );
		
		$result 	= $this->insertInto($sql, $bindParams);
		$insertedId = $this->sqlInsertId();
		return $insertedId;
	}
	
	function updateCardDesignDetails($post_array)
	{
		$sql = "update `cardDetails` set 	cardDesignStyle	=	?,
											cardDesignType	=	?,
											totalCards		=	?,
											totalPrice		=	?
											where id		=	? ";
		
		$bindParams = array(
						$post_array['cardStyle'],
						$post_array['cardType'],
						$post_array['totalCards'],
						$post_array['totalPrice'],
						$_SESSION['tac_data']['cardId'] );
		
		$this->updateInto($sql, $bindParams);
	}
	
	function updateStickerDesignDetails($post_array, $stick_img_name, $sticker_ext)
	{
		$sql = "update `cardDetails` set 	stickerImgName	=	?,
											stickerImgExt	=	?,
											stickerStyle	=	?,
											stickerType		=	?,
											totalCards		=	?,
											totalPrice		=	?
											where id		=	? ";
		
		$bindParams = array(
						$stick_img_name,
						$sticker_ext,
						$post_array['stickerStyle'],
						$post_array['stickerType'],
						$post_array['totalCards'],
						$post_array['totalPrice'],
						$_SESSION['tac_data']['cardId'] );
		
		$this->updateInto($sql, $bindParams);
	}
	
	function updateTagDesignDetails($post_array)
	{
		$sql = "update `cardDetails` set 	tagSize		=	?,
											totalCards	=	?,
											totalPrice	=	?
											where id	=	? ";
		
		$bindParams = array(
						$post_array['tagSize'],
						$post_array['totalCards'],
						$post_array['totalPrice'],
						$_SESSION['tac_data']['cardId'] );
		
		$this->updateInto($sql, $bindParams);
	}
	
	function updateCardDetails($post_array,$card_id)
	{
		$sql = "update `cardDetails` set	modifiedDate		=	now(),
											
											name 				=	?,
											title				=	?,
											position			=	?,
											company				=	?,
											logoName			=	?,
											
											logoExt				=	?,
											profileName			=	?,
											profileExt			=	?,
											bannerName			=	?,
											bannerExt			=	?,
											
											promotionImgName	=	?,
											promotionExt		=	?,
											phoneNumber			=	?,
											website				=	?,
											email				=	?,
											
											sms					=	?,
											skype				=	?,
											addContact			=	?,
											addWeblink			=	?,
											address				=	?,
											
											viber				=	?,
											facebook			=	?,
											twitter				=	?,
											linkedin			=	?,
											blog				=	?,
											
											tumblr				=	?,
											soundCloud			=	?,
											youTube				=	?,
											googlePlus			=	?,
											spotify				=	?,
											
											calender			=	?,
											customerService		=	?,
											appStore			=	?,
											shareFile			=	?,
											shareFileExt		=	?,
											
											requestMeeting		=	?,
											tickets				=	?,
											playStore			=	?
											where		id		=	? ";
		
		$bindParams = array(
						(isset($post_array['name'])? $post_array['name']:''),
						(isset($post_array['title'])? $post_array['title']:''),
						(isset($post_array['position'])? $post_array['position']:''),
						(isset($post_array['company'])? $post_array['company']:''),
						(isset($post_array['logoName'])? $post_array['logoName']:''),
						
						(isset($post_array['logoExt'])? $post_array['logoExt']:''),
						(isset($post_array['profileName'])? $post_array['profileName']:''),
						(isset($post_array['profileExt'])? $post_array['profileExt']:''),
						(isset($post_array['bannerName'])? $post_array['bannerName']:''),
						(isset($post_array['bannerExt'])? $post_array['bannerExt']:''),
						
						(isset($post_array['promotionImgName'])? $post_array['promotionImgName']:''),
						(isset($post_array['promotionExt'])? $post_array['promotionExt']:''),
						(isset($post_array['phoneNumber'])? $post_array['phoneNumber']:''),
						(isset($post_array['website'])? $post_array['website']:''),
						(isset($post_array['email'])? $post_array['email']:''),
						
						(isset($post_array['sms'])? $post_array['sms']:''),
						(isset($post_array['skype'])? $post_array['skype']:''),
						(isset($post_array['addContact'])? $post_array['addContact']:''),
						(isset($post_array['addWeblink'])? $post_array['addWeblink']:''),
						(isset($post_array['address'])? $post_array['address']:''),
						
						(isset($post_array['viber'])? $post_array['viber']:''),
						(isset($post_array['facebook'])? $post_array['facebook']:''),
						(isset($post_array['twitter'])? $post_array['twitter']:''),
						(isset($post_array['linkedin'])? $post_array['linkedin']:''),
						(isset($post_array['blog'])? $post_array['blog']:''),
						
						(isset($post_array['tumblr'])? $post_array['tumblr']:''),
						(isset($post_array['soundCloud'])? $post_array['soundCloud']:''),
						(isset($post_array['youTube'])? $post_array['youTube']:''),
						(isset($post_array['googlePlus'])? $post_array['googlePlus']:''),
						(isset($post_array['spotify'])? $post_array['spotify']:''),
						
						(isset($post_array['calender'])? $post_array['calender']:''),
						(isset($post_array['customerService'])? $post_array['customerService']:''),
						(isset($post_array['appStore'])? $post_array['appStore']:''),
						(isset($post_array['shareFile'])? $post_array['shareFile']:''),
						(isset($post_array['shareFileExt'])? $post_array['shareFileExt']:''),
						
						(isset($post_array['requestMeeting'])? $post_array['requestMeeting']:''),
						(isset($post_array['tickets'])? $post_array['tickets']:''),
						(isset($post_array['playStore'])? $post_array['playStore']:''),
						$card_id );
		
		$result = $this->updateInto($sql, $bindParams);
		return $result;
	}
	
	function getCardDetails($fields, $condition, $orderBy, $bindParams = NULL)
	{
		$limit_clause = '';
		if(isset($_SESSION['curpage']))
			$limit_clause = ' LIMIT '.(($_SESSION['curpage'] - 1) * ($_SESSION['perpage'])) . ', '. $_SESSION['perpage'];
		
		$sql = " select SQL_CALC_FOUND_ROWS ".$fields. " 
			from `cardTemplate` as ct 
			left join `cardDetails` as cd on (cd.fkCardTemplateId = ct.id) 
		   where 1 ".$condition;
		
		$result = $this->sqlQueryArray($sql, $bindParams);
		if(count($result) == 0)
			return false;
		else
			return $result;
	}
	
	function getData($fields, $tableName, $condition, $bindParams = NULL)
	{
		$sql = "select ".$fields. " from ".$tableName." where ".$condition;
		$result = $this->sqlQueryArray($sql, $bindParams);
		
		if(count($result) == 0)
			return false;
		else
			return $result;
	}
	
	function getCardList($fields, $condition, $orderBy, $bindParams = NULL)
	{
		$limit_clause = '';
		if(!is_array($bindParams))
			$bindParams = array();
			
		if(isset($_SESSION['curpage']))
			$limit_clause = ' LIMIT '.(($_SESSION['curpage'] - 1) * ($_SESSION['perpage'])) . ', '. $_SESSION['perpage'];
		
		if(isset($_SESSION['ses_filter_name']) && $_SESSION['ses_filter_name'] !='')
		{
			$condition .= ' and cd.name LIKE CONCAT("%",?,"%") ';
			$bindParams[] = $_SESSION['ses_filter_name'];
		}
		if(isset($_SESSION['ses_filter_email']) && $_SESSION['ses_filter_email'] !='')
		{
			$condition .= ' and cd.email LIKE CONCAT("%",?,"%") ';
			$bindParams[] = $_SESSION['ses_filter_email'];
		}
		if(isset($_SESSION['ses_domain_name']) && $_SESSION['ses_domain_name'] !='')
		{
			$condition .= ' and d.id  = ? ';
			$bindParams[] = $_SESSION['ses_domain_name'];
		}
		
		$sql = " select SQL_CALC_FOUND_ROWS ".$fields. " 
			      from `cardDetails` as cd 
				   left join `domainDetails` as dd on(cd.id = dd.fkCardDetailsId)
				   left join `domain` as d on(d.name = dd.domainName) 
				  where 1 ".$condition." ".$orderBy." ".$limit_clause;
		
		$result = $this->sqlQueryArray($sql, $bindParams);
		if(count($result) == 0)
			return false;
		else
			return $result;
	}
	
	function deleteCard($card_id)
	{
		$sql = "update `cardDetails` set `deletedStatus` = 2 where id in (?) ";
		$result = $this->updateInto($sql, array($card_id));
		return $result;
	}
	
	function updateCardAdmin($cond,$where, $bindParams = NULL)
	{
		$sql = "update `cardDetails` set $cond where 1 $where ";
		$result = $this->updateInto($sql, $bindParams);
		return $result;
	}
	
	function updateShortUrl($card_id, $shorturl)
	{
		$sql = " update `cardDetails` set  `shortUrl` = ?  where `id` = ? ";
		$bindParams = array($shorturl, $card_id);
		$result = $this->updateInto($sql, $bindParams);
		
		if($result)
		{
			$sql = " update `domainDetails` set  `shortUrl` = ?  where `fkCardDetailsId` = ? ";
			$this->updateInto($sql, $bindParams);
		}
		
		return $result;
		
	}
	
	function insertRecentActivityDetails($card_id, $activity, $cardName)
	{
		$sql = "insert into `recentActivity` set	fkUserId		=	?,
													fkCardDetailsId	=	?,
													cardType		=	?,
													cardName		=	?,
													activity		=	?,
													date			=	now()";
		
		$bindParams = array(
						$_SESSION['tac_data']['user_id'],
						$card_id,
						$_SESSION['tac_data']['cardType'],
						$cardName,
						$activity );
		
		$result 	= $this->insertInto($sql, $bindParams);
		$insertedId = $this->sqlInsertId();
		return $insertedId;
	}
	
	function getRecentActivityDetails()
	{
		$sql = "select * from `recentActivity` where fkUserId = ? order by date desc";
		$result = $this->sqlQueryArray($sql, array($_SESSION['tac_data']['user_id']));
		if(count($result) == 0)
			return false;
		else
			return $result;
	}
	
	function getExistGroupList($chkoutStatus)
	{
		$sql = "select g.id, g.groupName, count(cd.fkCardTemplateId) as order_count 
		         from `group` as g 
		     left join cardGroups  as cg on (g.id = cg.fkGroupId) 
		     left join cardDetails as cd on (cg.fkCardTemplateId = cd.fkCardTemplateId) 
		    where cd.checkoutStatus = ? and cd.fkUserId = ?  and cg.fkUserId = ? and  cd.deletedStatus = 1 
		    group by cg.fkGroupId order by g.id";
		
		$bindParams = array( $chkoutStatus, 
							 $_SESSION['tac_data']['user_id'], 
							 $_SESSION['tac_data']['user_id'] );
		
		$result = $this->sqlQueryArray($sql, $bindParams);
		if(count($result) == 0)
			return false;
		return $result;
	}
	
	function getOrdersDetail($condition, $bindParams = NULL)
	{
		$sql = "select cd.id, cd.fkUserid, cd.name, cd.title, cd.company, cd.phoneNumber, cd.email, 
					   cd.checkoutStatus, cd.createdDate, cd.cardDesignStyle, cd.cardDesignType, 
					   cd.totalCards, cd.totalPrice, cd.cardDesignStyle, cd.cardDesignType, 
					   cd.stickerStyle, cd.stickerType, ct.id as templateId, ct.cardType, ct.mediaType 
				 from `cardDetails` as cd 
				 left join `cardTemplate` as ct on (ct.id = cd.fkCardTemplateId) 
				 left join `cardGroups`   as cg on (cg.fkCardTemplateId = cd.fkCardTemplateId) 
				where ".$condition;
		
		$result = $this->sqlQueryArray($sql, $bindParams);
		if(count($result) == 0)
			return false;
		return $result;
	}
	
	function insertDomainDetails($card_id, $domain_name, $shorturl)
	{
		$sql = "insert into domainDetails set	fkCardDetailsId  = ?,
												domainName       = ?,
												shortUrl         = ? ";
		
		$bindParams = array( $card_id,
							 $domain_name,
							 $shorturl);
		
		$result     = $this->insertInto($sql, $bindParams);
		$insertedId = $this->sqlInsertId();
		
		return $insertedId;
	}
	
	function checkCardDomain($domain_name, $shorturl)
	{
		$sql = "select * from domainDetails where domainName = ? and shortUrl = ?";
		$bindParams = array($domain_name, $shorturl);
		$result = $this->sqlQueryArray($sql, $bindParams);
		if(count($result) == 0)
			return false;
		else
			return $result;
	}
	
	function getCardDomain($shorturl)
	{
		$sql = "select domainName from domainDetails where shortUrl = ? ";
		$result = $this->sqlQueryArray($sql, array($shorturl));
		if(count($result) == 0)
			return SITE_PATH;
		else
		{
			$domain_name = $result[0]->domainName;
			return "http://".$domain_name."/";
		}
	}
	
}
?>
