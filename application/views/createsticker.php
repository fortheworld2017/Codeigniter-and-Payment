<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Createsticker extends CI_Controller {
	  
	public function index()
		{
			$this->load->library('header');
			$this->header->index();
			if(!$this->header->logged())
				{
					redirect(site_url('log_in'), 'refresh');
				}
			$this->load->view('header_view');
			$this->load->view('left_menu_view');
			$this->load->view('sub_menu_two_view');
			$this->load->view('create_sticker_view');
			$this->load->view('footer_view');
		}
}
