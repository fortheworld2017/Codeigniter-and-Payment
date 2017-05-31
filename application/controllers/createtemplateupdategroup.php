<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Createtemplateupdategroup extends CI_Controller {
	  
	public function edit($id)
		{
			
			$this->load->model('model_auth');
			$this->load->library('header');
			$this->header->index();
			if(!$this->header->logged())
				{
					redirect(site_url('log_in'), 'refresh');
				}
					$data['scroll'] = "";
			
			
			$data['fkUserId'] = $this->session->userdata['logged_data']['member_id'];
			$data['template_details'] = $this->model_auth->template_details($id,$this->session->userdata['logged_data']['member_id']);
			$data['user_templates'] = $this->model_auth->user_templates($this->session->userdata['logged_data']['member_id']);
			$data['user_groups'] = $this->model_auth->group_details($this->session->userdata['logged_data']['member_id'], $id);
			if(count($data['user_groups'])!=1)
				{
					echo "Invalid request"; exit();					
				}

			
			foreach($this->session->userdata['logged_data']['new_template_fields'] as $val=>$row)
				{
					$template_insert[$val] = $row;
				}




			$data['username'] = "Welcome ".ucfirst(html_escape($this->session->userdata['logged_data']['username']));
			$data['log_out_button'] = LOG_OUT;
			$data['bread_crumb_title']="Create Template";	

			//$insert_data = $this->session->userdata['logged_data']['new_template_fields'];
			$template_insert['fkCardDomainId'] = $this->session->userdata['logged_data']['new_template_fields']['fkCardDomainId'];
			$template_insert['fkUserId'] = $this->session->userdata['logged_data']['member_id'];
			$template_insert['templateName'] = $_POST['templateName'];
			$template_insert['cardType'] = 1;
			
			$this->db->insert('TACTIFY_cardTemplate', $template_insert);
			$last = $this->db->insert_id();
			$template_insert= FALSE;
			
			
			
			$this->db->where('fkGroupId', $id);
			$this->db->update('TACTIFY_cardDetails', $this->session->userdata['logged_data']['update_data']); 
			$this->session->userdata['logged_data']['update_data'] = FALSE;
			
			$data['log_out_button'] = LOG_OUT;
			$this->load->view('header_view', $data);
			$this->load->view('left_menu_view');
			$this->load->view('sub_menu_two_view');
			$this->load->view('thankyou', $data);
			$this->load->view('footer_view');
			
		}
	}	
