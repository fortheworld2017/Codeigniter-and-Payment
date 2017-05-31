<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Creategroup extends CI_Controller {
	  
	public function index()
		{
			$this->load->model('model_auth');
			$this->load->library('header');
			$this->header->index();
			if(!$this->header->logged())
				{
					redirect(site_url('log_in'), 'refresh');
				}
			
			$data['user_templates'] = $this->model_auth->list_templates($this->session->userdata['logged_data']['member_id']);
			$data['cards'] = $this->model_auth->list_cards($this->session->userdata['logged_data']['member_id']);
			

			$data['username'] = "Welcome ".ucfirst(html_escape($this->session->userdata['logged_data']['username']));
			$data['log_out_button'] = LOG_OUT;
			$data['bread_crumb_title']="Create Group";

			$data['error'] = "";
			if($_POST)
				{
					$this->load->library('form_validation');
					$this->form_validation->set_rules('group_name', 'Group Name', 'required');
					if ($this->form_validation->run() == FALSE)
						{
							$data['error'] = "";//$this->load->view('myform');
						}
					else
						{
							$data_insert = array('name' => $this->input->post('group_name'),'fkUserId' => $this->session->userdata['logged_data']['member_id']);
							$this->db->insert('TACTIFY_groups', $data_insert); 
							$data['error'] = "Group added successfully";
						}
					//TACTIFY_groups
				}
			$this->load->view('header_view', $data);
			$this->load->view('left_menu_view');
			$this->load->view('sub_menu_two_view');
			$this->load->view('create_group_view');
			$this->load->view('footer_view');
		}
}
