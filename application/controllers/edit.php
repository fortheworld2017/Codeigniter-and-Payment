<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit extends CI_Controller {
	  
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
			$data['user_groups'] = $this->model_auth->list_groups($this->session->userdata['logged_data']['member_id']);
			$data['cards'] = $this->model_auth->list_cards($this->session->userdata['logged_data']['member_id']);
			$data['list_cards_with_no_group'] = $this->model_auth->list_cards_with_no_group($this->session->userdata['logged_data']['member_id']);
			


			$data['username'] = "Welcome ".ucfirst(html_escape($this->session->userdata['logged_data']['username']));
			$data['log_out_button'] = LOG_OUT;
			$data['bread_crumb_title']="Edit";


			$this->load->view('header_view', $data);
			$this->load->view('left_menu_view');
			$this->load->view('sub_menu_two_view');
			$this->load->view('edit_view');
			$this->load->view('footer_view');
		}
	public function update_group()	
		{
			
			$query = $this->db->get_where('TACTIFY_cardDetails', array('fkUserId' => $this->session->userdata['logged_data']['member_id'], 'id' => $this->input->post('id')));
			if($query->num_rows()==1)
				{
					$data_update = array(
		               'fkGroupId' => $this->input->post('groups')
		            );
					$this->db->where('id', $this->input->post('id'));
					$this->db->update('TACTIFY_cardDetails', $data_update);
					redirect(site_url('edit'), 'refresh'); 
				}
			else
				{
					print_r($_POST);
					echo "Invalid request!";exit();
				}		
		}
}
