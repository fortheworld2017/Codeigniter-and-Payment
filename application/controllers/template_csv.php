<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template_csv extends CI_Controller {
	  
	public function download($id)
		{
			$this->load->library('header');
			$this->header->index();
			if(!$this->header->logged())
				{
					redirect(site_url('log_in'), 'refresh');
				}
			$this->load->model('model_auth');
			$data['template_details'] = $this->model_auth->template_details($id, $this->session->userdata['logged_data']['member_id']);
			$template_fields = array('First Name', 'Last Name', 'Email');
			foreach($data['template_details'] as $val=>$row)
				{
					if($row->phoneNumberSelected==1)
						{
							$template_fields[] = 'Phone';
						}
					if($row->websiteSelected==1)
						{
							$template_fields[] = 'Website';
						}
					if($row->smsSelected==1)
						{
							$template_fields[] = 'Sms';
						}
					if($row->skypeSelected==1)
						{
							$template_fields[] = 'Skype';
						}
					if($row->addContactSelected==1)
						{
							$template_fields[] = 'Add Contact';
						}
					if($row->addWeblinkSelected==1)
						{
							$template_fields[] = 'Web Web Link';
						}
					if($row->addressSelected==1)
						{
							$template_fields[] = 'Address';
						}
					if($row->twitterSelected==1)
						{
							$template_fields[] = 'Twitter';
						}
					if($row->linkedinSelected==1)
						{
							$template_fields[] = 'LinkedIn';
						}
					if($row->blogSelected==1)
						{
							$template_fields[] = 'Blog';
						}
					if($row->tumblrSelected==1)
						{
							$template_fields[] = 'Tumblr';
						}
					if($row->soundCloudSelected==1)
						{
							$template_fields[] = 'Sound Cloud';
						}
					if($row->youTubeSelected==1)
						{
							$template_fields[] = 'Youtube';
						}
					if($row->requestMeetingSelected==1)
						{
							$template_fields[] = 'Request Meeting';
						}
					if($row->appStoreSelected==1)
						{
							$template_fields[] = 'App Store';
						}
					if($row->customerServiceSelected==1)
						{
							$template_fields[] = 'Customer Service';
						}
					if($row->shareFilesSelected==1)
						{
							$template_fields[] = 'Share File';
						}
					if($row->calenderSelected==1)
						{
							$template_fields[] = 'Calendar';
						}
					if($row->googlePlusSelected==1)
						{
							$template_fields[] = 'Google Plus';
						}
					if($row->promotionSelected==1)
						{
							$template_fields[] = 'Promotion';
						}
					if($row->spotifySelected==1)
						{
							$template_fields[] = 'Spotify';
						}
					if($row->playStoreSelected==1)
						{
							$template_fields[] = 'Play Store';
						}
					if($row->ticketsSelected==1)
						{
							$template_fields[] = 'Ticket';
						}																							
				}

			
			
			$fp = fopen('file.csv', 'w');
            fputcsv($fp, $template_fields);  
			fclose($fp);
			$this->load->helper('download');
			$name = "template_".$id.".csv";
			$this->load->helper('file');
			$csv_content = read_file('file.csv');
			force_download($name, $csv_content );
			redirect(site_url('edit'), 'refresh'); 
			
			
			
		}
	
}
