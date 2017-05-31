<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Createsinglebusinesscard extends CI_Controller {
	  
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
			$this->load->view('create_singlebusinesscard_view', $data);
			$this->load->view('footer_view');
		}
        //Loading the template data
        public function loadTemplate()
        {
            
            $this->load->model('model_auth');
            $this->load->library('header');
            $this->header->index();
            if(!$this->header->logged())
            {
                redirect(site_url('log_in'), 'refresh');
            }
            
            $data['fkUserId'] = $this->session->userdata['logged_data']['member_id'];
            $data['template_details'] = $this->model_auth->template_details($this->input->post('template_id'),$this->session->userdata['logged_data']['member_id']);
            if(count($data['template_details'])!=1)
                {
                    echo "Invalid request"; exit();                    
                }

            $data['user_templates'] = $this->model_auth->user_templates($this->session->userdata['logged_data']['member_id']);
            
            $data['username'] = "Welcome ".ucfirst(html_escape($this->session->userdata['logged_data']['username']));
            $data['log_out_button'] = LOG_OUT;
            $data['bread_crumb_title']="Load From Template";
            
            //$data['id'] = $id;
            $data['id'] = $data['fkUserId'];
            
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

            $data['smsSelected    '] = $this->input->post('smsSelected    ') ? $this->input->post('smsSelected    ') :  $data['template_details'][0]->smsSelected    ;

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
            
            //$data['txt_apple_store'] = $this->input->post('appStoreSelected') ? "aaa" :  "bbb";
            
                //
            $output_dir = "uploads/";
            $posted_data['logo'] = $data['logo'] = "";
            $photo_error = "0";
            
            
            $data['logo']=$data['template_details'][0]->logo;
            $this->load->view('header_view', $data);
            
            $this->load->view('left_menu_view');
            $this->load->view('sub_menu_two_view');
            //$this->load->view('create_businesscard_from_template_view', $data);
            $this->load->view('create_singlebusinesscard_from_template_view', $data);
            $this->load->view('footer_view');
            
        }
        public function insertCardDetails()
        {
            $data['fkUserId'] = $this->session->userdata['logged_data']['member_id'];
            //var_dump($data);exit();
            if($_POST)
            {
                $posted_data["fkUserId"]=$data['fkUserId'];
                
                foreach($_POST as $val =>$row)
                {
                    if($val=="buttonFormat_DB") continue;
                    if($val=="buttonStyle_DB") continue;
                    if($val=="cardType") continue;
                    if($val=="headerColour") continue;
                    if($val=="cardColour") continue;
                    if (substr($val,-8)=="Selected") continue;
                    
                    //if(substr($val,-6))
                    $posted_data[$val] = $row;       
                }
            
                $this->db->insert('TACTIFY_cardDetails', $posted_data);
                $last = $this->db->insert_id();
                if ($last>0)
                    echo "Card Details are successfully saved.";
                else
                    echo "Error inserting the card details.";
                
            }    
                
            //$data['username'] = $this->session->userdata['logged_data']['username'];
            //$data['log_out_button'] = LOG_OUT;
            //$this->load->view('header_view', $data);
            //$this->load->view('left_menu_view');
            //$this->load->view('sub_menu_two_view');
            //$this->load->view('create_businesscard_view', $data);
            //$this->load->view('footer_view');
            
        }
	public function insert()
		{
			$posted_data = array();
            //var_dump($_POST);exit();
			//if($this->session->userdata['logged_data']['member_id']!=$this->input->post('fkUserId'))
			//	{
			//		echo "Error. Poster id and campaign owner do not match!"; Exit();
			//	}
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
									//$posted_data['logo'] = $data['logo'] = $config['file_name'];
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
						
					$this->db->insert('TACTIFY_cardDetails', $posted_data);
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
