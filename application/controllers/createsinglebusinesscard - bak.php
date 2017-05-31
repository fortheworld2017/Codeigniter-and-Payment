<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Createbusinesscard extends CI_Controller {
	  
	public function index()
		{
			$this->load->library('header');
			$this->header->index();
			if(!$this->header->logged())
				{
					redirect(site_url('log_in'), 'refresh');
				}
			
			
			$data['fkUserId'] = $this->session->userdata['logged_data']['member_id'];
			

			$data['username'] = "Welcome ".ucfirst(html_escape($this->session->userdata['logged_data']['username']));
			$data['log_out_button'] = LOG_OUT;
			$data['bread_crumb_title']="Create Business Card";

			$this->load->model('model_auth');
			$data['user_domains'] = $this->model_auth->user_domains($this->session->userdata['logged_data']['member_id']);
			$data['user_templates'] = $this->model_auth->user_templates($this->session->userdata['logged_data']['member_id']);
			$data['photo_error']['error'] = '';
			$data['logo']="";
			$this->load->view('header_view', $data);
			$this->load->view('left_menu_view');
			$this->load->view('sub_menu_two_view');
			$this->load->view('create_businesscard_view', $data);
			$this->load->view('footer_view');
		}
	public function insert()
		{
			$posted_data = array();
			if($this->session->userdata['logged_data']['member_id']!=$this->input->post('fkUserId'))
				{
					echo "Error. Poster id and campaign owner do not match!"; Exit();
				}
			$this->load->library('header');
			$this->header->index();
			if(!$this->header->logged())
				{
					redirect(site_url('log_in'), 'refresh');
				}	
				
			$data['logo']="";
			
			$data['fkUserId'] = $this->session->userdata['logged_data']['member_id'];
			


			$data['username'] = "Welcome ".ucfirst(html_escape($this->session->userdata['logged_data']['username']));
			$data['log_out_button'] = LOG_OUT;
			$data['bread_crumb_title']="Create Business Card";


			$this->load->model('model_auth');
			$data['user_domains'] = $this->model_auth->user_domains($this->session->userdata['logged_data']['member_id']);
			$data['photo_error'] = array();
			
			
				
				
			$output_dir = "uploads/";
			$posted_data['logo'] = $data['logo'] = "";
			$photo_error = "0";
			if($_POST)
				{
					//print_r($_POST);exit();
					if($_FILES["logo"]["size"]>0)
						{
							$photo_error = "1";
							$config['upload_path'] = 'uploads/';
							$config['allowed_types'] = 'gif|png';
							$config['max_width']  = '600';
							$config['max_height']  = '600';
							$config['file_name']  = time().'.png';
							
							$this->load->library('upload', $config);
							//Session for message in account page
							$session_data = $this->session->userdata('logged_data');
							$session_data['photo_error_message'] = "";
							$this->session->set_userdata('logged_data', $session_data);
							if ( ! $this->upload->do_upload('logo'))
								{
									$error = array('error' => $this->upload->display_errors());
									
									$data['photo_error'] = $error['error'];

									//Session for message in account page
									$session_data = $this->session->userdata('logged_data');
									$session_data['photo_error_message'] = $data['photo_error'];
									$this->session->set_userdata('logged_data', $session_data);
								}
							else
								{
									$location = $config['upload_path']."/".$config['file_name'];
									if(!$this->resize($location))
										{
											
										}
									$posted_data['logo'] = $data['logo'] = $config['file_name'];
								}
						}

						
						
							
					
							
					foreach($_POST as $val =>$row)
						{
							if($val=="buttonFormat_DB")
								{
									$val = "buttonFormat";
								}
							if($val=="buttonStyle_DB")
								{
									$val = "buttonStyle";
								}
								
							
									$posted_data[$val] = $row;
								
						}
						
					$this->db->insert('TACTIFY_cardTemplate', $posted_data);
					$last = $this->db->insert_id();
					
					if($photo_error=='1')
						{
							redirect(site_url('editbusinesscard/edit/'.$last.'/'.$photo_error), 'refresh');
						}	

					if($photo_error=='0' && strlen($this->input->post('templateName'))<1)
						{	
							redirect(site_url('template_csv/download/'.$last), 'refresh');
						}
					if(strlen($this->input->post('templateName'))>1)
						{
							redirect(site_url('editbusinesscard/edit/'.$last.'/'.$photo_error), 'refresh');
						}		
				}	
				
				
			$data['username'] = $this->session->userdata['logged_data']['username'];
			$data['log_out_button'] = LOG_OUT;
			$this->load->view('header_view', $data);
			$this->load->view('left_menu_view');
			$this->load->view('sub_menu_two_view');
			$this->load->view('create_businesscard_view', $data);
			$this->load->view('footer_view');
		
	}
	public function resize($photo)
		{
			$this->load->library('image_lib');
			$config['image_library'] = 'gd2';
			$config['source_image'] = $photo;
			$config['new_image'] = $photo;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 300;
			$config['height'] = 300;
			$config['create_thumb'] = TRUE;
			$config['thumb_marker'] = '_thumb';
			$this->image_lib->initialize($config);
			$this->load->library('image_lib', $config);
			
			if (!$this->image_lib->resize())
				{
					echo $data['resize_errors'] = $this->image_lib->display_errors();
				}
			else
				{
					return TRUE;
				}	
		}	
}
