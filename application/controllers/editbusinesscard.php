<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editbusinesscard extends CI_Controller {
	  
	public function edit($id=NULL,$new=0)
		{
			
			$this->load->model('model_auth');
			$this->load->library('header');
			$this->header->index();
			if(!$this->header->logged())
				{
					redirect(site_url('log_in'), 'refresh');
				}
			if($new==1)
				{
					$data['scroll'] = '<script>
							$(function()
										{
											var offset = $("#logo_place").offset();
											$("html,body").animate({
											    scrollTop: offset.top,
											    scrollLeft: offset.left
											}); 
										});		 
								</script>';
				}
			else	
				{
					$data['scroll'] = "";
				}	
			
			$data['fkUserId'] = $this->session->userdata['logged_data']['member_id'];
			$data['template_details'] = $this->model_auth->template_details($id,$this->session->userdata['logged_data']['member_id']);
			if(count($data['template_details'])!=1)
				{
					echo "Invalid request"; exit();					
				}

			$data['username'] = "Welcome ".ucfirst(html_escape($this->session->userdata['logged_data']['username']));
			$data['log_out_button'] = LOG_OUT;
			$data['bread_crumb_title']="Edit Business Card";
			
			$data['id'] = $id;
			$data['user_domains'] = $this->model_auth->user_domains($this->session->userdata['logged_data']['member_id']);
			$data['photo_error']['error'] = '';
			
			

			//Form Values
			$data['headerColour'] = $this->input->post('headerColour') ? $this->input->post('headerColour') :  $data['template_details'][0]->headerColour;

			$data['requestMeetingSelected'] = $this->input->post('requestMeetingSelected') ? $this->input->post('requestMeetingSelected') :  $data['template_details'][0]->requestMeetingSelected;
			
			
			
			$data['cardColour'] = $this->input->post('cardColour') ? $this->input->post('cardColour') :  $data['template_details'][0]->cardColour;

			$data['buttonStyle'] = $this->input->post('buttonStyle') ? $this->input->post('buttonStyle') :  $data['template_details'][0]->buttonStyle;

			$data['buttonFormat'] = $this->input->post('buttonFormat') ? $this->input->post('buttonFormat') :  $data['template_details'][0]->buttonFormat;
			
			$data['facebookSelected'] = $this->input->post('facebookSelected') ? $this->input->post('facebookSelected') :  $data['template_details'][0]->facebookSelected;

			$data['addressSelected'] = $this->input->post('addressSelected') ? $this->input->post('addressSelected') :  $data['template_details'][0]->addressSelected;


			$data['viberSelected'] = $this->input->post('viberSelected') ? $this->input->post('viberSelected') :  $data['template_details'][0]->viberSelected;

			$data['youTubeSelected'] = $this->input->post('youTubeSelected') ? $this->input->post('youTubeSelected') :  $data['template_details'][0]->youTubeSelected;

			$data['googlePlusSelected'] = $this->input->post('googlePlusSelected') ? $this->input->post('googlePlusSelected') :  $data['template_details'][0]->googlePlusSelected;

			$data['phoneNumberSelected'] = $this->input->post('phoneNumberSelected') ? $this->input->post('phoneNumberSelected') :  $data['template_details'][0]->phoneNumberSelected;

			$data['addWeblinkSelected'] = $this->input->post('addWeblinkSelected') ? $this->input->post('addWeblinkSelected') :  $data['template_details'][0]->addWeblinkSelected;

			$data['twitterSelected'] = $this->input->post('twitterSelected') ? $this->input->post('twitterSelected') :  $data['template_details'][0]->twitterSelected;

			$data['addContactSelected'] = $this->input->post('addContactSelected') ? $this->input->post('addContactSelected') :  $data['template_details'][0]->addContactSelected;

			$data['phoneNumberSelected'] = $this->input->post('phoneNumberSelected') ? $this->input->post('phoneNumberSelected') :  $data['template_details'][0]->phoneNumberSelected;

			$data['linkedinSelected'] = $this->input->post('linkedinSelected') ? $this->input->post('linkedinSelected') :  $data['template_details'][0]->linkedinSelected;

			$data['skypeSelected'] = $this->input->post('skypeSelected') ? $this->input->post('skypeSelected') :  $data['template_details'][0]->skypeSelected;

			$data['blogSelected'] = $this->input->post('blogSelected') ? $this->input->post('blogSelected') :  $data['template_details'][0]->blogSelected;

			$data['smsSelected	'] = $this->input->post('smsSelected	') ? $this->input->post('smsSelected	') :  $data['template_details'][0]->smsSelected	;

			$data['tumblrSelected'] = $this->input->post('tumblrSelected') ? $this->input->post('tumblrSelected') :  $data['template_details'][0]->tumblrSelected;

			$data['emailSelected'] = $this->input->post('emailSelected') ? $this->input->post('emailSelected') :  $data['template_details'][0]->emailSelected;

			$data['soundCloudSelected'] = $this->input->post('soundCloudSelected') ? $this->input->post('soundCloudSelected') :  $data['template_details'][0]->soundCloudSelected;

			$data['playStoreSelected'] = $this->input->post('playStoreSelected') ? $this->input->post('playStoreSelected') :  $data['template_details'][0]->playStoreSelected;

			$data['ticketsSelected'] = $this->input->post('ticketsSelected') ? $this->input->post('ticketsSelected') :  $data['template_details'][0]->ticketsSelected;

			$data['websiteSelected'] = $this->input->post('websiteSelected') ? $this->input->post('websiteSelected') :  $data['template_details'][0]->websiteSelected;

			$data['requestMeetingSelected'] = $this->input->post('requestMeetingSelected') ? $this->input->post('requestMeetingSelected') :  $data['template_details'][0]->requestMeetingSelected;

			$data['shareFilesSelected'] = $this->input->post('shareFilesSelected') ? $this->input->post('shareFilesSelected') :  $data['template_details'][0]->shareFilesSelected;

			$data['appStoreSelected'] = $this->input->post('appStoreSelected') ? $this->input->post('appStoreSelected') :  $data['template_details'][0]->appStoreSelected;

			$data['calenderSelected'] = $this->input->post('calenderSelected') ? $this->input->post('calenderSelected') :  $data['template_details'][0]->calenderSelected;

			$data['websiteSelected'] = $this->input->post('websiteSelected') ? $this->input->post('websiteSelected') :  $data['template_details'][0]->websiteSelected;

			$data['customerServiceSelected'] = $this->input->post('customerServiceSelected') ? $this->input->post('customerServiceSelected') :  $data['template_details'][0]->customerServiceSelected;

			$data['promotionSelected'] = $this->input->post('promotionSelected') ? $this->input->post('promotionSelected') :  $data['template_details'][0]->promotionSelected;

			$data['youTubeSelected'] = $this->input->post('youTubeSelected') ? $this->input->post('youTubeSelected') :  $data['template_details'][0]->youTubeSelected;
			
			$data['spotifySelected'] = $this->input->post('spotifySelected') ? $this->input->post('spotifySelected') :  $data['template_details'][0]->spotifySelected;

			$data['smsSelected'] = $this->input->post('smsSelected') ? $this->input->post('smsSelected') :  $data['template_details'][0]->smsSelected;
				//
			$output_dir = "uploads/";
			$posted_data['logo'] = $data['logo'] = "";
			$photo_error = "0";
			if($_POST)
			{
				
				if($_FILES["logo"]["size"]>0)
				{
					$data['scroll'] = '<script>
							$(function()
										{
											var offset = $("#logo_place").offset();
											$("html,body").animate({
											    scrollTop: offset.top,
											    scrollLeft: offset.left
											}); 
										});		 
								</script>';	
					$photo_error = "0";
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
					if(!$this->upload->do_upload('logo'))
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
			else
				{
					$posted_data['logo'] = $data['template_details'][0]->logo;
				}		
			
			





				//If crop
				if($this->input->post('x1')>0 || $this->input->post('x2')>0 || $this->input->post('w')>0 || 
				   $this->input->post('h')>0 )
					{
							$new_image_name  = time().'.png';
							$img_config = array(
						    'source_image'      => 'uploads/'.$data['template_details'][0]->logo,
						    'new_image'         => 'uploads/'.$new_image_name,
						    'maintain_ratio'    => false,
						    'width'             => $this->input->post('w'),
						    'height'            => $this->input->post('h'),
						    'x_axis'            => $this->input->post('x1'),
						    'y_axis'            => $this->input->post('y1')
						);

						$this->load->library('image_lib', $img_config);
						$this->image_lib->initialize($img_config); 
						if($this->image_lib->crop())
							{
								//Update new cropped image name
								$update_data = array('logo'=>$new_image_name);
								$this->db->where('id', $id);
								$this->db->update('TACTIFY_cardTemplate', $update_data);
								$posted_data['logo'] = $new_image_name;
								//$this->output->enable_profiler(TRUE);

							}
						else
							{
								 echo $this->image_lib->display_errors();
								 //exit();
							}	
					}		
				//End if crop	
			
					
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
				
						if($val!='domain')
						{
							$posted_data[$val] = $row;
						}
					}
				
				//
				unset($posted_data['x1']);
				unset($posted_data['x2']);
				unset($posted_data['y1']);
				unset($posted_data['y2']);
				unset($posted_data['w']);
				unset($posted_data['h']);
				
				$this->db->where('id', $id);
				$this->db->update('TACTIFY_cardTemplate', $posted_data);
				
				if($photo_error==1)
					{
						redirect(site_url('editbusinesscard/edit/'.$id.'/'.$photo_error), 'refresh');
					}
				else
					{
						//echo "redirect to a happy place";
					}		
					
			//Load template details again after update
			$data['template_details'] = $this->model_auth->template_details($id,$this->session->userdata['logged_data']['member_id']);
			}
			//
			
			
		//Checkboxes
			$promotionSelected_checkbox = (isset($_POST['promotionSelected'])) ? 1 : $data['template_details'][0]->promotionSelected;  
			
			$data['logo']=$data['template_details'][0]->logo;
			$this->load->view('header_view', $data);
			
			$this->load->view('left_menu_view');
			$this->load->view('sub_menu_two_view');
			$this->load->view('edit_businesscard_view', $data);
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
