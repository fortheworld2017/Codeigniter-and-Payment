<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {
	  
	public function index()
		{
			$this->load->library('header');
			$this->header->index();
			if(!$this->header->logged())
			{
				redirect(site_url('log_in'), 'refresh');
			}
			
			$data['username'] = "Welcome ".ucfirst(html_escape($this->session->userdata['logged_data']['username']));
			$data['log_out_button'] = LOG_OUT;
			$data['bread_crumb_title']="Account";

			$data['fkUserId'] = $this->session->userdata['logged_data']['member_id'];
			
			$this->load->model('model_auth');
			$data['user_details'] = $this->model_auth->member_details($this->session->userdata['logged_data']['member_id']);
			
			$this->load->view('header_view', $data);
			$this->load->view('left_menu_view');
			$this->load->view('sub_menu_two_view');
			$this->load->view('account_view', $data);
			$this->load->view('footer_view');
		}
	
	public function update()
		{
			
		}
}
