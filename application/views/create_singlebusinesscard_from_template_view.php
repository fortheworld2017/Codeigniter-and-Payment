<?php 
if($buttonStyle==1)
  {
    ?>
    <style type = "text/css">
      .text_row_style { color:#333333}
      .text  { color:#333333}
      .rubber  { color:#333333}
      .rubber_format_button { display:none}  
    </style>
<?php
  }
  if($buttonStyle==2)
  {
    ?>
    <style type = "text/css">
      .text_row_style { color:#cccccc}
      .text  { color:#cccccc}
      .rubber  { color:#cccccc}
      .steel_format_button { display:none}  
    </style>
<?php
  }

if($buttonFormat==1)
  {
    $button_class = "button-grid";
  }
else
  {
    $button_class = "button-list";
  }  
?>

<div class="container-c">

	

      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 buffer-bottom-md">
            <div class="row">
              <div class="col-md-12 section-header">
                <h1>CREATE SINGLE BUSINESS CARD</h1>
                <ul class="strip-ul stages">
                  <li class="current"><i class="fa fa-file-text"></i> Content</li>
                  <li><i class="fa fa-edit"></i> Design</li>
                  <li><i class="fa fa-check"></i> Finalise</li>
                </ul>
                <h4>Step 1: Put in all your content</h4>
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h3>Use a Template</h3>
                <p>If you have previously created a template for your digital profile please select it from the list, ortherwise select no template.</p>
                
                <?php
                $attributes = array('name' => 'template_form', 'id' => 'template_form', 'enctype' => 'multipart/form-data');
                //echo form_open('loadfromtemplate', $attributes);
                echo form_open('createsinglebusinesscard/loadtemplate', $attributes);
                
                foreach($user_templates as $val=>$row)
                  {
                      $templates[$row['id']] = $row['templateName'];  
                  }
                $class = 'class = "form-control selectwidthauto " onchange="this.form.submit();"';
                echo form_dropdown('template_id', $templates, $this->input->post('template_id'),$class);
                ?>
                </form>  
                <hr>
              </div>
            </div>
            
                      <?php 
  $attributes = array('name' => 'template_form', 'id' => 'template_form', 'enctype' => 'multipart/form-data');
  //echo form_open(base_url('checktemplate/index/'.$this->input->post('template_id')), $attributes);
  echo form_open('createsinglebusinesscard/insertCardDetails', $attributes);?>
  <input type = "hidden" name = "cardType" value = "1">
            <div class="row">
              <div class="col-md-12">
                <h3>Select a Domain</h3>
                <p>If you have previously created a template for your digital profile please select it from the list, ortherwise select no template.</p>
                	<?php 
                		foreach($user_domains as $val=>$row)
                			{
                				if($template_details[0]->fkCardDomainId==$row->DID)
                          {
                            $checked = "checked";
                          }
                         else
                          {
                            $checked = "";
                          } 
                        echo "<input ".$checked." type = \"radio\" value = \"".$row->DID."\" name = \"fkCardDomainId\" id =\"".$row->DID."\" >
        		&nbsp;<label for = \"".$row->DID."\">".$row->DOMAIN."</label><br />";
                			}
                	?>
                <hr>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-12">
                <h3 id = "logo_place">Logo</h3>
                <p>Upload a logo for the card.</p>
                <!--<button class="btn btn-default buffer-bottom-sm">Upload File</button><br>-->
                <input type="file" size="60" name="logo" id ="logo">
                <small>Recommended 250 px by 250 px transperant PNG</small>
              	<span style = "color:red"><?php echo $this->session->userdata['logged_data']['photo_error_message'];?></span>
				        <img src ="<?php echo base_url('components/img/ajax-loader.gif');?>" alt = "loader 2" style = "width:40px; height:40px; display:none;" id = "ajax_loader">
          		<?php //Unset Photo error
						$session_data = $this->session->userdata('logged_data');
						$session_data['photo_error_message'] = FALSE;
						$this->session->set_userdata('logged_data', $session_data);?>
              
     

  <?php 

  
  if(file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$logo) && (strlen($logo)>2))
  		{
  			?>
  			<script src="<?php echo base_url('components/js/crop.js');?>"></script>
				<script type="text/javascript">
				
				  jQuery(function($){
				
				    var jcrop_api;
				
				    $('#target').Jcrop({
				      onChange:   showCoords,
				      onSelect:   showCoords,
				      onRelease:  clearCoords
				    },function(){
				      jcrop_api = this;
				    });
				
				    $('#template_form').on('change','input',function(e){
				      var x1 = $('#x1').val(),
				          x2 = $('#x2').val(),
				          y1 = $('#y1').val(),
				          y2 = $('#y2').val();
				      jcrop_api.setSelect([x1,y1,x2,y2]);
				    });
				
				  });
				
				  // Simple event handler, called from onChange and onSelect
				  // event handlers, as per the Jcrop invocation above
				  function showCoords(c)
				  {
				    $('#x1').val(c.x);
				    $('#y1').val(c.y);
				    $('#x2').val(c.x2);
				    $('#y2').val(c.y2);
				    $('#w').val(c.w);
				    $('#h').val(c.h);
				  };
				
				  function clearCoords()
				  {
				    $('#coords input').val('');
				  };
				
				
				
				</script>
				 <!-- This is the image we're attaching Jcrop to -->
  			<img src="/uploads/<?php echo $logo;?>" id="target" alt="uploads/<?php echo $logo;?>" />
  			 <!-- This is the form that our event handler fills -->
			  
			
			    <div class="inline-labels">
  			    <input type="hidden" size="4" id="x1" name="x1" />
  			    <input type="hidden" size="4" id="y1" name="y1" />
  			    <input type="hidden" size="4" id="x2" name="x2" />
  			    <input type="hidden" size="4" id="y2" name="y2" />
  			    <input type="hidden" size="4" id="w" name="w" />
  			    <input type="hidden" size="4" id="h" name="h" />
			    
			    </div>
			  
  <?php } 
	  else
	  	{
	  		//echo "NO SUCH FILE";	
	  	}
  ?>			

 
         
           </div>  
             
             
            </div>
            <div class="row">
              <div class="col-md-12">
                <hr>
              </div>
            </div>
            









            <!---->

            <div class="row">
              <div class="col-md-12">
              <h3>Select Card Content</h3>
                <p>Use the checkboxes in the contact, social and utility tabs to define the content you would like to be displayed on your card when tapped or scanned.</p>
                <div class="row">
                  <div class="col-sm-2">
                    <div class="btn-group-vertical" style = "height:200px">
                      <button type="button" class="btn btn-primary" id = "button_card_content_contact">Contact</button>
                      <button type="button" class="btn btn-default" id = "button_card_content_social">Social</button>
                      <button type="button" class="btn btn-default" id = "button_card_content_utilities">Utilities</button>
                    </div>
                  </div>
                  <script>
                   //Contact tab button
                  $("#button_card_content_contact").click(function () {
                    $("#card_content_utilities, #card_content_utilities_part_two, #card_content_utilities_part_three, #card_content_utilities_part_four").hide();       
                    $("#card_content_contact_part_two, #card_content_contact_part_three, #card_content_contact_part_four, #card_content_contact_part_five,#card_content_contact_part_six, #card_content_contact_part_seven").show();
                    $("#card_content_social, #card_content_social_part_two,#card_content_social_part_three,#card_content_social_part_four ").hide();  

                    
                    $("#button_card_content_contact").removeClass('btn-default').addClass('btn-primary');
                    $("#button_card_content_social").removeClass('btn-primary').addClass('btn-default');
                    $("#button_card_content_utilities").removeClass('btn-primary').addClass('btn-default');
                    });

                  //Social tab button   
                  $("#button_card_content_social").click(function () {
                  $("#card_content_utilities, #card_content_utilities_part_two, #card_content_utilities_part_three, #card_content_utilities_part_four").hide();     
                  $("#card_content_contact_part_two, #card_content_contact_part_three, #card_content_contact_part_four, #card_content_contact_part_five,#card_content_contact_part_six, #card_content_contact_part_seven").hide();
                  $("#card_content_social, #card_content_social_part_two,#card_content_social_part_three,#card_content_social_part_four ").show();  

                  $("#button_card_content_social").removeClass('btn-default').addClass('btn-primary');
                  $("#button_card_content_contact").removeClass('btn-primary').addClass('btn-default');
                  $("#button_card_content_utilities").removeClass('btn-primary').addClass('btn-default');
                  });                  


                    //Utilities tab button  
                  $("#button_card_content_utilities").click(function () {
                  $("#card_content_utilities, #card_content_utilities_part_two, #card_content_utilities_part_three, #card_content_utilities_part_four").show();     
                  $("#card_content_contact_part_two, #card_content_contact_part_three, #card_content_contact_part_four, #card_content_contact_part_five,#card_content_contact_part_six, #card_content_contact_part_seven").hide();
                  $("#card_content_social, #card_content_social_part_two,#card_content_social_part_three,#card_content_social_part_four ").hide();  

                  $("#button_card_content_utilities").removeClass('btn-default').addClass('btn-primary');
                  $("#button_card_content_contact").removeClass('btn-primary').addClass('btn-default');
                  $("#button_card_content_social").removeClass('btn-primary').addClass('btn-default');
                  });                  

                  
                
                    
                
                //Show hide icons in preview panel  
                $( document ).ready(function() {
                 

                    //Change button type
                    $('#rubber').click(function() {
                           $( ".rubber_format_button" ).show();
                           $( ".steel_format_button " ).hide();
                    }); 
                    //Change button type


                    //Change button type
                    $('#steel').click(function() {
                           $( ".rubber_format_button" ).hide();
                           $( ".steel_format_button " ).show();
                        
                      });   
                    //Change button type

                    //Rows button:
                    $('#button_format_row').click(function() {
                                
                                 $( "#button_format_div" ).addClass( 'button-list' );
                                 $( "#button_format_div" ).removeClass( 'button-grid' );
                                 $('#buttonFormat_DB').val('2');
                     }); 

                    //Rows button:
                    $('#button_format_steel_rubber').click(function() {
                                
                                 $( "#button_format_div" ).removeClass( 'button-list' );
                                 $( "#button_format_div" ).addClass( 'button-grid' );
                                 $('#buttonFormat_DB').val('1');
                     }); 

                    
                    //Still
                    $('#steel').click(function() {
                        $('#buttonStyle_DB').val('1'); 
                        
                        $('.text_row_style').css('color', '#333333'); 
                    }); 


                    //Rubber
                    $('#rubber').click(function() {
                        $('#buttonStyle_DB').val('2');  
                        $('.text_row_style').css('color', '#cccccc'); 
                    }); 


                   
                    
                   /* $('#customerServiceSelected').click(function () {
                        $("#the_customer_service").toggle(this.checked);
                    });
                    */

                   //
                   $('#appStoreSelected').click(function () {
                        if($(this).is(":checked")) {
                            $('#the_apple_store').removeClass("hide-me");
                            $('#txt_apple_store').removeClass("hide-me");
                        } else {
                            $('#the_apple_store').addClass("hide-me");
                            $('#txt_apple_store').addClass("hide-me");
                        }
                    });
                   // 

                   //
                   $('#customerServiceSelected').click(function () {
                        if($(this).is(":checked")) {
                            $('#the_customer_service').removeClass("hide-me");
                            $('#txt_customer_service').removeClass("hide-me");
                        } else {
                            $('#the_customer_service').addClass("hide-me");
                            $('#txt_customer_service').addClass("hide-me");
                        }
                    });
                   // 

                    
                    $('#playStoreSelected').click(function () {
                         if($(this).is(":checked")) {
                            $('#the_google_play_store').removeClass("hide-me");
                            $('#txt_google_play_store').removeClass("hide-me");
                        } else {
                            $('#the_google_play_store').addClass("hide-me");
                            $('#txt_google_play_store').addClass("hide-me");
                        }
                    });
                    $('#requestMeetingSelected').click(function () {
                       // $("#the_request_meeting").toggle(this.checked);

                        if($(this).is(":checked")) {
                            $('#the_request_meeting').removeClass("hide-me");
                            $('#txt_request_meeting').removeClass("hide-me");
                        } else {
                            $('#the_request_meeting').addClass("hide-me");
                            $('#txt_request_meeting').addClass("hide-me");
                        }
                    });


                    $('#playStoreSelected').click(function () {
                       // $("#the_request_meeting").toggle(this.checked);

                        if($(this).is(":checked")) {
                            $('#the_play_store').removeClass("hide-me");
                            $('#txt_play_store').removeClass("hide-me");
                        } else {
                            $('#the_play_store').addClass("hide-me");
                            $('#txt_play_store').addClass("hide-me");
                        }
                    });


                    
                    $('#phoneNumberSelected').click(function () {
                       // $("#the_phone_number").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_phone_number').removeClass("hide-me");
                            $('#txt_phone_number').removeClass("hide-me");
                        } else {
                            $('#the_phone_number').addClass("hide-me");
                            $('#txt_phone_number').addClass("hide-me");
                        }
                    });
                    $('#emailSelected').click(function () {
                        //$("#the_email").toggle(this.checked);
                         if($(this).is(":checked")) {
                            $('#the_email').removeClass("hide-me");
                            $('#txt_email').removeClass("hide-me");
                        } else {
                            $('#the_email').addClass("hide-me");
                            $('#txt_email').addClass("hide-me");
                        }
                    });
                    $('#skypeSelected').click(function () {
                       // $("#the_skype").toggle(this.checked);
                         if($(this).is(":checked")) {
                            $('#the_skype').removeClass("hide-me");
                            $('#txt_skype').removeClass("hide-me");
                        } else {
                            $('#the_skype').addClass("hide-me");
                            $('#txt_skype').addClass("hide-me");
                        }
                    });
                    $('#phoneNumberSelected').click(function () {
                       // $("#the_phone_number").toggle(this.checked);
                         if($(this).is(":checked")) {
                            $('#the_phone_number').removeClass("hide-me");
                            $('#txt_phone_number').removeClass("hide-me");
                        } else {
                            $('#the_phone_number').addClass("hide-me");
                            $('#txt_phone_number').addClass("hide-me");
                        }
                    });
                    $('#viberSelected').click(function () {
                       // $("#the_viber").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_viber').removeClass("hide-me");
                            //$('#txt_viber').removeClass("hide-me");
                        } else {
                            $('#the_viber').addClass("hide-me");
                            //$('#txt_viber').addClass("hide-me");
                        }
                    });
                    $('#addressSelected').click(function () {
                        //$("#the_address").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_address').removeClass("hide-me");
                            $('#txt_address').removeClass("hide-me");
                        } else {
                            $('#the_address').addClass("hide-me");
                            $('#txt_address').addClass("hide-me");
                        }
                    });
                    /*
                    $('#addWeblinkSelected').click(function () {
                        //$("#the_add_web_link").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_add_web_link').removeClass("hide-me");
                            $('#txt_add_web_link').removeClass("hide-me");
                        } else {
                            $('#the_add_web_link').addClass("hide-me");
                            $('#txt_add_web_link').addClass("hide-me");
                        }
                    });*/
                    $('#websiteSelected').click(function () {
                        if($(this).is(":checked")) {
                            $('#the_website').removeClass("hide-me");
                            $('#txt_website').removeClass("hide-me");
                        } else {
                            $('#the_website').addClass("hide-me");
                            $('#txt_website').addClass("hide-me");
                        }
                    });

                     // 
                    $('#addWeblinkSelected').click(function () {
                       // $("#the_share_files").toggle(this.checked);
                       if($(this).is(":checked")) {
                            $('#the_weblink').removeClass("hide-me");
                            $('#txt_weblink').removeClass("hide-me");
                        } else {
                            $('#the_weblink').addClass("hide-me");
                            $('#txt_weblink').addClass("hide-me");
                        }
                    });
                     // 

                    $('#smsSelected').click(function () {
                        //$("#the_sms").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_sms').removeClass("hide-me");
                            $('#txt_sms').removeClass("hide-me");
                        } else {
                            $('#the_sms').addClass("hide-me");
                            $('#txt_sms').addClass("hide-me");
                        }
                    });
                    $('#addContactSelected').click(function () {
                        //$("#the_add_contact").toggle(this.checked);
                         if($(this).is(":checked")) {
                            $('#the_add_contact').removeClass("hide-me");
                            $('#txt_add_contact').removeClass("hide-me");
                        } else {
                            $('#the_add_contact').addClass("hide-me");
                            $('#txt_add_contact').addClass("hide-me");
                        }
                    });
                    $('#facebookSelected').click(function () {
                        //$("#the_facebook").toggle(this.checked);
                        
                        if($(this).is(":checked")) {
                            $('#the_facebook').removeClass("hide-me");
                            $('#txt_facebook').removeClass("hide-me");
                        } else {
                            $('#the_facebook').addClass("hide-me");
                            $('#txt_facebook').addClass("hide-me");
                        }

                    });
                    $('#youtubeSelected').click(function () {
                       // $("#the_youtube").toggle(this.checked);
                       if($(this).is(":checked")) {
                            $('#the_youtube').removeClass("hide-me");
                            $('#txt_youtube').removeClass("hide-me");
                        } else {
                            $('#the_youtube').addClass("hide-me");
                            $('#txt_youtube').addClass("hide-me");
                        }
                    });
                    $('#googleplusSelected').click(function () {
                        //$("#the_googleplus").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_google_plus').removeClass("hide-me");
                            $('#txt_google_plus').removeClass("hide-me");
                        } else {
                            $('#the_google_plus').addClass("hide-me");
                            $('#txt_google_plus').addClass("hide-me");
                        }
                    });
                    $('#soundcloudSelected').click(function () {
                        //$("#the_soundcloud").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_soundcloud').removeClass("hide-me");
                            $('#txt_soundcloud').removeClass("hide-me");
                        } else {
                            $('#the_soundcloud').addClass("hide-me");
                            $('#txt_soundcloud').addClass("hide-me");
                        }
                    });
                    $('#spotifySelected').click(function () {
                       // $("#the_spotify").toggle(this.checked);
                       if($(this).is(":checked")) {
                            $('#the_spotify').removeClass("hide-me");
                            $('#txt_spotify').removeClass("hide-me");
                        } else {
                            $('#the_spotify').addClass("hide-me");
                            $('#txt_spotify').addClass("hide-me");
                        }
                    });
                    $('#blogSelected').click(function () {
                        //$("#the_blog").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_blog').removeClass("hide-me");
                            $('#txt_blog').removeClass("hide-me");
                        } else {
                            $('#the_blog').addClass("hide-me");
                            $('#txt_blog').addClass("hide-me");
                        }
                    });
                    $('#linkedinSelected').click(function () {
                       // $("#the_linkedin").toggle(this.checked);
                       if($(this).is(":checked")) {
                            $('#the_linkedin').removeClass("hide-me");
                            $('#txt_linkedin').removeClass("hide-me");
                        } else {
                            $('#the_linkedin').addClass("hide-me");
                            $('#txt_linkedin').addClass("hide-me");
                        }
                    });
                    $('#twitterSelected').click(function () {
                       // $("#the_twitter").toggle(this.checked);
                       if($(this).is(":checked")) {
                            $('#the_twitter').removeClass("hide-me");
                            $('#txt_twitter').removeClass("hide-me");
                        } else {
                            $('#the_twitter').addClass("hide-me");
                            $('#txt_twitter').addClass("hide-me");
                        }
                    });
                    $('#tumblrSelected').click(function () {
                        //$("#the_tumblr").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_tumblr').removeClass("hide-me");
                            $('#txt_tumblr').removeClass("hide-me");
                        } else {
                            $('#the_tumblr').addClass("hide-me");
                            $('#txt_tumblr').addClass("hide-me");
                        }
                    });



                      $('#soundcloudSelected').click(function () {
                        //$("#the_tumblr").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_sound_cloud').removeClass("hide-me");
                            $('#txt_sound_cloud').removeClass("hide-me");
                        } else {
                            $('#the_sound_cloud').addClass("hide-me");
                            $('#txt_sound_cloud').addClass("hide-me");
                        }
                    });

                    $('#youtubeSelected').click(function () {
                        //$("#the_tumblr").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_youtube').removeClass("hide-me");
                            $('#txt_youtube').removeClass("hide-me");
                        } else {
                            $('#the_youtube').addClass("hide-me");
                            $('#txt_youtube').addClass("hide-me");
                        }
                    });  

                        
                    $('#calenderSelected').click(function () {
                        //$("#the_calendar").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_calendar').removeClass("hide-me");
                            $('#txt_calendar').removeClass("hide-me");
                        } else {
                            $('#the_calendar').addClass("hide-me");
                            $('#txt_calendar').addClass("hide-me");
                        }
                    });
                    $('#promotionSelected').click(function () {
                        //$("#the_promotion").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_promotion').removeClass("hide-me");
                            $('#txt_promotion').removeClass("hide-me");
                        } else {
                            $('#the_promotion').addClass("hide-me");
                            $('#txt_promotion').addClass("hide-me");
                        }
                    });
                    $('#shareFilesSelected').click(function () {
                       // $("#the_share_files").toggle(this.checked);
                       if($(this).is(":checked")) {
                            $('#the_share_files').removeClass("hide-me");
                            $('#txt_share_files').removeClass("hide-me");
                        } else {
                            $('#the_share_files').addClass("hide-me");
                            $('#txt_share_files').addClass("hide-me");
                        }
                    });
                });

                      
      </script>

      <!-- Utilities -->
                   <div class="col-sm-5" id = "card_content_utilities" style = "display:none">
                     
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" <?php if($promotionSelected==1) { ?>checked="checked"<?php } ?> id ="promotionSelected" name ="promotionSelected" value = "1">&nbsp;&nbsp;<i class="fa fa-tag fa-lg fa-fw"></i> Promotion
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input <?php if($calenderSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="calenderSelected" name = "calenderSelected" value = "1" >&nbsp;&nbsp;<i class="fa fa-calendar fa-lg fa-fw"></i> Calendar
                        </label>
                      </div>
                  </div>
                  
                  <div class="col-sm-5" id = "card_content_utilities_part_two" style = "display:none">
                     <div class="checkbox">
                        <label>
                          <input <?php if($requestMeetingSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="requestMeetingSelected" value = "1">&nbsp;&nbsp;<i class="fa fa-calendar-o fa-lg fa-fw"></i> Request Meeting
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input <?php if($shareFilesSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="shareFilesSelected" name = "shareFilesSelected" value = "1" >&nbsp;&nbsp;<i class="fa fa-download fa-lg fa-fw"></i> Share Files
                        </label>
                      </div>
                  </div>
                  
                  <div class="col-sm-5" id = "card_content_utilities_part_three" style = "display:none">
                     <div class="checkbox">
                        <label>
                          <input <?php if($customerServiceSelected==1) { ?>checked="checked"<?php } ?>type="checkbox" id ="customerServiceSelected" name ="customerServiceSelected" value = "1">&nbsp;&nbsp;<i class="fa fa-headphones fa-lg fa-fw"></i> Customer Service
                        </label>
                      </div>
                     
                  </div>
                  
                  
                  <!-- Social -->
                   <div class="col-sm-5" id = "card_content_social" style = "display:none">
                     <div class="checkbox">
                        <label>
                          <input <?php if($facebookSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="facebookSelected" name ="facebookSelected" value = "1">&nbsp;&nbsp;<i class="fa fa-facebook fa-lg fa-fw"></i> Facebook
                        </label>
                      </div>


                      <div class="checkbox">
                        <label>
                          <input <?php if($twitterSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="twitterSelected" name ="twitterSelected" value = "1">&nbsp;&nbsp;<i class="fa fa-twitter fa-lg fa-fw"></i> Twitter
                        </label>
                      </div>

                  <!-- Viber -->
                  <div class="col-sm-5" id = "card_content_contact_part_seven">
                     <div class="checkbox">
                        <label>
                          <input <?php if($viberSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="viberSelected" name ="viberSelected" value = "1">&nbsp;&nbsp;<i class="fa fa-phone fa-lg fa-fw"></i> Viber
                        </label>
                      </div>
                     
                  </div>
                  <!--  -->


                     <div class="checkbox">
                        <label>
                          <input <?php if($linkedinSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="linkedinSelected" name = "linkedinSelected"  value = "1">&nbsp;&nbsp;<i class="fa fa-linkedin fa-lg fa-fw"></i> Linked-In
                        </label>
                      </div>
                  </div>
                  
                  <div class="col-sm-5" id = "card_content_social_part_two" style = "display:none">
                     <div class="checkbox">
                        <label>
                          <input <?php if($tumblrSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="tumblrSelected" name ="tumblrSelected" value = "1">&nbsp;&nbsp;<i class="fa fa-tumblr fa-lg fa-fw"></i> tumblr
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input <?php if($youTubeSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="youTubeSelected" value = "1" >&nbsp;&nbsp;<i class="fa fa-youtube fa-lg fa-fw"></i> Youtube
                        </label>
                      </div>
                  </div>
                  
                  <div class="col-sm-5" id = "card_content_social_part_three" style = "display:none">
                     <div class="checkbox">
                        <label>
                          <input <?php if($spotifySelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="spotifySelected" name ="spotifySelected" value = "1">&nbsp;&nbsp;<i class="fa fa-music fa-lg fa-fw"></i> Spotify
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input <?php if($playStoreSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="playStoreSelected" name = "googlePlusSelected" value = "1" >&nbsp;&nbsp;<i class="fa fa-google-plus-square fa-lg fa-fw"></i> Google+
                        </label>
                      </div>
                  </div>
                  
                  <div class="col-sm-5" id = "card_content_social_part_four" style = "display:none">
                     <div class="checkbox">
                        <label>
                          <input <?php if($blogSelected==1) { ?>checked="checked"<?php } ?>  type="checkbox" id ="blogSelected" name ="blogSelected" value = "1">&nbsp;&nbsp;<i class="fa fa-edit fa-lg fa-fw"></i> Blog
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input <?php if($soundCloudSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="soundCloudSelected" name = "soundCloudSelected" value = "1" >&nbsp;&nbsp;<i class="fa fa-cloud fa-lg fa-fw"></i> Soundcloud
                        </label>
                      </div>
                  </div>
                   
                  <!-- -->
                  
                  <div class="col-sm-5" id = "card_content_contact_part_two">
                    
                      <div class="checkbox">
                        <label>
                          <input <?php if($appStoreSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" name = "appStoreSelected" id ="appStoreSelected"  value = "1">&nbsp;&nbsp;<i class="fa fa-apple fa-lg fa-fw"></i> Apple App Store
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input <?php if($playStoreSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id = "playStoreSelected" value = "1">&nbsp;&nbsp;<i class="fa fa-play fa-lg fa-fw"></i> Google Play Store
                        </label>
                      </div>
                  </div>
                  
                  
                  <!--  -->
                  <div class="col-sm-5" id = "card_content_contact_part_three">
                     <div class="checkbox">
                        <label>
                          <input <?php if($phoneNumberSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="phoneNumberSelected" name ="phoneNumberSelected" value = "1">&nbsp;&nbsp;<i class="fa fa-mobile fa-lg fa-fw"></i> Phone Number
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input <?php if($websiteSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="websiteSelected" name = "websiteSelected" value = "1" >&nbsp;&nbsp;<i class="fa fa-globe fa-lg fa-fw"></i> Website
                        </label>
                      </div>
                  </div>
                  <div class="col-sm-5" id = "card_content_contact_part_four">
                    <div class="checkbox">
                        <label>
                          <input <?php if($emailSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="emailSelected" name = "emailSelected"  value = "1">&nbsp;&nbsp;<i class="fa fa-envelope-o fa-lg fa-fw"></i> Email
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input <?php if($smsSelected==1) { ?>checked="checked"<?php } ?>  type="checkbox" id = "smsSelected" name = "smsSelected" value = "1">&nbsp;&nbsp;<i class="fa fa-envelope fa-lg fa-fw"></i> SMS
                        </label>
                      </div>
                  </div>
                  <!--  -->
                  
                  
                   <!--  -->
                  <div class="col-sm-5" id = "card_content_contact_part_five">
                     <div class="checkbox">
                        <label>
                          <input <?php if($skypeSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="skypeSelected" name ="skypeSelected" value = "1">&nbsp;&nbsp;<i class="fa fa-skype fa-lg fa-fw"></i> Skype
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input <?php if($addContactSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id ="addContactSelected"  name ="addContactSelected" value = "1">&nbsp;&nbsp;<i class="fa fa-users fa-lg fa-fw"></i> Add Contact
                        </label>
                      </div>
                  </div>
                  <div class="col-sm-5" id = "card_content_contact_part_six">
                    <div class="checkbox">
                        <label>
                          <input <?php if($addWeblinkSelected==1) { ?>checked="checked"<?php } ?>type="checkbox" id ="addWeblinkSelected" name ="addWeblinkSelected" value = "1">&nbsp;&nbsp;<i class="fa fa-chain fa-lg fa-fw"></i> Add Web Link
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input <?php if($addressSelected==1) { ?>checked="checked"<?php } ?> type="checkbox" id = "addressSelected" name ="addressSelected" value = "1">&nbsp;&nbsp;<i class="fa fa-map-marker fa-lg fa-fw"></i> Address
                        </label>
                      </div>
                  </div>
                  <!--  -->
                  
                 
                  
                  
                
            </div>
            <div class="row">
              <div class="col-md-12">
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
              <h3>Card Styling</h3>
                <p>Please select how you would like to style your card.</p>
                <div class="row">
                <input type = "hidden" name = "buttonFormat_DB" id = "buttonFormat_DB" value = "1">
                <input type = "hidden" name = "buttonStyle_DB" id = "buttonStyle_DB" value = "1">
                  <div class="col-sm-3">
                    <h4>Button Format</h4>
                    <a style = "text-decoration:none;" value = "tile" class="btn btn-default btn-block inner-glow" id = "button_format_steel_rubber"><i class="fa fa-th"></i> Tiles</a>
                    <a style = "text-decoration:none" class="btn btn-default btn-block inner-glow" id = "button_format_row"><i class="fa fa-align-justify"></i> Rows</a>
                  </div>
                  <div class="col-sm-3">
                    <h4>Button Style</h4>
                    <a style = "text-decoration:none;" class="btn btn-default btn-block inner-glow" id ="steel"><i class="fa fa-th"></i> Dark</a>
                    <a style = "text-decoration:none;" class="btn btn-default btn-block inner-glow" id ="rubber"><i class="fa fa-align-justify"></i> Light</a>
                  </div>
                  <div class="col-sm-6">
                    <h4>Colour</h4>
                    <table>
                      
                      <tr>
                        <td><h5>Header:&nbsp;&nbsp;</h5></td>
                        <td>
                          <div class="input-group" id ="color-box-header">
                            <span class="input-group-addon">#</span>
                            <input type="text" class="form-control" id="cardColour-header" name = "headerColour" placeholder="Color-header-header" value="<?php echo $headerColour;?>">
                            <span class="input-group-addon"><div class="color-picker-button" id = "input-group-addon_id" style = "background-color:#<?php echo $headerColour;?>"></div></span>
                          </div>
                        </td>
                      </tr>


                      <tr>
                        <td><h5>Button Bg:&nbsp;&nbsp;</h5></td>
                        <td>
                          <div class="input-group" id ="color-box">
                            <span class="input-group-addon">#</span>
                            <input type="text" class="form-control" id="cardColour" name = "cardColour" placeholder="Color" value="<?php echo $cardColour;?>">
                            <span class="input-group-addon"><div class="color-picker-button" id = "buttons_little_box_id" style = "background-color:#<?php echo $cardColour;?>"></div></span>
                          </div>
                        </td>
                      </tr>


                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <hr>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-12">
              <h3>CONTENT DETAILS</h3>
                <p>Please fill in the following fields.</p>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group"><input class="form-control" type="text" placeholder="First Name" name="firstName"></div>
                    <div class="form-group"><input class="form-control" type="text" placeholder="Last Name" name="lastName"></div>
                    <div class="form-group"><input class="form-control" type="text" placeholder="Email Address" name="email"></div>
                    <div class=<?php if($appStoreSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>  id = "txt_apple_store"><input class="form-control" type="text" placeholder="Apple Store" name="appStore"></div>                    
                    <div class=<?php if($playStoreSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   = "txt_play_store"><input class="form-control" type="text" placeholder="Google Play Store" name="playStore"></div>
                    <div class=<?php if($smsSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_sms"><input class="form-control" type="text" placeholder="SMS" name="sms"></div>
                    <div class=<?php if($addWeblinkSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   = "txt_weblink"><input class="form-control" type="text" placeholder="Add Web Link" name = "addWeblink"></div>
                    <div class=<?php if($addressSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>  id = "txt_address"><input class="form-control" type="text" placeholder="Address" name = "address"></div>
                    <div class=<?php if($phoneNumberSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_phone_number"><input class="form-control" type="text" placeholder="Phone Number" name = "phoneNumber"></div>
                    <div class=<?php if($websiteSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_website"><input class="form-control" type="text" placeholder="WebSite" name = "website"></div>
                    <div class=<?php if($skypeSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>  id = "txt_skype"><input class="form-control" type="text" placeholder="Skype" name = "skype"></div>
                    <div class=<?php if($addContactSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_add_contact"><input class="form-control" type="text" placeholder="Add Contact" name = "addContact"></div>
                    <div class=<?php if($facebookSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_facebook"><input class="form-control" type="text" placeholder="Facebook" name = "facebook"></div>
                    <div class=<?php if($twitterSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_twitter"><input class="form-control" type="text" placeholder="Twitter" name = "twitter"></div>
                    <div class=<?php if($linkedinSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_linkedin"><input class="form-control" type="text" placeholder="Linked-In" name = "linkedin"></div>
                    <div class=<?php if($blogSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_blog"><input class="form-control" type="text" placeholder="Blog" name = "blog"></div>
                    <div class=<?php if($soundCloudSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   = "txt_sound_cloud"><input class="form-control" type="text" placeholder="Soundcloud" name = "soundCloud"></div>
                    <div class=<?php if($tumblrSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_tumblr"><input class="form-control" type="text" placeholder="tumblr" name = "tumblr"></div>
                    <div class=<?php if($youTubeSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_youtube"><input class="form-control" type="text" placeholder="Youtube" name = "youTube"></div>
                    <div class=<?php if($spotifySelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_spotify"><input class="form-control" type="text" placeholder="Spotify" name = "spotify"></div>
                    <div class=<?php if($googlePlusSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_google_plus"><input class="form-control" type="text" placeholder="Google+" name = "googlePlus"></div>
                    <div class=<?php if($promotionSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_promotion"><input class="form-control" type="text" placeholder="Promotion" name = "promotion"></div>
                    <div class=<?php if($calenderSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_calendar"><input class="form-control" type="text" placeholder="Calendar" name = "calendar"></div>
                    <div class=<?php if($customerServiceSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_customer_service"><input class="form-control" type="text" placeholder="Customer Service" name = "customerService"></div>
                    <div class=<?php if($requestMeetingSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_request_meeting"><input class="form-control" type="text" placeholder="Request Meeting" name = "requestMeeting"></div>
                    <div class=<?php if($shareFilesSelected==1){?> "form-group" <?php } else {?> "form-group  hide-me" <?php } ?>   id = "txt_share_files"><input class="form-control" type="text" placeholder="Share Files" name = "shareFile"></div>
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <hr>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-12">
                
                <div class="row">
                  <div class="col-md-8">
                    <p>All progress will be saved. If you wish to continue creating this interaction at another time, you will find it in orders.</p>
                    <!--btn btn-primary btn-block btn-lg-->
                    <button class="btn btn-primary btn-block btn-lg" id="button_save_card" >Save Card Details <i class="fa fa-arrow-circle-right"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!--
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="input-group">
                     <input type="hidden" class="form-control" id = "fkUserId" name = "fkUserId" value = "<?php echo html_escape($template_details[0]->fkUserId);?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                   //-- <span class="btn btn-default"> <i class="fa fa-check"></i>SAVE</span>/
                    <input type="submit" id = "save_now" value ="Save and continue " class="btn btn-primary btn-block btn-lg"> 
                  
                  </div>
                </div>
              </div>
            </div>
            <div id = "upload_js"></div>
            
            <div class="row">
              <div class="col-md-12">
                <hr>
              </div>
            </div>
            
                -->
                                                       
          </div>
        </div>
      </div>
    </div>
    <div class="right-container">
      <div class="phone-preview-holder text-center">
        <h4 class="buffer-top-sm text-center">Digital Card Preview</h4>
        <div class="phone-graphic">
          <div class="camera"></div>
          <div class="screen lander lander-preview card-preview">

            <!--New phone-->
            <div class="lander-wrapper card">
  <div class="header" style = "background-color:#<?php echo $headerColour;?>">
    <div class="profile-image" style = "background-color:#<?php echo $headerColour;?>">
      <!--<img src="<?php echo base_url('img/phone/profile-photo.jpg');?>" style = "display:none; visibility:hidden">-->
    </div>
    <div class="logo">
      <?php
        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$logo) && (strlen($logo)>2))
          {
            ?><img style="margin-top:6px;" src="/uploads/<?php echo $logo;?>" id="target" alt="uploads/<?php echo $logo;?>" />
     <?php } ?>       
        
        
    </div>
    <div class="name-holder">
      <div class="padding">
        <!--<span class="name semi-bold">Richard Dupe</span>
        <span class="title light">Managing Director</span>
      -->
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="content">
    <div id = "button_format_div" class="<?php echo $button_class;?>" style = "background-color:#<?php echo $cardColour;?>"> <!--button-list -->
      <div class="button-holder <?php if($appStoreSelected!=1) { ?>hide-me<?php } ?>" id = "the_apple_store">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_appstore.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_appstore.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style" ><i class="fa fa-phone fa-lg"></i>&nbsp;&nbsp;A Store</a>
      </div>
      <div class="button-holder <?php if($skypeSelected!=1) { ?>hide-me<?php } ?>" id = "the_skype">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_skype.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_skype.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-skype fa-lg"></i>&nbsp;&nbsp;Skype</a>
      </div>

      <div class="button-holder <?php if($playStoreSelected!=1) { ?>hide-me<?php } ?>" id = "the_play_store">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_google_playstore.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_google_playstore.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-skype fa-lg"></i>&nbsp;&nbsp;P Store</a>
      </div>
       
      <div class="button-holder <?php if($smsSelected!=1) { ?>hide-me<?php } ?>" id = "the_sms">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_sms.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_sms.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-mobile fa-lg"></i>&nbsp;&nbsp;SMS</a>
      </div>

      <div class="button-holder <?php if($twitterSelected!=1) { ?>hide-me<?php } ?>" id = "the_twitter">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_twitter.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_twitter.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-twitter fa-lg"></i>&nbsp;&nbsp;Twitter</a>
      </div>

    <div class="button-holder <?php if($shareFilesSelected!=1) { ?>hide-me<?php } ?>" id = "the_share_files">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_share_files.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_share_files.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-mobile fa-lg"></i>&nbsp;&nbsp;Files</a>
      </div>

      <div class="button-holder <?php if($facebookSelected!=1) { ?>hide-me<?php } ?>" id = "the_facebook">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_facebook.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_facebook.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-facebook fa-lg"></i>&nbsp;&nbsp;Facebook</a>
      </div>
      
      <div class="button-holder <?php if($linkedinSelected!=1) { ?>hide-me<?php } ?>" id = "the_linkedin">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_linkedin.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_linkedin.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-linkedin fa-lg"></i>&nbsp;&nbsp;LinkedIn</a>
      </div>
      <div class="button-holder <?php if($websiteSelected!=1) { ?>hide-me<?php } ?>" id = "the_website">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_website.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_website.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-globe fa-lg"></i>&nbsp;&nbsp;Website</a>
      </div>

      <div class="button-holder <?php if($promotionSelected!=1) { ?>hide-me<?php } ?>" id = "the_promotion">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_promotion.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_promotion.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-globe fa-lg"></i>&nbsp;&nbsp;Promotion</a>
      </div>

      <div class="button-holder <?php if($spotifySelected!=1) { ?>hide-me<?php } ?>" id = "the_spotify">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_spotify.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_spotify.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-globe fa-lg"></i>&nbsp;&nbsp;Spotify</a>
      </div>

      <div class="button-holder <?php if($addWeblinkSelected!=1) { ?>hide-me<?php } ?>" id = "the_weblink">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_weblink.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_weblink.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-phone fa-lg"></i>&nbsp;&nbsp;Web</a>
      </div>
      <div class="button-holder <?php if($emailSelected!=1) { ?>hide-me<?php } ?>" id = "the_email">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_email.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_email.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Email</a>
      </div>

      <div class="button-holder <?php if($addContactSelected!=1) { ?>hide-me<?php } ?>" id = "the_add_contact">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_add_contact.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_add_contact.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Contact</a>
      </div>

      <div class="button-holder <?php if($youTubeSelected!=1) { ?>hide-me<?php } ?>" id = "the_youtube">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_youtube.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_youtube.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Youtube</a>
      </div>

      <div class="button-holder <?php if($addContactSelected!=1) { ?>hide-me<?php } ?>" id = "the_contact">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_contact.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_contact.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-phone fa-lg"></i>&nbsp;&nbsp;Contact</a>
      </div>

      <div class="button-holder <?php if($blogSelected!=1) { ?>hide-me<?php } ?>" id = "the_blog">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_blog.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_blog.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-phone fa-lg"></i>&nbsp;&nbsp;Blog</a>
      </div>

      <div class="button-holder <?php if($googlePlusSelected!=1) { ?>hide-me<?php } ?>" id = "the_google_plus">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_google+.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_google+.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-phone fa-lg"></i>&nbsp;&nbsp;Gplus</a>
      </div>

      <div class="button-holder <?php if($soundCloudSelected!=1) { ?>hide-me<?php } ?>" id = "the_sound_cloud">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_soundcloud.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_soundcloud.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-phone fa-lg"></i>&nbsp;&nbsp;SC</a>
      </div>

      <div class="button-holder <?php if($requestMeetingSelected!=1) { ?>hide-me<?php } ?>" id = "the_request_meeting">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_request_meeting.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_request_meeting.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-phone fa-lg"></i>&nbsp;&nbsp;SC</a>
      </div>

      <div class="button-holder h<?php if($addressSelected!=1) { ?>hide-me<?php } ?>" id = "the_address">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_address.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_address.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-phone fa-lg"></i>&nbsp;&nbsp;Address</a>
      </div>

      <div class="button-holder <?php if($phoneNumberSelected!=1) { ?>hide-me<?php } ?>" id = "the_phone_number">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_phone.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_phone.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-phone fa-lg"></i>&nbsp;&nbsp;Phone</a>
      </div>

       <div class="button-holder <?php if($customerServiceSelected!=1) { ?>hide-me<?php } ?>" id = "the_customer_service">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_customer_service.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_customer_service.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-phone fa-lg"></i>&nbsp;&nbsp;Cs</a>
      </div>

      <div class="button-holder <?php if($tumblrSelected!=1) { ?>hide-me<?php } ?>" id = "the_tumblr">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_tumblr.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_tumblr.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text rubber text_row_style"  style = "background:none"><i class="fa fa-phone fa-lg"></i>&nbsp;&nbsp;Tumblr</a>
      </div>

       <div class="button-holder <?php if($calenderSelected!=1) { ?>hide-me<?php } ?>" id = "the_calendar">
        <a href="#" class="button default"><img src="<?php echo base_url('img/phone/light_calendar.png');?>" class = "steel_format_button"></a>
        <a href="#" class="button rubber"><img src="<?php echo base_url('img/phone/dark_calendar.png');?>" class = "rubber_format_button" ></a>
        <a href="#" class="text default text_row_style"><i class="fa fa-phone fa-lg"></i>&nbsp;&nbsp;Calendar</a>
      </div>
      
      <div class="clearfix"></div>
    </div>
  </div>
</div>
<div class="footer" style="background:#<?php echo $headerColour;?>;">
  <div class="footer-logo"><img src="<?php echo base_url('img/phone/tactify-logo.png');?>"></div>
  <div class="clearfix"></div>
</div>
            <!--end New phone-->
           
              <!--  --> 
          </div>
          <div class="home-button"></div> 
          <script>
          //First Color Picker
          $('#color-box').colpick({
            colorScheme:'dark',
            layout:'rgbhex',
            color:'ff8800',
            onSubmit:function(hsb,hex,rgb,el) {
              $('#button_format_div').css('background-color', '#'+hex);
              //$('.text').css('background-color', '#'+hex);
              $('#cardColour').val(hex);  
              //$('.color-picker-button').css('background-color', '#'+hex);
              $('#buttons_little_box_id').css('background-color', '#'+hex);
              $(el).colpickHide();
            }
          });
          //



         //Header Color Picker
          $('#color-box-header').colpick({
            colorScheme:'dark',
            layout:'rgbhex',
            color:'ff8800',
            onSubmit:function(hsb,hex,rgb,el) {
              $('#header').css('background-color', '#'+hex);
              $('#cardColour-header').val(hex);  
              $('.profile-image').css('background-color', '#'+hex); 
              $('.header').css('background-color', '#'+hex);
              $('.footer').css('background-color', '#'+hex);
              $('#input-group-addon_id').css('background-color', '#'+hex);
              $(el).colpickHide();
            }
          });
          //

          
          </script>
                                                                    
        </div>
        <button class="btn btn-default">Large Preview</button>
        </div>
    </div>
  </div>
</div>
 <script>
    function checkrule1(strval)  //checking only alphabetic characters
{
    if (strval=="") 
        return "It should not be left blank";
    else if(strval.match("^[a-zA-Z]*$"))
       return "success";
    else
       return "It is not alphabetic value.";
}
function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
function checkrule2(strval)  //checking email format
{   
    if(strval.match("/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/"))
       return "success";
    else
       return "Invalid Email Format.";
}
//Validation    
function checkfirstname()
{
    var value=$('#val_firstname').val();
    return checkrule1(value);
}
function checklastname()
{
    var value=$('#val_lastname').val();
    return checkrule1(value);
}
function checkemail()
{   
    var value=$('#val_email').val();
    return validateEmail(value);
}
function checkappstore()
{
    var value=$('#val_app_store').val();
    return checkrule1(value);
}
function checkplaystore()
{
    var value=$('#val_play_store').val();
    return checkrule1(value);
}
function checksms()
{
    var value=$('#val_sms').val();
    return checkrule1(value);
}
function checkweblink()
{
    var value=$('#val_weblink').val();
    return checkrule1(value);
}
function checkaddress()
{
    var value=$('#val_address').val();
    return checkrule1(value);
}
function checkphonenumber()
{
    var value=$('#val_phone_number').val();
    return checkrule1(value);
}
function checkwebsite()
{
    var value=$('#val_website').val();
    return checkrule1(value);
}                    
function checkskype()
{
    var value=$('#val_skype').val();
    return checkrule1(value);
}
function checkaddcontact()
{
    var value=$('#val_add_contact').val();
    return checkrule1(value);
}
function checkfacebook()
{
    var value=$('#val_facebook').val();
    return checkrule1(value);
}
function checktwitter()
{
    var value=$('#val_twitter').val();
    return checkrule1(value);
}
function checklinkedin()
{
    var value=$('#val_linkedin').val();
    return checkrule1(value);
}
function checkblog()
{
    var value=$('#val_blog').val();
    return checkrule1(value);
}
function checksoundcloud()
{
    var value=$('#val_sound_cloud').val();
    return checkrule1(value);
}
function checktumblr()
{
    var value=$('#val_tumblr').val();
    return checkrule1(value);
}
function checkyoutube()
{
    var value=$('#val_youtube').val();
    return checkrule1(value);
}
function checkspotify()
{
    var value=$('#val_spotify').val();
    return checkrule1(value);
}

function checkgoogleplus()
{
    var value=$('#val_google_plus').val();
    return checkrule1(value);
}
function checkpromotion()
{
    var value=$('#val_promotion').val();
    return checkrule1(value);
}
function checkcalendar()
{
    var value=$('#val_calendar').val();
    return checkrule1(value);
}
function checkcustomerservice()
{
    var value=$('#val_customer_service').val();
    return checkrule1(value);
}
function checkrequestmeeting()
{
    var value=$('#val_request_meeting').val();
    return checkrule1(value);
}
function checksharefiles()
{
    var value=$('#val_share_files').val();
    return checkrule1(value);
}  
 </script>

 <script>$(function(){
      $("#logo").change(function(){
       // $("#ajax_loader").toggle();
       //   $("#template_form").submit();
      });
      $("#button_save_card").click(function(){
          alert('validation');
          e.preventDefault();
      });
      
  });</script>  
