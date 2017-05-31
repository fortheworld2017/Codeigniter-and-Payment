<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class New_password extends CI_Controller {

	
	public $log_out_button = '';
	public function auth($email, $token)
		{
			$this->load->library('header');
			$this->header->index();
			$data['username'] = "Guest";
			$data['log_out_button'] = $this->log_out_button;



			
			$data['bread_crumb_title']="Thank You";

			$this->load->view('header_view', $data);
			//
			
			
			$this->load->model('model_auth');
			$data['results'] = $this->model_auth->check_password_reset_auth($email, $token);
			if(count($data['results'])>0)
				{
					if($data['results'][0]->temp_pass_key==$token)
						{
							$data['email'] = $email;
							$data['token'] = $token;
							$data['error'] = '';
							
							
							$past = $data['results'][0]->temp_pass_key_expiry;;
							$now = strtotime('now');
							$diff = $now - $past;
							$diff = floor($diff / 3600);
							$expires = 6 - $diff;
							if($expires<0)
								{
									$data['message'] = "This link is expired";
									$this->load->view('error_view', $data);
								}
							else 
								{
									$data['expiry'] = "This link expires in ".$expires." hours";
									$this->load->view('new_password_view', $data);
								}	
						}
				}	
			else
				{
					$data['expiry'] = "";
					$data['message'] = 'Invalid request';
					$this->load->view('error_view', $data);
				}
				
				
		}
	
	
	public function update($email, $token)
		{
			$this->load->library('header');
			$this->header->index();
			$data['username'] = "Guest";
			$data['log_out_button'] = $this->log_out_button;
			$this->load->view('header_view', $data);
			//
			$data['expiry'] = "";
			
			$this->load->model('model_auth');
			$data['results'] = $this->model_auth->check_password_reset_auth($email, $token);
			if(count($data['results'])>0)
				{
					if($data['results'][0]->temp_pass_key==$token)
						{
							$data['email'] = $email;
							$data['token'] = $token;
							$data['error'] = '';
							$past = $data['results'][0]->temp_pass_key_expiry;;
							$now = strtotime('now');
							$diff = $now - $past;
							$diff = floor($diff / 3600);
							$expires = 6 - $diff;
							if($expires<0)
								{
									$data['message'] = "This link is expired";
									
									$this->load->view('error_view', $data);
									exit();
								}
								
							
							//Validation
							$this->load->library('form_validation');
							$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
							$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[15]|matches[password_repeat]|callback_check_for_number');
							$this->form_validation->set_rules('password_repeat', 'Password repeat', 'required|min_length[8]|max_length[15]');
							if ($this->form_validation->run() == FALSE)
								{
									$this->load->view('new_password_view', $data);
								}
							else
								{
									$hash = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
									$data = array(
											'password' => $hash,
											'temp_pass_key' => ''
									);
									
									$this->db->where('sha1(email)', $email);
									$this->db->update('user', $data);
									redirect('new_password/success', 'refresh');
								}
							//
							
						}
				}	
			else
				{
					
					$data['message'] = 'Invalid request';
					$this->load->view('error_view', $data);
				}
		}
		
		public function check_for_number($password)
			{
				if(preg_match('/\\d/', $password) )
				{
					return TRUE;
				}
				else
				{
					$this->form_validation->set_message('check_for_number', 'Please should contain atleast 1 number');
					return false;
				}
			}	
	public function success()	
		{
			$data['log_out_button'] = $this->log_out_button;
			$this->load->library('header');
			$this->header->index();
			$data['expiry'] = "";
			$data['username'] = "Guest";
			$this->load->view('header_view', $data);
			$data['message'] = '<div class = "success">Password has been successfully updated.<br /><br /> <a href = "'.base_url('log_in').'">Click here to log in</a></div>';
			$this->load->view('error_view', $data);
			$this->load->view('footer_view');
		}		
}
