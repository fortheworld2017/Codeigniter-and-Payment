<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_password extends CI_Controller {
	
	public $log_out_button = '';
	public function index()
		{
			$this->load->library('header');
			$this->header->index();
			$data['username'] = "Guest";
			$data['log_out_button'] = $this->log_out_button;
			$this->load->view('header_view', $data);
			$this->load->view('forgot_password_view');

		}

	public function check()
		{
			$this->load->library('header');
			$this->header->index();
			$data['log_out_button'] = $this->log_out_button;
			
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('email', 'Email', 'required|callback_email_check');
			if ($this->form_validation->run() == FALSE)
				{
					$this->load->library('header');
					$this->header->index();
					$data['username'] = "Guest";
					$this->load->view('header_view', $data);
					$this->load->view('forgot_password_view');
				}
			else
				{
					
				}
			
					
		}

		public function email_check($str)
		{
			$this->load->model('model_auth');
			if($this->model_auth->check_email($this->input->post('email')))
				{
					$data['member_details'] = $this->model_auth->check_email($this->input->post('email'));
					
					if($this->input->post('email')==$data['member_details'][0]->email)
						{
							$random_string = sha1(time());
							
							
							$this->model_auth->temp_pass_key($this->input->post('email'), $random_string, strtotime('now'));

							$this->load->library('email');
							$config['mailtype'] = 'html';
							$this->email->initialize($config);
							
							$this->email->from('help@tactify.com', 'Tactify Support');
							$this->email->to('pmdg3@yahoo.com');
							$this->email->subject('Tactify password reset');
							$message = 'Tactify received a request to reset the password for your account. To reset your password, click on the button below with in 6 hours of receiving this email: <br /><br /><a href="'.site_url('new_password/auth/'.sha1($this->input->post('email'))).'/'.$random_string.'">Reset my password.</a>
							<br /><br />
					If you\'re getting a lot of password reset emails you didn\'t request, you can change your account settings to require personal information to start a password reset. Check out our support pages for more information. ';
							$this->email->message($message);
							$this->email->send();
							redirect(site_url('forgot_password/success'), 'refresh');
							
						}
					else
						{
							$this->form_validation->set_message('email_check', 'Invalid entry');
							return FALSE;
						}
				}
			else
				{
					$this->form_validation->set_message('email_check', 'Invalid entry');
					return FALSE;
				}
		}	
	public function success()
		{
			$this->load->library('header');
			$this->header->index();
			$data['log_out_button'] = $this->log_out_button;
			$data['username'] = "Guest";
			$this->load->view('header_view', $data);
			$this->load->view('forgot_password_sent_view');
		}	
}
