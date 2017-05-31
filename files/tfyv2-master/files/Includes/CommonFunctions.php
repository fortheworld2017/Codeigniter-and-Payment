<?php
ini_set("memory_limit","100M");

/********************************************************
  * Function Name: escapeSpecialCharacters
  * Purpose: Escapes special characters in a string for use in an SQL statement
  * $data   - array or text
  *******************************************************/
 function escapeSpecialCharacters($data)
{
	global $globalDbManager;

	//$data = trim($data);
	if (get_magic_quotes_gpc())
		return $data; //No need to escape data if magic quotes is turned on
	$data = is_array($data) ? array_map('escapeSpecialCharacters', $data) : mysqli_real_escape_string($globalDbManager->dbConnect,strip_tags(trim($data)));
    return $data;
} 
/********************************************************
  * Function Name: unEscapeSpecialCharacters
  * Purpose: UnEscapes special characters in a string for use in an SQL statement
  * $data   - array or text
  *******************************************************/
 function unEscapeSpecialCharacters($data){
	$data = is_array($data) ? array_map('unEscapeSpecialCharacters', $data) :stripslashes(trim($data));
    return $data;
}

function destroyPagingControlsVariables() { //clear paging session variables
	unset($_SESSION["orderby"]);
	unset($_SESSION["ordertype"]);
	unset($_SESSION["curpage"]);
	unset($_SESSION["perpage"]);
}
//set paging session variables
function setPagingControlValues($default_field,$per_page) {
	if(isset($_POST['per_page']))
		$_SESSION['perpage'] = $_POST['per_page'];
	elseif(!isset($_SESSION['perpage']))
		$_SESSION['perpage'] = $per_page;
	
	if(isset($_POST['cur_page']))
		$_SESSION['curpage'] = $_POST['cur_page'];
	elseif(!isset($_SESSION['curpage']))
		$_SESSION['curpage'] = 1;
	
	if(isset($_POST['order_by']))
		$_SESSION['orderby'] = $_POST['order_by'];
	elseif(!isset($_SESSION['orderby']))
		$_SESSION['orderby'] = $default_field;
	
	if(isset($_POST['order_type']))
		$_SESSION['ordertype'] = $_POST['order_type'];
	elseif(!isset($_SESSION['ordertype']))
		$_SESSION['ordertype'] = 'DESC';
}

/*  Displays the sort icons for the column headings
 Paramters => 	column : field in the database that is merged in the ORDER BY clause of the query
					title  : column name to be displayed on the screen.
 Output	 =>		Returns as a Hyperlink with given column and field.
 */
function SortColumn($column, $title)
{
	$sort_type = 'ASC';
	$sort_image = 'no_sort.gif';
	if (($_SESSION['orderby'] == $column) && ($_SESSION['ordertype'] == 'ASC')){  //asc
		$sort_type = 'DESC';
		$sort_image = 'asc.gif';
	}
	elseif (($_SESSION['orderby'] == $column) && ($_SESSION['ordertype'] == 'DESC')){ //desc
		$sort_type = 'ASC';
		$sort_image = 'desc.gif';
	}
	$alt_title = 'Sort by '.ucfirst(strtolower($title))." ".strtolower($sort_type);
	$sort_link = "<a href=\"#\" onclick=\"javascript:setPagingControlValues('".$column."','".$sort_type."',".$_SESSION['curpage'].");\" alt=\"".$alt_title."\" title=\"".$alt_title."\" >";
	//return $sort_link.'<strong>'.$title.'</strong></a>&nbsp;'.$sort_link.'</a>';//<img src="'.IMAGE_PATH . $sort_image.'" alt="" border="0">
	return $sort_link.'<strong>'.$title.'</strong></a>&nbsp;'.$sort_link.'<img src="'.ADMIN_IMAGE_PATH . $sort_image.'" alt="" border="0"></a>';
}
// Display paging control
//Input : no. of records and URL
function pagingControl($nrecords,$action='')
{
	$perpage = $_SESSION['perpage'];
	$curpage = $_SESSION['curpage'];
	$paging_html = '<table cellspacing="0" cellpadding="0" width="100%" border="0" align="center">
	<tr>
	<td align=right width="88%" >';
	if ($action == '')
		$action = $_SERVER['SCRIPT_NAME']; ?>
	<form name="paging" id="paging" method="post" action="<?php echo($action);?>"  >
		<input type="Hidden" value="<?php echo($_SESSION['curpage']);?>" name="cur_page" id="cur_page">
		<input type="Hidden" value="<?php echo($_SESSION['orderby']);?>" name="order_by" id="order_by">
		<input type="Hidden" value="<?php echo($_SESSION['ordertype']);?>" name="order_type" id="order_type">
		<?php if ($nrecords > $perpage)
		{
			$first = 1;
			$prev = $curpage - 1;
			$previous_on 	= '<img src="'.ADMIN_IMAGE_PATH.'previous_on.gif" hspace="5" vspace="5"  border="0">';
			$previous_off 	= '<img src="'.ADMIN_IMAGE_PATH.'previous_off.gif" hspace="5" vspace="5" border="0">';
			$next_on 	    = '<img src="'.ADMIN_IMAGE_PATH.'next_on.gif" hspace="5" vspace="5" border="0">';
			$next_off	    = '<img src="'.ADMIN_IMAGE_PATH.'next_off.gif" hspace="5" vspace="5" border="0">';
			$first_on	    = '<img src="'.ADMIN_IMAGE_PATH.'first_on.gif" hspace="5" vspace="5" border="0">';
			$first_off	    = '<img src="'.ADMIN_IMAGE_PATH.'first_off.gif" hspace="5" vspace="5" border="0">';
			$last_on		= '<img src="'.ADMIN_IMAGE_PATH.'last_on.gif" hspace="5" vspace="5"  border="0">';
			$last_off	    = '<img src="'.ADMIN_IMAGE_PATH.'last_off.gif" hspace="5" vspace="5" border="0">';

			$paging_html .= "<table cellpadding='0' cellspacing='0' border='0' align='center'> <tr>";
			if ($curpage != '1')
				$paging_html .= " <td valign='top'> <a href='#' title='Show first page'  onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".$first.");\"><b>$first_on</b></a></td> <td width='5'></td>";
			else 
				$paging_html .= " <td valign='top'><b>$first_off</b> </td><td width='5'></td>";
			if ($curpage != '1')	
				$paging_html .= "<td valign='top'> <a href='#' title='Show previous page'  onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".$prev.");\"><b>$previous_on</b></a> </td> <td width='5'></td>";
			else
				$paging_html .=  " <td valign='top'><b>$previous_off</b> </td> <td width='5'></td>";
			if ($nrecords > $perpage){
				$page_cal = 10;
				if ($curpage < $page_cal)
					$lstart = 1;
				else
					$lstart = $curpage - 2;
				//$lstart = 1;
				$lend = floor($nrecords / $perpage);
				if (($nrecords % $perpage) > 0)
					$lend = $lend + 1;
				$last = $lend;
				if ($curpage < $lend)
					$next = $curpage + 1;
				else
					$next = $lend;
				if ($lend > 10)	{
					$c = 0; $t = 0;
					if ($lstart >= 8)
					$lstart = $lstart - 6;
					if (($curpage == ($lend - 1)) || ($curpage == $lend)) // Last page and its previous
					{
						$lstart = $lend - 9;
						$paging_html .=  "<td ><a href='#' title='Show page 1'   onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',1);\">1</a></td> <td width='5'></td>";
						$paging_html .= "<td >...&nbsp;&nbsp;</td>";
					}
					for ($i=$lstart;$i<=$lend;$i++){
						if ($lstart >= ($lend - 9))
						{
							if ($i == $lstart)
								$paging_html .=  "<td width='5' align='center' ><a href='#' title='Show page $i'  onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".($i).");\">".$i."</a></td> <td width='5'></td>";
							else if ($i == $curpage)
								$paging_html .=   "<td style='color:#C62032' ><b>".$i."</b>&nbsp;&nbsp;</td>";
							else if ($c < $page_cal)
								$paging_html .=  "<td  width='5' align='center' ><a href='#'  title='Show page $i' onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".($i).");\">".$i."</a></td> <td width='5'></td>";
						}
						else
						{
							if ($i == $curpage)
								$paging_html .= "<td style='color:#C62032'><b>".$i . "</b>&nbsp;&nbsp;</td>";
							else if ($c < $page_cal)
								$paging_html .=  "<td width='5' align='center'  ><a href='#' title='Show page $i' onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".($i).");\">".$i."</a></td> <td width='5'></td>";
							else if ($t == 0)
							{
								$t = 1;
								$paging_html .= "<td >...&nbsp;&nbsp;</td>";
								$paging_html .=  "<td  width='5' align='center' ><a href='#' title='Show page $lend' onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".($lend).");\">".$lend."</a></td> <td width='5'></td>";
							}
							$c++;
						}
						if ($t == 1)
							break;
					}//end for
				}//end if
				else
				{
					for($i=$lstart;$i<=$lend;$i++){
						if ($curpage == $i)
							$paging_html .=  "<td  style='color:#C62032'><b>".$i."</b></td> <td width='5'></td>";
						else
							$paging_html .=  "<td  ><a href='#' title='Show page $i' onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".($i).");\">".$i."</a></td> <td width='5'></td>";
					}
				}
			}
			if ($curpage == $lend)
				$paging_html .= " <td > <b>$next_off</b> </td><td width='5'></td>";
			else
				$paging_html .= " <td ><a href='#' title='Show next page'   onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".$next.");\"> <b>$next_on</b></a></td><td width='5'></td> ";
			if ($last != $curpage)
				$paging_html .= "<td > <a href='#' title='Show last page'  onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".$last.");\"><b>$last_on</b></a></td><td width='5'></td> ";
			else
				$paging_html .= " <td ><b>$last_off</b></td> <td width='5'></td>";
			$paging_html.="</tr>	</table></td>";
		}
		echo $paging_html;?>
		<td align="right" class="record" width="15%">
		<? $per_page_array =  eval(ADMIN_PER_PAGE_ARRAY);
		if($nrecords > $per_page_array[0]){ ?>
			<strong>Per page </strong>			
			<select name="per_page" id="per_page" onchange="setPerPage(this.value);" style="width:52px;">
			<?php foreach($per_page_array as $value){?>
				<option value="<?php echo($value);?>" <? if($perpage == $value) echo " selected='selected'"?>><?php echo($value);?></option>
			<?php }?>
			</select>	
		<?php }?>
		</td></tr></table>
	</form>
<?php }
function userPagination($nrecords,$action='')
{
	$perpage = $_SESSION['perpage'];
	$curpage = $_SESSION['curpage'];
	$paging_html = '<table cellspacing="0" cellpadding="0" width="100%" border="0" align="center">
	<tr>
	<td align=right width="88%" >';
	if ($action == '')
		$action = $_SERVER['SCRIPT_NAME']; ?>
	<form name="paging" id="paging" method="post" action="<?php echo($action);?>"  >
		<input type="Hidden" value="<?php echo($_SESSION['curpage']);?>" name="cur_page" id="cur_page">
		<input type="Hidden" value="<?php echo($_SESSION['orderby']);?>" name="order_by" id="order_by">
		<input type="Hidden" value="<?php echo($_SESSION['ordertype']);?>" name="order_type" id="order_type">
		<?php if ($nrecords > $perpage)
		{
			$first = 1;
			$prev = $curpage - 1;
			$previous_on 	= '<img src="'.IMAGE_PATH.'previous_on.gif" hspace="5" vspace="5"  border="0">';
			$previous_off 	= '<img src="'.IMAGE_PATH.'previous_off.gif" hspace="5" vspace="5" border="0">';
			$next_on 	    = '<img src="'.IMAGE_PATH.'next_on.gif" hspace="5" vspace="5" border="0">';
			$next_off	    = '<img src="'.IMAGE_PATH.'next_off.gif" hspace="5" vspace="5" border="0">';
			$first_on	    = '<img src="'.IMAGE_PATH.'first_on.gif" hspace="5" vspace="5" border="0">';
			$first_off	    = '<img src="'.IMAGE_PATH.'first_off.gif" hspace="5" vspace="5" border="0">';
			$last_on		= '<img src="'.IMAGE_PATH.'last_on.gif" hspace="5" vspace="5"  border="0">';
			$last_off	    = '<img src="'.IMAGE_PATH.'last_off.gif" hspace="5" vspace="5" border="0">';

			$paging_html .= "<table cellpadding='0' cellspacing='5' border='0' align='center' class='paging'> <tr>";
			if ($curpage != '1')
				$paging_html .= " <td valign='top'> <a href='#' title='Show first page'  onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".$first.");\"><b>$first_on</b></a></td> <td width='5'></td>";
			else 
				$paging_html .= " <td valign='top'><b>$first_off</b> </td><td width='5'></td>";
			if ($curpage != '1')	
				$paging_html .= "<td valign='top'> <a href='#' title='Show previous page'  onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".$prev.");\"><b>$previous_on</b></a> </td> <td width='5'></td>";
			else
				$paging_html .=  " <td valign='top'><b>$previous_off</b> </td> <td width='5'></td>";
			if ($nrecords > $perpage){
				$page_cal = 10;
				if ($curpage < $page_cal)
					$lstart = 1;
				else
					$lstart = $curpage - 2;
				//$lstart = 1;
				$lend = floor($nrecords / $perpage);
				if (($nrecords % $perpage) > 0)
					$lend = $lend + 1;
				$last = $lend;
				if ($curpage < $lend)
					$next = $curpage + 1;
				else
					$next = $lend;
				if ($lend > 10)	{
					$c = 0; $t = 0;
					if ($lstart >= 8)
					$lstart = $lstart - 6;
					if (($curpage == ($lend - 1)) || ($curpage == $lend)) // Last page and its previous
					{
						$lstart = $lend - 9;
						$paging_html .=  "<td ><a href='#' title='Show page 1'   onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',1);\">1</a></td> <td width='5'></td>";
						$paging_html .= "<td >...&nbsp;&nbsp;</td>";
					}
					for ($i=$lstart;$i<=$lend;$i++){
						if ($lstart >= ($lend - 9))
						{
							if ($i == $lstart)
								$paging_html .=  "<td width='5' align='center' ><a href='#' title='Show page $i'  onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".($i).");\">".$i."</a></td> <td width='5'></td>";
							else if ($i == $curpage)
								$paging_html .=   "<td style='color:#C62032' ><b>".$i."</b>&nbsp;&nbsp;</td>";
							else if ($c < $page_cal)
								$paging_html .=  "<td  width='5' align='center' ><a href='#'  title='Show page $i' onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".($i).");\">".$i."</a></td> <td width='5'></td>";
						}
						else
						{
							if ($i == $curpage)
								$paging_html .= "<td style='color:#C62032'><b>".$i . "</b>&nbsp;&nbsp;</td>";
							else if ($c < $page_cal)
								$paging_html .=  "<td width='5' align='center'  ><a href='#' title='Show page $i' onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".($i).");\">".$i."</a></td> <td width='5'></td>";
							else if ($t == 0)
							{
								$t = 1;
								$paging_html .= "<td >...&nbsp;&nbsp;</td>";
								$paging_html .=  "<td  width='5' align='center' ><a href='#' title='Show page $lend' onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".($lend).");\">".$lend."</a></td> <td width='5'></td>";
							}
							$c++;
						}
						if ($t == 1)
							break;
					}//end for
				}//end if
				else
				{
					for($i=$lstart;$i<=$lend;$i++){
						if ($curpage == $i)
							$paging_html .=  "<td  style='color:#C62032'><b>".$i."</b></td> <td width='5'></td>";
						else
							$paging_html .=  "<td  ><a href='#' title='Show page $i' onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".($i).");\">".$i."</a></td> <td width='5'></td>";
					}
				}
			}
			if ($curpage == $lend)
				$paging_html .= " <td > <b>$next_off</b> </td><td width='5'></td>";
			else
				$paging_html .= " <td ><a href='#' title='Show next page'   onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".$next.");\"> <b>$next_on</b></a></td><td width='5'></td> ";
			if ($last != $curpage)
				$paging_html .= "<td > <a href='#' title='Show last page'  onclick=\"javascript:setPagingControlValues('".$_SESSION['orderby']."','".$_SESSION['ordertype']."',".$last.");\"><b>$last_on</b></a></td><td width='5'></td> ";
			else
				$paging_html .= " <td ><b>$last_off</b></td> <td width='5'></td>";
			$paging_html.="</tr>	</table></td>";
		}
		echo $paging_html;?>
		</tr></table>
	</form>
<?php }
/*
* list($salt, $passwd) = mkRandPasswd();
* $str_passwd = substr($salt, strlen($salt) / 4, PASSWD_LEN);
*/
function mkRandPasswd()
{
    define('NUM0', 48);
    define('NUM9', 57);
    define('LETA', 65);
    define('LETZ', 90);
    define('LETa', 97);
    define('LETz', 122);
    $salt = '';
    $passwd = '';
    define('PASSWD_LEN', 6);
    for($nLoop = 0; $nLoop < NUM9 - NUM0 + 1; $nLoop++)
        $salt .= chr(mt_rand(NUM0, NUM9));
    for($ucLoop = 0; $ucLoop < LETZ - LETA + 1; $ucLoop++)
        $salt .= chr(mt_rand(LETA, LETZ));
    for($lcLoop = 0; $lcLoop < LETz - LETa + 1; $lcLoop++)
        $salt .= chr(mt_rand(LETa, LETz));
    $salt = str_shuffle($salt);
    for($gen = 0; $gen < PASSWD_LEN; $gen++)
        $passwd = $passwd . substr($salt, mt_rand() % strlen($salt), 1);
    return array($salt, $passwd);
}


function getCurrPage()
{
	$page = substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1);
	$page=explode('?',$page);
	if(is_array($page))
		$page=$page[0];
	return $page;
}

function seoSettingsFileRead()
{
	$filePath				= ABS_PATH.'WebResources/SeoSettings/';
	if(file_exists($filePath.'seosettings.txt')) {
		$seosettings_content 	= file_get_contents($filePath.'seosettings.txt');
		if(trim($seosettings_content) != '')
			return 	$seosettings_content;
	}
}

function seoSettingsFileWrite($field1,$field2,$field3)
{
	$filePath = ABS_PATH.'WebResources/SeoSettings/';
	$fp = fopen($filePath.'seosettings.txt', "w+");
    fseek($fp, 0, SEEK_SET); //MOVES THE CURSOR 0 PLACES FROM START OF THE FILE
	$content = '';
	$content .= $field1.'*#*'.$field2.'*#*'.$field3;
    fwrite($fp, $content);
    fclose($fp);
}



/********************************************************
  * Function Name: displayText
  * Purpose: Truncate the text to specified length
  * $text   - Text to be truncated
  * $length - number of character to be viewed
  * $wb     - to handle word boundary 0 - do not preserve word boundary, 1 - preserve word boundary
  *******************************************************/
function displayText($text, $length, $wb=0) {
	$text = strip_tags($text);
	if (strlen($text) > $length) {
		if ($wb == 0)
			return  substr($text, 0, $length) . ' ...';
		else 
		 return  substr($text, 0, strrpos(substr($text, 0, $length), ' ')) . ' ...';
	}
	else
		return $text;
}


//Begin: Function to include css, js files on Header
 function create_entries( $ary, $separator, $prepend='', $append='' ) {
    if (is_array($ary)) {
        $sep = '';
        foreach ($ary as $v) {
            echo $sep.$prepend.$v.$append;
            $sep = $separator;
        }
    }
}
//End: Function to include css, js files on Header

//Begin: Send E-Mail
function sendMail($mailContentArray,$type)
{
	/* Begin: Type definition
	 
	End: Type definition 
	*/
	
	if(is_array($mailContentArray))
	{
		$heardFrom		= 	'';
		$message		=	'';
		$from 	  		=   $mailContentArray['from'];
		$toMail   		=   $mailContentArray['toemail'];
		$subject		= 	$mailContentArray['subject'];
		$file_name       = ABS_PATH.'WebResources/MailContent/'.$mailContentArray['fileName'];
		//if(!is_file($file_name))
			//$file_name  =  '../'.$file_name;
		$mail_data 		= 	file_get_contents($file_name);
		$file_array = explode('/',$mailContentArray['fileName']);
		$type_array = end($file_array);
		$type_extn = explode('.',$type_array);
		
		$headers  		= 	"MIME-Version: 1.0\n";
		$headers 		.= 	"Content-Transfer-Encoding: 8bit\n";
		$headers 		.= 	"From: $from\r\n";
		$headers 		.= 	"Content-type: text/html\r\n";//.'X-Mailer: PHP/' . phpversion();
		
		switch($type)
		{
			case 1:
				// forget password
				$mail_data 			=	str_replace('{USER_NAME}', $mailContentArray['username'], $mail_data);
				$mail_data 			=	str_replace('{USER_PASSWORD}', $mailContentArray['password'], $mail_data);
				$mail_data 			=	str_replace('{FORGET_LINK}', $mailContentArray['forget_link'], $mail_data);
				$mail_data			=	str_replace('{REGARDS_NAME}',$mailContentArray['greetMail'],$mail_data);
				break;
			case 2: //contact
				$mail_data 			=	str_replace('{REGARDS_NAME}', $mailContentArray['name'],$mail_data);
				$mail_data 			=	str_replace('{MESSAGE}', nl2br($mailContentArray['content']),$mail_data);
				break;
			case 3:
				// registration
				$mail_data 			=	str_replace('{USER_NAME}', $mailContentArray['userName'], $mail_data);
				$mail_data 			=	str_replace('{LINK}', $mailContentArray['link'], $mail_data);
				$mail_data			=	str_replace('{REGARDS_NAME}',$mailContentArray['greetMail'],$mail_data);
				break;
		}
		if($_SERVER['HTTP_HOST'] == $_SERVER['TFY_TEST_IP_ADDR']){ 
			echo "<br/>From ==>".$from."<br/>To ==> ".$toMail."<br/>header ==>".$headers."<br/>Subject ==> ".$subject."<br/> ===> ".$mail_data;
			//die();
			return true;
		}
		else {
			if($toMail != '')
			{
				if(mail($toMail, $subject,$mail_data,$headers))
					return true;
				else 
					return false;
			}
			else
				return false;
		}
	}
}
function checkForFiles($files,$file_name,$abs_path,$type=0,$temp_img_name)
{
	if($type == 0 || $type == 4 || $type == 5 || $type == 6)
	{
		$type_error = 'Upload any of jpg, png or gif image.';
		$file_type_array 	=	array(  "1"=>"image/jpeg",
								 	"2"=>"image/pjpeg",
								 	"3"=>"image/gif",
								 	"4"=>"image/png");
	}
	else if($type == 2)
	{
		$file_type_array 	=	array(  "1"=>"image/jpeg","2"=>"image/pjpeg");
		$type_error = 'Upload any of jpg or jpeg image.';
	}
	else if($type == 1)
	{
		$file_type_array 	=	array(  "1"=>"image/png");
		$type_error = 'Upload png image only.';
	}
	$error = '';
	$error_flag = 0;
	if ($files["$file_name"]['name'] != '') {
		if ($files["$file_name"]['name'] != '') {
			if (!in_array($files["$file_name"]['type'], $file_type_array)) {
				$error = $type_error;
			}
			else if( $files["$file_name"]['size'] > 1048576) {
				$error = 'Image photo size should not be greater than 1 MB';
			}
			else if (!is_writable($abs_path)) {
				$error = 'The image folder is write protected. Try again';
			}
			else if($type == 4) {
				list($width, $height) = getimagesize($files[$file_name]['tmp_name']);
				if($width > 725)
					$error = 'Image width should not be greater than 725 pixels';
			}
		}
	}
	else
		$error = $type_error;
	return $error;
}
function detectMobileOs(){
	require_once('Mobile_Detect.php');
    $detect = new Mobile_Detect();
	if($detect->istablet())
		$os = "tablet";
	if($detect->isiOS()){
		 $os = "iOS";
	}
	if($detect->isAndroidOS()){
		 $os = "Android";
	}
	return $os;
}
function detectDesktopOs() {
	$userAgent = $_SERVER['HTTP_USER_AGENT'];
	$oses = array (
		'iPhone' => '(iPhone)',
		'Windows 3.11' => 'Win16',
		'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)', // Use regular expressions as value to identify operating system
		'Windows 98' => '(Windows 98)|(Win98)',
		'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
		'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
		'Windows 2003' => '(Windows NT 5.2)',
		'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
		'Windows 7' => '(Windows NT 6.1)|(Windows 7)',
		'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
		'Windows ME' => 'Windows ME',
		'Open BSD'=>'OpenBSD',
		'Sun OS'=>'SunOS',
		'Linux'=>'(Linux)|(X11)',
		'Safari' => '(Safari)',
		'Macintosh'=>'(Mac_PowerPC)|(Macintosh)',
		'QNX'=>'QNX',
		'BeOS'=>'BeOS',
		'OS/2'=>'OS/2',
		'Search Bot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
	);

	foreach($oses as $os=>$pattern){ // Loop through $oses array
    // Use regular expressions to check operating system type
		//if(eregi($pattern, $userAgent)) { // Check if a value in $oses array matches current user agent.
		if(preg_match('/'.$pattern.'/i', $userAgent)) {
			return $os; // Operating system was matched so return $oses key
		}
	}
	return 'Unknown'; // Cannot find operating system so return Unknown
}
function detectOs()
{
	require_once('Mobile_Detect.php');
	$detectObj = new Mobile_Detect();
	if($detectObj->isTablet())
		$layout = 'tablet';
	else if($detectObj->isMobile())
		$layout = 'mobile';
	else
		$layout = 'desktop';
	 if($layout =='tablet' || $layout =='mobile')
	 {
	 	$os = detectMobileOs();
	 }
	 else
	 {
	 	$os = detectDesktopOs();
		if(substr($os,0,3)=="Win")
			$os = "Windows";
	 }
	 return $os;
}
function thumbnail($image_path,$original_path, $size ) {
	require_once('image_resizing.php');
  list($width, $height) = getimagesize($image_path);
  $image_aspect = $width / $height;
  
  list($thumb_width, $thumb_height) = explode('x', $size);
  $thumb_aspect = $thumb_width / $thumb_height;
 
  if ($image_aspect > $thumb_aspect) {
    $crop_height = $height;
    $crop_width = round($crop_height * $thumb_aspect);
  } else {
    $crop_width = $width;
    $crop_height = round($crop_width / $thumb_aspect);
  }
 
  $crop_x_offset = round(($width - $crop_width) / 2);
  $crop_y_offset = round(($height - $crop_height) / 2);
 
  // crop parameter
  $crop_size = $crop_width.'x'.$crop_height.'+'.$crop_x_offset.'+'.$crop_y_offset;
  $thumb_image = dirname($original_path).'/'.basename($image_path);
  exec('convert '. escapeshellarg($image_path).' -crop ' . $crop_size .' -thumbnail '.$size.' '. escapeshellarg($thumb_image));
 
  return $thumb_image;
}
function iframe()
{ ?>
	<iframe src="uploadAction" id="imguploadprint" height="0" width="0"  name="imguploadprint" frameborder="0" ></iframe>
<?php
}
/*********************************************************
  * Function Name: getFileExtension
  * Purpose: Get the file extension
  * Paramters :
  *			$filename  - File name
  * Output : Returns file extension.
  *******************************************************/
function getFileExtension($filename)
{
		$fileformat 	= 	explode(".",$filename);
		if(end($fileformat)!= '')
			 $fileformat = end($fileformat);
		return strtolower($fileformat);
}

function getWidthandHeight($image) {
	$size = getimagesize($image);
	$sizearr['width'] = $size[0];
	$sizearr['height'] = $size[1];
	return $sizearr;
}

function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	$this_type=0;
	switch($imageType) {
		case "image/gif":
			$this_type=1;
			$source=imagecreatefromgif($image); 
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image); 
			break;
	    case "image/png":
		case "image/x-png":
			$this_type=1;
			$source=imagecreatefrompng($image); 
			break;
  	}
	/**/
	if($this_type){
			imagealphablending($newImage, false);
		  imagesavealpha($newImage,true);
		  $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
		  imagefilledrectangle($newImage, 0, 0, $newImageWidth, $newImageHeight, $transparent);
	}
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	switch($imageType) {
		case "image/gif":
	  		imagegif($newImage,$thumb_image_name); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage,$thumb_image_name,90); 
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$thumb_image_name);  
			break;
    }
	//chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}
//You do not need to alter these functions
function getHeight($image) {
	$size = getimagesize($image);
	$height = $size[1];
	return $height;
}
//You do not need to alter these functions
function getWidth($image) {
	$size = getimagesize($image);
	$width = $size[0];
	return $width;
}
 

function blurResize($thumb_image_name, $image, $newwidth, $newheight){
	$uploadedfile 	= $image;
	$filename 		= $thumb_image_name;
	list($width,$height,$imageType)=getimagesize($uploadedfile);
	$imageType = image_type_to_mime_type($imageType);
	$this_type = 0;
	switch($imageType) {
		case "image/gif":
			$this_type = 1;
			$src = imagecreatefromgif($uploadedfile);
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$src = imagecreatefromjpeg($uploadedfile);
			break;
	    case "image/png":
		case "image/x-png":
			$this_type = 1;
			$src = imagecreatefrompng($uploadedfile);
			break;
	}
	
	$tmp=imagecreatetruecolor($newwidth,$newheight);
	
	
	if($this_type){
		imagealphablending($tmp, false);
		imagesavealpha($tmp,true);
		$transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
		imagefilledrectangle($tmp, 0, 0, $newwidth, $newheight, $transparent);
 	}
	imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
	switch($imageType) {
		case "image/gif":
			imagegif($tmp,$filename);
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			imagejpeg($tmp,$filename,100);
			break;
	    case "image/png":
		case "image/x-png":
			imagepng($tmp,$filename);
			break;
	}
	imagedestroy($src);
	imagedestroy($tmp);
 }
function cropForm(){
		$form 	= '<form id="cropform" name="cropform" action="" method="post"><input type="hidden" value="" id="hidden_image_name" name="hidden_image_name" />';
		$form .= '<input type="hidden" value="" id="top" name="top" /><input type="hidden" id="left" value="" name="left" /><br>';
		$form .= '<input type="hidden" id="cointainer_height" name="cointainer_height" value="350" /><input type="hidden" id="cointainer_width" name="cointainer_width" value="350" /><br>';
		$form .= '<input type="hidden" id="crop_width" value="300"  name="crop_width" /><input type="hidden" id="crop_height" value="300" name="crop_height" /><br>';
		$form .= '<input type="hidden" id="original_height" value="300"  name="original_height" /><input type="hidden" id="original_width" value="300" name="original_width" /><br>';
		$form .= '<input type="hidden" id="resize_height" value="300"  name="resize_height" /><input type="hidden" id="resize_width" value="300" name="resize_width" /><br>';
		$form .= '<input type="hidden" value="" id="blur_image" name="blur_image" /><input type="hidden" value="" id="hidden_post_form_name" name="hidden_post_form_name" /></form>';
		return $form;
}

/*	ShortURL*/

function get_rand_alphanumeric($length)
	{
		$random = '13579acegikmoqsuwyEVENTURERSbdfhjlnprtvxz24680';	// 
		$maxlength = strlen($random);
		if ($length>0) {
	        $rand_id="";
	        for ($i=1; $i<=$length; $i++) {
	            mt_srand((double)microtime() * 1000000);
				$rand_id .= substr($random, mt_rand(1, $maxlength-1), 1);
	        }
	    }
	    return $rand_id;
}
/*-------------------------------------------------------------------------------------	V2	------------------------------------------------------------------------------*/
function saveImage($org_img_name,$card_id,$ext,$img_type)
{
	if($img_type == 1)
		$folder_path = ABS_IMAGE_PATH_LOGO;
	else if($img_type == 2)
		$folder_path = ABS_IMAGE_PATH_PROFILE;
	else if($img_type == 3)
		$folder_path = ABS_IMAGE_PATH_BANNER;
	else if($img_type == 4)
		$folder_path = ABS_IMAGE_PATH_PROMOTION;
	else if($img_type == 5)
		$folder_path = ABS_IMAGE_PATH_SHAREFILE;
	
	if($img_type == 1 || $img_type == 2)
	{
		$img_name			=	$org_img_name;//$card_id.'.'.$ext;
		$temp_path	 		=	ABS_PATH.'WebResources/Images/crop/'.$org_img_name;
		$thumb_temp_path	=	ABS_PATH.'WebResources/Images/crop/thumb/'.$org_img_name;
		$img_Abspath	 	= 	$folder_path.$img_name;
		if(file_exists($temp_path))
			copy($temp_path,$img_Abspath);
		$thumbPath		 	=	$folder_path.'thumb/'.$img_name;
		blurResize($thumbPath, $img_Abspath,THUMB_WIDTH,THUMB_HEIGHT);
		if(file_exists($temp_path))
			unlink($temp_path);
		if(file_exists($thumb_temp_path))
			unlink($thumb_temp_path);
	}
	else
	{
		$img_name			= 	$card_id.'.'.$ext;
		$temp_path	 		=	ABS_PATH.'WebResources/Images/temp/'.$org_img_name;
		$img_Abspath	 	= 	$folder_path.$img_name;
		if(file_exists($temp_path))
			copy($temp_path,$img_Abspath);
		if(file_exists($temp_path))
			unlink($temp_path);
	}
}
function getImageName($img_array)
{
	$img_name		=	'';
	$img_name_array	=	explode("_",$img_array);
	$array_count 	=	count($img_name_array);
	if($array_count > 1)
	{
		foreach($img_name_array as $key => $value)
		{
			if($key == 2)
				$img_name	.=	$value;
			if($key > 2)
				$img_name	.=	'_'.$value;
		}
	}
	else
		$img_name	=	$img_array;
	return $img_name;
}
function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://".$url;
    }
    return $url;
}
function timeFormat($time)
{
	$time = $time * 1;
	if($time <= 9)
		$time = '0'.$time.':00';
	else
		$time = $time.':00';
	return $time;
}
function dashboardDateFormat($date)
{
	$date = date("h:i d M", strtotime($date));
	return $date;
}
function addwww($url) {
	if (!preg_match('/www/', $url)) {	// && $_SERVER['HTTP_HOST'] != '172.21.4.100'
        $url = "www.".$url;
    }
    return $url;
}

/* Returns client IP */
function getClientIP()
{
	if ( isset($_SERVER["HTTP_CLIENT_IP"]) ) { 
		$ip = $_SERVER["HTTP_CLIENT_IP"]; 
	} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ) { 
		$ips = explode(',', $_SERVER["HTTP_X_FORWARDED_FOR"]);
		$ip = $ips[0]; 
	} else if ( isset($_SERVER["REMOTE_ADDR"]) ) { 
		$ip = $_SERVER["REMOTE_ADDR"]; 
	}  else {
		$ip = "Unknown";
	}  
	
	return $ip;
}
function detectLayout()
{
	require_once('Mobile_Detect.php');
	$detectObj = new Mobile_Detect();
	if($detectObj->isTablet())
		$layout = 'tablet';
	else if($detectObj->isMobile())
		$layout = 'mobile';
	else
		$layout = 'desktop';
	 return $layout;
}

/********************************************************
 * Function Name: checkTestLoginScreenUser
 * Purpose: Additional login screen for test environment (hardcoded)
 *******************************************************/

function checkTestLoginScreenUser()
{
	if($_SERVER['HTTP_HOST'] != $_SERVER['TFY_TEST_IP_ADDR']
		&& $_SERVER['TFY_TEST_ENV'] == 1){
		
		if(isset($_POST['test_submit']))
		{
			$test_user_name = trim($_POST['test_user_name']);
			$test_password = trim($_POST['test_password']);
			if($test_user_name == 'tactify' && $test_password == 'betauser')
			{
				$_SESSION['ses_test_user_name'] = 'tactify';
				$_SESSION['ses_test_password'] = 'betauser';
				header('Location:home');
			}
		}
		if(!isset($_SESSION['ses_test_user_name']) || !isset($_SESSION['ses_test_user_name']))
		{
			include('Views/login_screen.php');
			die();
		}
	}
}
?>
