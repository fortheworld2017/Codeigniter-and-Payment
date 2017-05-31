<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload_csv extends CI_Controller {
	  
	public function check($id)
		{
			$this->load->model('model_auth');
			$this->load->library('header');
			$this->header->index();
			$data['success']=FALSE;
			if(!$this->header->logged())
				{
					redirect(site_url('log_in'), 'refresh');
				}
			
			$data['fkUserId'] = $this->session->userdata['logged_data']['member_id'];
			$data['template_details'] = $this->model_auth->template_details($id,$this->session->userdata['logged_data']['member_id']);
			$domain_id = $data['template_details'][0]->fkCardDomainId;
			

			######
			$data['username'] = "Welcome ".ucfirst(html_escape($this->session->userdata['logged_data']['username']));
			$data['log_out_button'] = LOG_OUT;
			$data['bread_crumb_title']="Upload Csv";
			######

			if(count($data['template_details'])!=1)
				{	
					echo "Invalid Request";exit();
				}
			else
				{
					$data['id'] = $id;
					$data['logo']=$data['template_details'][0]->logo;
					$this->load->view('header_view', $data);
					$this->load->view('left_menu_view');
					$this->load->view('sub_menu_two_view');
					
				}	
			//$template_fields = array('First Name', 'Last Name', 'Email');
			
			$data['error']=array('error'=>'');
			if($_POST)
				{
					$data['error'] = array('error' => '');
					$config['upload_path'] = 'csv_files';
					$config['allowed_types'] = 'csv';
					$config['max_size']	= '100';
					$config['file_name'] = 'card_template_'.$id.'_'.time().'.csv';
					$config['overwrite'] = TRUE;
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('file'))
						{
							$data['error'] = array('error' => $this->upload->display_errors());
						}
					else
						{
							$data['error'] = array('error' => 'Uploaded successfully!');
							
							$data = array('upload_data' => $this->upload->data());
							//CSV INSERT
							$row = 1;
							$this->load->helper('file');

							if (($handle = fopen(base_url("csv_files/".$config['file_name']), "r")) !== FALSE)
								{
							    	$row_counter = 1;
							    	while (($data = fgetcsv($handle, 0, "\r")) !== FALSE)
							    		{
									    	$num = count($data);
									        $row++;
									        for ($c=0; $c < $num; $c++)
									        	{
									        	    if($row_counter==1)
							        					{	
							        						$row_counter++;
							        						$columns = explode(',',$data[$c]);
							        						foreach($columns as $val=>$row)
							        							{
									        						if($row=='First Name')
									        							{
									        								$columns[$val] = 'firstName';
									        							}
									        						if($row=='Last Name')
									        							{
									        								$columns[$val] = 'lastName';
									        							}	
									        						if($row=='Email')
									        							{
									        								$columns[$val] = 'email';
									        							}		
									        						if($row=='Phone')
									        							{
									        								$columns[$val] = 'phoneNumber';
									        							}
									        						if($row=='Request Meeting')
									        							{
									        								$columns[$val] = 'requestMeeting';
									        							}
									        						if($row=='Tumblr')
									        							{
									        								$columns[$val] = 'tumblr';
									        							}
									        						if($row=='Youtube')
									        							{
									        								$columns[$val] = 'youTube';
									        							}
									        						if($row=='Blog')
									        							{
									        								$columns[$val] = 'blog';
									        							}
									        						if($row=='LinkedIn')
									        							{
									        								$columns[$val] = 'linkedin';
									        							}
									        						if($row=='Sound Cloud')
									        							{
									        								$columns[$val] = 'soundCloud';
									        							}
									        						if($row=='Address')
									        							{
									        								$columns[$val] = 'address';
									        							}
									        						if($row=='Calendar')
									        							{
									        								$columns[$val] = 'calender';
									        							}							
									        						if($row=='Twitter')
									        							{
									        								$columns[$val] = 'twitter';
									        							}
									        						if($row=='Web Web Link')
									        							{
									        								$columns[$val] = 'addWeblink';
									        							}
									        						if($row=='Address')
									        							{
									        								$columns[$val] = 'address';
									        							}
									        						if($row=='Add Contact')
									        							{
									        								$columns[$val] = 'addContact';
									        							}
									        						if($row=='Skype')
									        							{
									        								$columns[$val] = 'skype';
									        							}
									        						if($row=='Sms')
									        							{
									        								$columns[$val] = 'sms';
									        							}
									        						if($row=='Website')
									        							{
									        								$columns[$val] = 'website';
									        							}
									        						if($row=='Share File')
									        							{
									        								$columns[$val] = 'shareFile';
									        							}
									        						if($row=='Customer Service')
									        							{
									        								$columns[$val] = 'customerService';
									        							}
									        						if($row=='Play Store')
									        							{
									        								$columns[$val] = 'playStore';
									        							}
									        						if($row=='App Store')
									        							{
									        								$columns[$val] = 'appStore';
									        							}
									        						if($row=='Spotify')
									        							{
									        								$columns[$val] = 'spotify';
									        							}
									        						if($row=='App Store')
									        							{
									        								$columns[$val] = 'appStore';
									        							}
									        						if($row=='Promotion')
									        							{
									        								$columns[$val] = 'promotion';
									        							}
									        						if($row=='Google Plus')
									        							{
									        								$columns[$val] = 'googlePlus';
									        							}	
									        						if($row=='Ticket')
									        							{
									        								$columns[$val] = 'tickets';
									        							}
																}		
							        					}	
									        		else
									        			{
									        				$this_member = explode(',',$data[$c]);
									        				$members[]=$this_member;
														}
												}
									    }
									fclose($handle);
								}
							//END CSV INSERT
							//If no error
							$members_counters = 0;
							$members_list = array();
							foreach($members as $val =>$mrow)
								{
									
									foreach($columns as $value =>$row)
										{
											if(isset($mrow[$value]))
												{
													$members_list[$members_counters][$row] = $mrow[$value];
													$members_list[$members_counters]['fkUserId'] = $this->session->userdata['logged_data']['member_id'];
													$members_list[$members_counters]['fkCardTemplateId'] = $id;
													$members_list[$members_counters]['createdDate'] = date('Y-m-d');
													$members_list[$members_counters]['fkCardDomainId'] = $domain_id;
												}	
										}	
									$members_counters++;	
								}
							$this->db->insert_batch('TACTIFY_cardDetails', $members_list); 
							$data['error']=array('error' => 'Uploaded successfully!');
							$data['success']=TRUE;
						}
						
						
				}		

			$this->load->view('upload_csv_view.php', $data);
			$this->load->view('footer_view.php', $data);	
		}
}
