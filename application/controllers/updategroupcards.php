<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Updategroupcards extends CI_Controller {
	  
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
			
			######
			$data['username'] = "Welcome ".ucfirst(html_escape($this->session->userdata['logged_data']['username']));
			$data['log_out_button'] = LOG_OUT;
			$data['bread_crumb_title']="Welcome";
			######

			
			$data['fkUserId'] = $this->session->userdata['logged_data']['member_id'];
			$data['template_details'] = $this->model_auth->template_details($id,$this->session->userdata['logged_data']['member_id']);
			$data['user_templates'] = $this->model_auth->user_templates($this->session->userdata['logged_data']['member_id']);
			$data['user_groups'] = $this->model_auth->group_details($this->session->userdata['logged_data']['member_id'], $id);
			if(count($data['user_groups'])!=1)
				{
					echo "Invalid request"; exit();					
				}

			
			

			$data['id'] = $id;
			$data['user_domains'] = $this->model_auth->user_domains($this->session->userdata['logged_data']['member_id']);
			$data['photo_error']['error'] = '';
			
			//$data['logo']=$data['template_details'][0]->logo;
			$this->load->view('header_view', $data);
			$data['group_id'] = $id;
			$this->load->view('left_menu_view');
			$this->load->view('sub_menu_two_view');
			$change = FALSE;
			$error = FALSE;
			$update_data = array();
			$this->session->userdata['logged_data']['update_data']=false;
			$data['different_fields'] = array();
			$different_fileds="";

			$array_files = array('googlePlus', 'appStore', 'skype', 'shareFile', 'sms', 'twitter', 'facebook', 'requestMeeting','linkedin', 'website', 'promotion', 'spotify', 'addWeblink', 'email', 'blog', 'youTube', 'addContact', 'soundCloud', 'address', 'phoneNumber', 'customerService', 'calendar');
			
			foreach($array_files as $row)
				{
					if(strlen($this->input->post($row))>1)
						{
							$update_data[$row] = $this->input->post($row);
						}
					//Session for message in account page
					$session_data = $this->session->userdata('logged_data');
					$session_data['update_data'][$row] = $this->input->post($row);
					$this->session->set_userdata('logged_data', $session_data);	
				}

			$data['update_data_session'] = $this->session->userdata['logged_data']['update_data'];

			
			if($this->input->post('load_from_template')==TRUE)
				{
					//Check if template has been changed
$posted_buttons = array('phoneNumberSelected','ticketsSelected','playStoreSelected','spotifySelected','promotionSelected','googlePlusSelected','calenderSelected','shareFilesSelected','customerServiceSelected','appStoreSelected','requestMeetingSelected','skypeSelected','addContactSelected','phoneNumberSelected','addWeblinkSelected','smsSelected','addressSelected','linkedinSelected','blogSelected','tumblrSelected','soundCloudSelected','youTubeSelected', 'emailSelected','facebookSelected','twitterSelected','websiteSelected');

					$data['template_details'] = $this->model_auth->template_details($this->input->post('template_id'),$this->session->userdata['logged_data']['member_id']);

					foreach($posted_buttons as $val)
						{
							if($this->input->post($val)!=$data['template_details'][0]->$val)
								{
									$data['different_fields'][]=$val;
									$change = TRUE;
								}	
							$new_template_fields[$val] = $this->input->post($val);
							$new_template_fields['fkUserId'] = $this->session->userdata['logged_data']['member_id'];
							$new_template_fields['fkCardDomainId'] = $data['template_details'][0]->fkCardDomainId;
							//Session for message in account page
							$session_data = $this->session->userdata('logged_data');
							$session_data['new_template_fields'] = $new_template_fields;
							$this->session->set_userdata('logged_data', $session_data);	
						}
					
					if($change == TRUE)
						{
							
							//print_r($data['update_data_session']);
							$data['error_message'] = "You have made changes to the original template, please save this as a new template";
							foreach($data['different_fields'] as $val => $row)
								{
									$different_fileds .= $row.", ";
								}
							$data['error_message'] .= "<br /><span style = 'color:red'>Changed fields:".$different_fileds."</span>";
							$this->load->view('header_view', $data);
							$data['group_id'] = $id;
							$this->load->view('left_menu_view');
							$this->load->view('sub_menu_two_view');
							$this->load->view('new_template_group_view', $data);
							$this->load->view('footer_view');
							$error = TRUE;	
							//Delete
							//print_r($this->session->userdata['logged_data']['update_data']);
						}
					else
						{
							if(count($update_data)>0)
								{
									$this->db->where('fkGroupId', $id);
									$this->db->update('TACTIFY_cardDetails', $update_data); 
									$this->load->view('thankyou', $data);
									$this->load->view('footer_view');
								}
							else
								{
									redirect(base_url('editgroup/edit/'.$id), 'location', 301);
								}	
						}		
					//End check if template has been changed
					
				}	
			if(count($update_data)>0 && $error==FALSE)
				{
					$this->db->where('fkGroupId', $id);
					$this->db->update('TACTIFY_cardDetails', $update_data); 
					$this->load->view('thankyou', $data);
					$this->load->view('footer_view');
				}
			else
				{
					if($error==FALSE)
						{
							redirect(base_url('editgroup/edit/'.$id), 'location', 301);
						}	
				}	  
		}
	}	
