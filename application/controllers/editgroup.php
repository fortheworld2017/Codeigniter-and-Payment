<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editgroup extends CI_Controller {
	  
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


			$array_files = array('googlePlus', 'appStore', 'skype', 'shareFile', 'sms', 'twitter', 'facebook', 'requestMeeting','linkedin', 'website', 'promotion', 'spotify', 'addWeblink', 'email', 'blog', 'youTube', 'addContact', 'soundCloud', 'address', 'phoneNumber', 'customerService', 'calendar','playStore', 'tumblr');
			foreach($array_files as $row)
				{
					$data[$row."_hidden"] = "hide-me";
				}
			

			$data['username'] = "Welcome ".ucfirst(html_escape($this->session->userdata['logged_data']['username']));
			$data['log_out_button'] = LOG_OUT;
			$data['bread_crumb_title']="WeEdit Group";
			
			$data['id'] = $id;
			$data['user_domains'] = $this->model_auth->user_domains($this->session->userdata['logged_data']['member_id']);
			$data['photo_error']['error'] = '';
			$data['skypeChecked']="";
			$data['promoChecked']="";
			$data['calendarChecked']="";
			$data['requestMeetingChecked'] = "";
			$data['shareFilesChecked'] = "";
			$data['playStoreChecked'] = "";
			$data['websiteChecked'] = "";
			$data['phoneNumberChecked'] = "";
			$data['customerServiceChecked'] = "";
			$data['appStoreChecked'] = "";
			$data['spotifyChecked'] = "";
			$data['calendarChecked'] = "";
			$data['googlePlusChecked'] = "";
			$data['tumblrChecked'] = "";
			$data['soundCloudChecked'] = "";
			$data['blogChecked'] = "";
			$data['linkedinChecked'] = "";
			$data['twitterChecked'] = "";
			$data['templateChecked'] = "";
			$data['facebookChecked'] = "";
			$data['addressChecked'] = "";
			$data['addWeblinkChecked'] = "";
			$data['skypeChecked'] = "";
			$data['contactChecked'] = "";
			$data['smsChecked'] = "";
			$data['emailChecked'] = "";
			$data['youTubeChecked'] = "";
			$data['load_from_template'] = 0;
			$data['template_id'] = 0;
			if($this->input->post('template_used')=='tmeplate_used')	
				{
					$data['load_from_template'] = 1;
					$data['template_id'] = $this->input->post('template_id');
					
					$data['template_details'] = $this->model_auth->template_details($this->input->post('template_id'),$this->session->userdata['logged_data']['member_id']);
					
					if($data['template_details'][0]->shareFilesSelected==1)
						{
							$data["shareFile_hidden"] = " ";
							$data['shareFilesChecked'] = " checked = 'checked'";
						}
					if($data['template_details'][0]->youTubeSelected==1)
						{
							$data["youTube_hidden"] = " ";
							$data['youTubeChecked'] = " checked = 'checked'";
						}
					if($data['template_details'][0]->addWeblinkSelected==1)
						{
							$data["addWeblink_hidden"] = " ";
							$data['addWeblinkChecked'] = " checked = 'checked'";
						}	
						
					if($data['template_details'][0]->addressSelected==1)
						{
							$data["address_hidden"] = " ";
							$data['addressChecked'] = " checked = 'checked'";
						}	
					if($data['template_details'][0]->facebookSelected==1)
						{
							$data["facebook_hidden"] = " ";
							$data['facebookChecked'] = " checked = 'checked'";
						}		
					if($data['template_details'][0]->playStoreSelected==1)
						{
							$data["playStore_hidden"] = " ";
							$data['playStoreChecked'] = " checked = 'checked'";
						}	
						
					if($data['template_details'][0]->ticketsSelected==1)
						{
							$data["tickets_hidden"] = " ";
							$data['ticketChecked'] = " checked = 'checked'";
						}	
						
					if($data['template_details'][0]->requestMeetingSelected	==1)
						{
							$data["requestMeeting_hidden"] = " ";
							$data['requestMeetingChecked'] = " checked = 'checked'";
						}	
					
					if($data['template_details'][0]->customerServiceSelected==1)
						{
							$data["customerService_hidden"] = " ";
							$data['customerServiceChecked'] = " checked = 'checked'";
						}
					if($data['template_details'][0]->appStoreSelected==1)
						{
							$data["appStore_hidden"] = " ";
							$data['appStoreChecked'] = " checked = 'checked'";
						}
					if($data['template_details'][0]->spotifySelected==1)
						{
							$data["spotify_hidden"] = " ";
							$data['spotifyChecked'] = " checked = 'checked'";
						}
					if($data['template_details'][0]->calenderSelected==1)
						{
							$data["calendar_hidden"] = " ";
							$data['calendarChecked'] = "checked = 'checked' ";
						}
					if($data['template_details'][0]->promotionSelected==1)
						{
							$data["promotion_hidden"] = " ";
							$data['promoChecked'] = "checked = 'checked' ";
						}			
					if($data['template_details'][0]->googlePlusSelected==1)
						{
							$data["googlePlus_hidden"] = " ";
							$data['googlePlusChecked'] = " checked = 'checked'";
						}
					if($data['template_details'][0]->tumblrSelected==1)
						{
							$data["tumblr_hidden"] = " ";
							$data['tumblrChecked'] = " checked = 'checked'";
						}
					if($data['template_details'][0]->soundCloudSelected==1)
						{
							$data["soundCloud_hidden"] = " ";
							$data['soundCloudChecked'] = " checked = 'checked'";
						}	
					if($data['template_details'][0]->blogSelected==1)
						{
							$data["blog_hidden"] = " ";
							$data['blogChecked'] = " checked = 'checked'";
						}
					if($data['template_details'][0]->linkedinSelected==1)
						{
							$data["linkedin_hidden"] = " ";
							$data['linkedinChecked'] = " checked = 'checked'";
						}
					if($data['template_details'][0]->twitterSelected==1)
						{
							$data["twitter_hidden"] = " ";
							$data['twitterChecked'] = " checked = 'checked'";
						}	
					if($data['template_details'][0]->twitterSelected==1)
						{
							$data["twitter_hidden"] = " ";
							$data['template_Checked'] = " checked = 'checked'";
						}
					if($data['template_details'][0]->facebookSelected==1)
						{
							$data["facebook_hidden"] = " ";
							$data['facebook_Checked'] = " checked = 'checked'";
						}
					if($data['template_details'][0]->addressSelected==1)
						{
							$data["address_hidden"] = " ";
							$data['address_Checked'] = " checked = 'checked'";
						}
					if($data['template_details'][0]->addWeblinkSelected==1)
						{
							$data["addWeblink_hidden"] = " ";
							$data['addWeblink_Checked'] = " checked = 'checked'";
						}
					
					if($data['template_details'][0]->skypeSelected==1)
						{
							$data["skype_hidden"] = " ";
							$data['skypeChecked'] = "checked = 'checked'";
						}
					if($data['template_details'][0]->addContactSelected==1)
						{
							$data["contact_hidden"] = " ";
							$data['contactChecked'] = "checked = 'checked'";
						}
					if($data['template_details'][0]->smsSelected==1)
						{
							$data["sms_hidden"] = " ";
							$data['smsChecked'] = "checked = 'checked'";
						}
					if($data['template_details'][0]->emailSelected==1)
						{
							$data["email_hidden"] = " ";
							$data['emailChecked'] = "checked = 'checked'";
						}
					if($data['template_details'][0]->phoneNumberSelected==1)
						{
							$data["phoneNumber_hidden"] = " ";
							$data['phoneNumberChecked'] = "checked = 'checked'";
						}
					if($data['template_details'][0]->websiteSelected==1)
						{
							$data["website_hidden"] = " ";
							$data['websiteChecked'] = "checked = 'checked'";
						}		
					
					
				}
			$this->load->view('header_view', $data);
			$data['group_id'] = $id;
			$data['template_id'] = (empty($this->input->post('template_id'))) ? '' : $this->input->post('template_id');
			$this->load->view('left_menu_view');
			$this->load->view('sub_menu_two_view');
			$this->load->view('edit_group_view', $data);
			$this->load->view('footer_view');
		}
	}	
