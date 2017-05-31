<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Header 
{
	public $logged = '';
	function index()
		{
			$CI =& get_instance();
		}
	
	public function logged()
		{
			$CI =& get_instance();
			if(isset($CI->session->userdata['logged_data']['logged_in']))
				{
					$this->logged = $CI->session->userdata['logged_data']['logged_in'];
				}
			if($this->logged!=TRUE)
				{
					return FALSE;
				}
			else
				{
					return TRUE;
				}
		}
	public function welcome_username($page)
		{
			if($page=='log_in')
				{
					return "";
				}
			else
				{
					return "Show Some Message";
				}	
		}	
}