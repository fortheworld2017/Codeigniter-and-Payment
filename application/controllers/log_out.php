<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_out extends CI_Controller {

	public function index()
		{
			$this->session->set_userdata(array('member_id' => '', 'logged_in' => 'FALSE'));
			$this->session->sess_destroy();
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache");
			redirect(base_url('log_in'), 'refresh');
		}
	}