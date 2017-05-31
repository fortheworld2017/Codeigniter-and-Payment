<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rand_url extends CI_Controller {
	  
	public function index()
		{
			//echo $size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
    		//exit();
    		//echo $random_string = mcrypt_create_iv(16, MCRYPT_RAND);
			//echo $iv;
			echo $random_string = mcrypt_create_iv(4, MCRYPT_RAND);
			echo "<hr />";
			echo $random_string_base64ed = base64_encode(mcrypt_create_iv(4, MCRYPT_RAND));
			echo "<hr />";
			$replace_equal = rand(1,9);
			$random_string_base64ed = str_replace("=", $replace_equal, $random_string_base64ed);
			echo $random_string_base64ed;
		}	
	}	
