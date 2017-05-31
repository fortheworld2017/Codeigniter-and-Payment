<?php
/*
//$content .= "CLASS:PUBLIC\r\n";
$content .= "FN:Punithavel \r\n";
$content .= "N:kamalan;Punithavel;;;\r\n";
//$content .= "TITLE:Ev \r\n";
$content .= "ORG:Wegner Design \r\n";
$content .= "ADR;TYPE=work:;;21 W. 20th St.;Broadview ;IL;60559;\r\n";
$content .= "EMAIL;TYPE=internet,pref:punithavelkamalan@punithavelkamalan.com\r\n";
$content .= "TEL;TYPE=work,voice:123456789\r\n";
$content .= "TEL;TYPE=HOME,voice:987654321\r\n";
$content .= "URL:http://www.punithavelkamalan.com\r\n";

file_put_contents('card/test.vcf',$content);*/
class createVCF {
	var $content;
	function createVCF(){
		$this->content = '';
	}
	function writeVCFcard($dir,$cardname){
		$this->createCard();
		$this->write_dir = $dir;
		$this->cardname = $cardname;
		if (isset($this->content) && $this->content != '')
		{
 			if (file_exists($this->write_dir . '/' . $this->cardname))
				unlink($this->write_dir . '/' . $this->cardname);
			$handle = fopen($this->write_dir . '/' . $this->cardname, 'w');
			fputs($handle, $this->content);
			fclose($handle);
		}
    }
	function connvertToBase64Encode(){
		$this->b64vcard			= 	base64_encode($this->file_contents);				# base64 encode it so that it can be used as an attachemnt to the "dummy" calendar appointment
		$this->b64mline			= 	chunk_split($this->b64vcard,74,"\n");				# chunk the single long line of b64 text in accordance with RFC2045 (and the exact line length determined from the original .ics file exported from Apple calendar
		$this->b64final			= 	preg_replace('/(.+)/', ' $1', $this->b64mline);		# need to indent all the lines by 1 space for the iphone (yes really?!!)
		$this->file_contents 	= 	$this->b64final;
	}
	function connvertToIOSContent(){
		$this->connvertToBase64Encode();
		$this->dt			= date("Ymd")."T".date("Hi");
		$this->dtstart		= $this->dt."00";
		$this->dtend		= $this->dt."01";
		$this->ios_content 	=  "BEGIN:VCALENDAR\n";
		$this->ios_content .=  "VERSION:2.0\n";
		$this->ios_content .=  "BEGIN:VEVENT\n";
		$this->ios_content .=  "SUMMARY:Click attached contact below to save to your contacts\n";
		$this->ios_content .=  "DTSTART;TZID=Europe/London:".$this->dtstart."\n";
		$this->ios_content .=  "DTEND;TZID=Europe/London:".$this->dtend."\n";
		$this->ios_content .=  "DTSTAMP:".$this->dtstart."Z\n";
		$this->ios_content .=  "ATTACH;VALUE=BINARY;ENCODING=BASE64;FMTTYPE=text/directory;\n";
		$this->ios_content .=  "X-APPLE-FILENAME=$this->outputname.vcf:\n";
		$this->ios_content .=  	$this->file_contents;									# output the correctly formatted encoded text
		$this->ios_content .=  "END:VEVENT\n";
		$this->ios_content .=  "END:VCALENDAR\n";
		$this->file_contents = $this->ios_content;
	}
	function getVcardContents(){
		$this->file_contents		= file_get_contents($this->read_dir.$this->cardname.$this->read_ext);
	}
	function downloadVCalender() {
		header("Content-type: text/x-vcalendar; charset=utf-8"); 
		header("Content-Disposition: attachment; filename=\"$this->outputname.ics\";");
		$this->getVcardContents();
		$this->connvertToIOSContent();
		$this->download();
	}
	function download() {
		 echo trim($this->file_contents);
	}
	function downloadVCard() {
		header("Content-type: text/x-vcard; charset=utf-8"); 
		header("Content-Disposition: attachment; filename=\"$this->outputname.vcf\";");
		$this->getVcardContents();
		$this->download();
	}
	function downloadAndroidVCard()
	{
		header("Content-type: text/x-vcard; charset=utf-8"); 
		// Alternatively: application/octet-stream
		// Depending on the desired browser behaviour
		// Be sure to test thoroughly cross-browser
		header("Content-Disposition: attachment; filename=\"$this->outputname.vcf\";");
		# Output file contents 
		echo file_get_contents("$this->outputname.vcf");
	}
	function downloadVCF($dir,$cardname,$browser,$outputname=''){
		$this->read_dir 	= $dir;
		$this->cardname 	= $cardname;
		if($outputname != '')
			$this->outputname	= $outputname;
		else
			$this->outputname	= $this->cardname;
		$this->browser		= $browser;
		$this->read_ext 	= '.vcf';
		if (file_exists($this->read_dir.$this->cardname.$this->read_ext))
		{
			if($this->browser == 2) {
				$this->downloadVCalender();
			}
			else {
				$this->downloadVCard();
			}
			/*else if($this->browser == 3) {
				$this->downloadAndroidVCard();
			}*/
		}
    } 
	function createCard() {
		$this->setBeginCard();
		$this->cardData();
		$this->setEndCard();
	}
	function setBeginCard(){
		$this->content = "BEGIN:VCARD \r\n";
		$this->content .= "VERSION:3.0 \r\n";
	
	}
	function setEndCard(){
		$this->content.= "END:VCARD\r\n"; 
	}
	function quotedPrintableEncode($quotprint)
    { 
    /*
    //beim Mac Umlaute nicht kodieren !!!! sonst Fehler beim Import
    if ($progid == 3)
      {
      $quotprintenc = preg_replace("~([\x01-\x1F\x3D\x7F-\xBF])~e", "sprintf('=%02X', ord('\\1'))", $quotprint);  
      return($quotprintenc);
      }
    //bei Windows und Linux alle Sonderzeichen kodieren
    else
      {*/
   	 return (string) preg_replace("~([\x01-\x1F\x3D\x7F-\xFF])~e", "sprintf('=%02X', ord('\\1'))", $quotprint);  
    } 
	function cardData(){
		foreach($this->data as $this->cardkey=>$this->cardvalue){
			$this->content.= $this->cardvalue; 
		}
		
	}
	function constructVCFData($userdata = '',$carddetail= '') {
		$contactvcf_array = array();
		$this->data = array();
		if($userdata != '') {
			$this->data[]	= (string) "N;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($userdata['user_name'] . ";" . $userdata['user_name'] ) . "\r\n";
			$this->data[]	= (string) "FN;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($userdata['user_name'] . " " . $userdata['user_name']) . "\r\n";
		}
		if($carddetail != '') {
			if(isset($carddetail['company']) && $carddetail['company'] != '')
				$this->data[]	= (string) "ORG;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($carddetail['company']) . "\r\n";
			else
				$carddetail['company'] = '';
			/*if(isset($carddetail['title']) && $carddetail['title'] != '')
				$this->data[]	= (string) "TITLE;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($carddetail['title']) . "\r\n";
			if(isset($carddetail['telephone']) && $carddetail['telephone'] != '')
				$this->data[]	= (string) "TEL;WORK;telephone:" . $carddetail['telephone'] . "\r\n";
			if(isset($carddetail['mobile']) && $carddetail['mobile'] != '')
				$this->data[]	= (string) "TEL;WORK;cell:" . $carddetail['mobile'] . "\r\n";
			if(isset($carddetail['email']) && $carddetail['email'] != '')
				$this->data[]	= (string) "EMAIL;PREF;INTERNET:" . $carddetail['email'] . "\r\n";
			if(isset($carddetail['website']) && $carddetail['website'] != '')
				$this->data[]	= (string) "URL;WORK:" . $carddetail['website'] . "\r\n";
			if(isset($carddetail['officeLocation']) && $carddetail['officeLocation'] != '')
				$this->data[]	= (string) "ADR;WORK:;" . $this->company . ";". $this->officeLocation . "\r\n";*/
			if(isset($carddetail['title']) && $carddetail['title'] != '')
				$this->data[]	= (string) "TITLE;ENCODING=QUOTED-PRINTABLE:" . $this->quotedPrintableEncode($carddetail['title']) . "\r\n";
			if(isset($carddetail['phoneNumber']) && $carddetail['phoneNumber'] != '')
				$this->data[]	= (string) "TEL;WORK;telephone:" . $carddetail['phoneNumber'] . "\r\n";
			if(isset($carddetail['website']) && $carddetail['website'] != '')
				$this->data[]	= (string) "URL;WORK:" . $carddetail['website'] . "\r\n";
			if(isset($carddetail['email']) && $carddetail['email'] != '')
				$this->data[]	= (string) "EMAIL;PREF;INTERNET:" . $carddetail['email'] . "\r\n";
		}
	}
}
?>