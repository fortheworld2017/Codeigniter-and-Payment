<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checktemplate extends CI_Controller {
	  
	public function index($id=NULL)
		{
			
			$this->load->model('model_auth');
			$this->load->library('header');
			$this->header->index();
			if(!$this->header->logged())
				{
					redirect(site_url('log_in'), 'refresh');
				}
			
			$data['fkUserId'] = $this->session->userdata['logged_data']['member_id'];
			$data['template_details'] = $this->model_auth->template_details($id,$this->session->userdata['logged_data']['member_id']);
			

			$data['username'] = "Welcome ".ucfirst(html_escape($this->session->userdata['logged_data']['username']));
			$data['log_out_button'] = LOG_OUT;
			$data['bread_crumb_title']="Check Template";

			$posted_buttons = array('phoneNumberSelected','ticketsSelected','playStoreSelected','spotifySelected','promotionSelected','googlePlusSelected','calenderSelected','shareFilesSelected','customerServiceSelected','appStoreSelected','requestMeetingSelected','skypeSelected','addContactSelected','phoneNumberSelected','addWeblinkSelected','smsSelected','addressSelected','linkedinSelected','blogSelected','tumblrSelected','soundCloudSelected','youTubeSelected');

			foreach($posted_buttons as $val)
				{
					if(!empty($this->input->post($val)))
						{
							if($this->input->post($val)!=$data['template_details'][0]->$val)
								{
									echo 11;
									echo $val;
									echo "->";
									echo $this->input->post($val);
									echo "-";
									echo $data['template_details'][0]->$val;
									echo "<hr />";	
									echo "CHANGE!";
									echo "<br />";
								}
						}
				}
			exit();	
			print_r($data['template_details']);
			echo "<hr />";
			print_r($_POST);
			if(count($data['template_details'])!=1)
				{
					echo "Invalid request"; exit();					
				}
			if( 	$data['template_details'][0]->phoneNumberSelected!=$this->input->post('phoneNumberSelected')
				||  $data['template_details'][0]->ticketsSelected!=$this->input->post('ticketsSelected')
				||  $data['template_details'][0]->playStoreSelected!=$this->input->post('playStoreSelected')
				||  $data['template_details'][0]->spotifySelected!=$this->input->post('spotifySelected')
				||  $data['template_details'][0]->promotionSelected!=$this->input->post('promotionSelected')
				||  $data['template_details'][0]->googlePlusSelected!=$this->input->post('googlePlusSelected')
				||  $data['template_details'][0]->calenderSelected!=$this->input->post('calenderSelected')
				||  $data['template_details'][0]->shareFilesSelected!=$this->input->post('shareFilesSelected')
				||  $data['template_details'][0]->customerServiceSelected!=$this->input->post('customerServiceSelected')
				||  $data['template_details'][0]->appStoreSelected!=$this->input->post('appStoreSelected')
				||  $data['template_details'][0]->requestMeetingSelected!=$this->input->post('requestMeetingSelected')
				||  $data['template_details'][0]->skypeSelected!=$this->input->post('skypeSelected')
				||  $data['template_details'][0]->addContactSelected!=$this->input->post('addContactSelected')
				||  $data['template_details'][0]->phoneNumberSelected!=$this->input->post('phoneNumberSelected')
				||  $data['template_details'][0]->addWeblinkSelected!=$this->input->post('addWeblinkSelected')
				||  $data['template_details'][0]->smsSelected!=$this->input->post('smsSelected')
				||  $data['template_details'][0]->addressSelected!=$this->input->post('addressSelected')
				||  $data['template_details'][0]->linkedinSelected!=$this->input->post('linkedinSelected')
				||  $data['template_details'][0]->blogSelected!=$this->input->post('blogSelected')
				||  $data['template_details'][0]->tumblrSelected!=$this->input->post('tumblrSelected')
				||  $data['template_details'][0]->soundCloudSelected!=$this->input->post('soundCloudSelected')
				||  $data['template_details'][0]->youTubeSelected!=$this->input->post('youTubeSelected')  	
			   )
				{
					$change = TRUE;
					echo "<br /><strong style = \"color:red\">There has been some change in the template structure.</strong>";
				}
			
			exit;	


			$data['user_templates'] = $this->model_auth->user_templates($this->session->userdata['logged_data']['member_id']);

			$data['log_out_button'] = LOG_OUT;
			
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
			
			
			$data['logo']=$data['template_details'][0]->logo;
			$this->load->view('header_view', $data);
			
			$this->load->view('left_menu_view');
			$this->load->view('sub_menu_two_view');
			$this->load->view('create_businesscard_from_template_view', $data);
			$this->load->view('footer_view');
			
		}
}
