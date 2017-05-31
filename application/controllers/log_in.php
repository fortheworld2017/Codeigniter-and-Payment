<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_in extends CI_Controller {
	
	public $log_out_button = '';
	public function index()
		{
			$this->load->library('header');
			$this->header->index();
			$data['username'] = $this->header->welcome_username('log_in');
			$data['log_out_button'] = ""; //$this->log_out_button;
			$data['bread_crumb_title']="Log in";
			$this->load->view('header_view', $data);
			$this->load->view('login_view');

		}
	
	public function crypt_password($posted_password, $hash)
		{
			//if(password_verify($posted_password,$hash))
				{	
					return TRUE;
				}
			//else
			//	{
			//		return FALSE;
			//	}	
		}	
	public function check()
		{
			$this->load->library('header');
			$this->header->index();
			

			$data['username'] = $this->header->welcome_username('log_in');
			$data['log_out_button'] = ""; //$this->log_out_button;
			$data['bread_crumb_title']="Log in";


			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
			$this->form_validation->set_rules('username', 'Username', 'required|callback_username_check');
			$this->form_validation->set_rules('password', 'Password', 'required');
			if ($this->form_validation->run() == FALSE)
				{
					$this->load->library('header');
					$this->header->index();
					$this->load->view('header_view', $data);
					$this->load->view('login_view');
				}
			else
				{
					
				}
			
					
		}

		public function username_check($str)
		{
			$this->load->model('model_auth');
			if($this->model_auth->check_credentials($this->input->post('username')))
			{
				$data['member_details'] = $this->model_auth->check_credentials($this->input->post('username'));
				if(count($data['member_details'])>0)
					{
						if($this->crypt_password($this->input->post('password'),$data['member_details'][0]->password))
						{
							$newdata = array('username'  => $data['member_details'][0]->username,'email'  => $data['member_details'][0]->email, 'member_id'  => $data['member_details'][0]->id, 'logged_in' => TRUE);
							$this->session->set_userdata('logged_data', $newdata);
							redirect(site_url('welcome'), 'location', 301);
						}
						else
						{
							$this->form_validation->set_message('username_check', 'Invalid login details');
							return FALSE;
						}
					}
				else
					{
						return FALSE;
					}		
			}
			else
			{
				$this->form_validation->set_message('username_check', 'Invalid login details');
				return FALSE;
			}
		}	
}
