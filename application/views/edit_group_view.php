<style type = "text/css">
  .rubber_format_button { display:none;}  
</style>

<div class="container-c">
  
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 buffer-bottom-md">
            <div class="row">
              <div class="col-md-12 section-header">
                <h1>Create Business Card</h1>
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
                echo form_open('editgroup/edit/'.$group_id, $attributes);
                foreach($user_templates as $val=>$row)
                  {
                      $templates[$row['id']] = $row['templateName'];  
                  }
                $class = 'class = "form-control selectwidthauto " onchange="this.form.submit();"';
                echo form_dropdown('template_id', $templates, $template_id,$class);
                echo form_hidden('template_used', 'tmeplate_used');
                ?>
              </form>
                <hr>
              </div>
            </div>
            <?php 
  $attributes = array('name' => 'template_form', 'id' => 'template_form', 'enctype' => 'multipart/form-data');
 echo form_open('updategroupcards/edit/'.$group_id, $attributes);
 echo form_hidden('load_from_template', $load_from_template);
 echo form_hidden('template_id', $template_id);?>
            
            <div class="row" style = "display:none; visibility:hidden">
              <div class="col-md-12">
                <h3>Select a Domain</h3>
                <p>If you have previously created a template for your digital profile please select it from the list, ortherwise select no template.</p>
                  <?php 
                    foreach($user_domains as $val=>$row)
                      {
                        echo "<input type = \"radio\" value = \"".$row->DID."\" name = \"fkCardDomainId\" id =\"".$row->DID."\" >
            &nbsp;<label for = \"".$row->DID."\">".$row->DOMAIN."</label><br />";
                      }
                  ?>
                <hr>
              </div>
            </div>
            
            
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

                    

                    //Tiles Button
                   /* $('#button_format_steel_rubber').click(function() {

                        $("#event-actions").hide();
                        $("#steel_rubber").show();
                        $('#buttonFormat_DB').val('1');
                        
                    }); 
*/
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


                    
                        
                    //Validation    
                    $('#save_now').click(function() {
                    var value = $('#template_name').val();
                    var errors = false;
                    if( value.length < 2 || value.length > 35  )
                        {
                            alert('Please select a name between 2 and 35 characters for this template');
                            var errors = true;
                        }
                    //
                    if (!$("input[name='fkCardDomainId']:checked").val())
                        {
                           var errors = true;
                           alert('Please select a domain for this template');
                        }
                       
                    
                    if(errors==false)
                        {
                            $( "#template_form" ).submit();
                        }
                    
                    }); 
                    //Ends Validation   


                    
                   /* $('#customerServiceSelected').click(function () {
                        $("#the_customer_service").toggle(this.checked);
                    });
                    */

                   //
                   $('#appStoreSelected').click(function () {
                        if($(this).is(":checked")) {
                            $('#the_apple_store').removeClass("hide-me");
                        } else {
                            $('#the_apple_store').addClass("hide-me");
                        }
                    });
                   // 

                   //
                   $('#customerServiceSelected').click(function () {
                        if($(this).is(":checked")) {
                            $('#the_customer_service').removeClass("hide-me");
                        } else {
                            $('#the_customer_service').addClass("hide-me");
                        }
                    });
                   // 

                    
                    $('#playStoreSelected').click(function () {
                        

                         if($(this).is(":checked")) {
                            $('#the_google_play_store').removeClass("hide-me");
                        } else {
                            $('#the_google_play_store').addClass("hide-me");
                        }
                    });
                    $('#requestMeetingSelected').click(function () {
                       // $("#the_request_meeting").toggle(this.checked);

                        if($(this).is(":checked")) {
                            $('#the_request_meeting').removeClass("hide-me");
                        } else {
                            $('#the_request_meeting').addClass("hide-me");
                        }
                    });


                    $('#playStoreSelected').click(function () {
                       // $("#the_request_meeting").toggle(this.checked);

                        if($(this).is(":checked")) {
                            $('#the_play_store').removeClass("hide-me");
                        } else {
                            $('#the_play_store').addClass("hide-me");
                        }
                    });


                    
                    $('#phoneNumberSelected').click(function () {
                       // $("#the_phone_number").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_phone_number').removeClass("hide-me");
                        } else {
                            $('#the_phone_number').addClass("hide-me");
                        }
                    });
                    $('#emailSelected').click(function () {
                        //$("#the_email").toggle(this.checked);
                         if($(this).is(":checked")) {
                            $('#the_email').removeClass("hide-me");
                        } else {
                            $('#the_email').addClass("hide-me");
                        }
                    });
                    $('#skypeSelected').click(function () {
                       // $("#the_skype").toggle(this.checked);
                         if($(this).is(":checked")) {
                            $('#the_skype').removeClass("hide-me");
                        } else {
                            $('#the_skype').addClass("hide-me");
                        }
                    });
                    $('#phoneNumberSelected').click(function () {
                       // $("#the_phone_number").toggle(this.checked);
                         if($(this).is(":checked")) {
                            $('#the_phone_number').removeClass("hide-me");
                        } else {
                            $('#the_phone_number').addClass("hide-me");
                        }
                    });
                    $('#viberSelected').click(function () {
                       // $("#the_viber").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_viber').removeClass("hide-me");
                        } else {
                            $('#the_viber').addClass("hide-me");
                        }
                    });
                    $('#addressSelected').click(function () {
                        //$("#the_address").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_address').removeClass("hide-me");
                        } else {
                            $('#the_address').addClass("hide-me");
                        }
                    });
                    $('#addWeblinkSelected').click(function () {
                        //$("#the_add_web_link").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_add_web_link').removeClass("hide-me");
                        } else {
                            $('#the_add_web_link').addClass("hide-me");
                        }
                    });
                    $('#websiteSelected').click(function () {
                        if($(this).is(":checked")) {
                            $('#the_website').removeClass("hide-me");
                        } else {
                            $('#the_website').addClass("hide-me");
                        }
                    });

                     // 
                    $('#addWeblinkSelected').click(function () {
                       // $("#the_share_files").toggle(this.checked);
                       if($(this).is(":checked")) {
                            $('#the_weblink').removeClass("hide-me");
                        } else {
                            $('#the_weblink').addClass("hide-me");
                        }
                    });
                     // 

                    $('#smsSelected').click(function () {
                        //$("#the_sms").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_sms').removeClass("hide-me");
                        } else {
                            $('#the_sms').addClass("hide-me");
                        }
                    });
                    $('#addContactSelected').click(function () {
                        //$("#the_add_contact").toggle(this.checked);
                         if($(this).is(":checked")) {
                            $('#the_add_contact').removeClass("hide-me");
                        } else {
                            $('#the_add_contact').addClass("hide-me");
                        }
                    });
                    $('#facebookSelected').click(function () {
                        //$("#the_facebook").toggle(this.checked);
                        
                        if($(this).is(":checked")) {
                            $('#the_facebook').removeClass("hide-me");
                        } else {
                            $('#the_facebook').addClass("hide-me");
                        }

                    });
                    $('#youtubeSelected').click(function () {
                       // $("#the_youtube").toggle(this.checked);
                       if($(this).is(":checked")) {
                            $('#the_youtube').removeClass("hide-me");
                        } else {
                            $('#the_youtube').addClass("hide-me");
                        }
                    });
                    $('#googleplusSelected').click(function () {
                        //$("#the_googleplus").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_google_plus').removeClass("hide-me");
                        } else {
                            $('#the_google_plus').addClass("hide-me");
                        }
                    });
                    $('#soundcloudSelected').click(function () {
                        //$("#the_soundcloud").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_soundcloud').removeClass("hide-me");
                        } else {
                            $('#the_soundcloud').addClass("hide-me");
                        }
                    });
                    $('#spotifySelected').click(function () {
                       // $("#the_spotify").toggle(this.checked);
                       if($(this).is(":checked")) {
                            $('#the_spotify').removeClass("hide-me");
                        } else {
                            $('#the_spotify').addClass("hide-me");
                        }
                    });
                    $('#blogSelected').click(function () {
                        //$("#the_blog").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_blog').removeClass("hide-me");
                        } else {
                            $('#the_blog').addClass("hide-me");
                        }
                    });
                    $('#linkedinSelected').click(function () {
                       // $("#the_linkedin").toggle(this.checked);
                       if($(this).is(":checked")) {
                            $('#the_linkedin').removeClass("hide-me");
                        } else {
                            $('#the_linkedin').addClass("hide-me");
                        }
                    });
                    $('#twitterSelected').click(function () {
                       // $("#the_twitter").toggle(this.checked);
                       if($(this).is(":checked")) {
                            $('#the_twitter').removeClass("hide-me");
                        } else {
                            $('#the_twitter').addClass("hide-me");
                        }
                    });
                    $('#tumblrSelected').click(function () {
                        //$("#the_tumblr").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_tumblr').removeClass("hide-me");
                        } else {
                            $('#the_tumblr').addClass("hide-me");
                        }
                    });



                      $('#soundcloudSelected').click(function () {
                        //$("#the_tumblr").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_sound_cloud').removeClass("hide-me");
                        } else {
                            $('#the_sound_cloud').addClass("hide-me");
                        }
                    });



                       $('#twitterSelected').click(function () {
                        //$("#the_tumblr").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_twitter').removeClass("hide-me");
                        } else {
                            $('#the_twitter').addClass("hide-me");
                        }
                    });


                    $('#youtubeSelected').click(function () {
                        //$("#the_tumblr").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_youtube').removeClass("hide-me");
                        } else {
                            $('#the_youtube').addClass("hide-me");
                        }
                    });  

                        
                    $('#calenderSelected').click(function () {
                        //$("#the_calendar").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_calendar').removeClass("hide-me");
                        } else {
                            $('#the_calendar').addClass("hide-me");
                        }
                    });
                    $('#promotionSelected').click(function () {
                        //$("#the_promotion").toggle(this.checked);
                        if($(this).is(":checked")) {
                            $('#the_promotion').removeClass("hide-me");
                        } else {
                            $('#the_promotion').addClass("hide-me");
                        }
                    });
                    $('#shareFilesSelected').click(function () {
                       // $("#the_share_files").toggle(this.checked);
                       if($(this).is(":checked")) {
                            $('#the_share_files').removeClass("hide-me");
                        } else {
                            $('#the_share_files').addClass("hide-me");
                        }
                    });



                      
                    
                    
                });

                      
      </script>
          
            
      
      
          <!-- Utilities -->
                   <div class="col-sm-5" id = "card_content_utilities" style = "display:none">
                     
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="promotionSelected" name ="promotionSelected" value = "1" <?php echo $promoChecked;?>>&nbsp;&nbsp;<i class="fa fa-tag fa-lg fa-fw"></i> Promotion
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="calenderSelected" name = "calenderSelected" value = "1" <?php echo $calendarChecked;?>>&nbsp;&nbsp;<i class="fa fa-calendar fa-lg fa-fw"></i> Calendar
                        </label>
                      </div>
                  </div>
                  
                  <div class="col-sm-5" id = "card_content_utilities_part_two" style = "display:none">
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" name = "requestMeetingSelected" id ="requestMeetingSelected" value = "1" <?php echo $requestMeetingChecked;?>>&nbsp;&nbsp;<i class="fa fa-calendar-o fa-lg fa-fw"></i> Request Meeting
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="shareFilesSelected" name = "shareFilesSelected" value = "1" <?php echo $shareFilesChecked;?>>&nbsp;&nbsp;<i class="fa fa-download fa-lg fa-fw"></i> Share Files
                        </label>
                      </div>
                  </div>
                  
                  <div class="col-sm-5" id = "card_content_utilities_part_three" style = "display:none">
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="customerServiceSelected" name ="customerServiceSelected" value = "1" <?php echo $customerServiceChecked;?>>&nbsp;&nbsp;<i class="fa fa-headphones fa-lg fa-fw"></i> Customer Service
                        </label>
                      </div>
                     
                  </div>
                  
                  
                  <!-- Social -->
                   <div class="col-sm-5" id = "card_content_social" style = "display:none">
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="facebookSelected" name ="facebookSelected" value = "1"<?php echo $facebookChecked;?>>&nbsp;&nbsp;<i class="fa fa-facebook fa-lg fa-fw"></i> Facebook
                        </label>
                      </div>


                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="twitterSelected" name ="twitterSelected" value = "1" <?php echo $twitterChecked;?>>&nbsp;&nbsp;<i class="fa fa-twitter fa-lg fa-fw"></i> Twitter
                        </label>
                      </div>

                  


                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="linkedinSelected" name = "linkedinSelected"  value = "1"<?php echo $linkedinChecked;?>>&nbsp;&nbsp;<i class="fa fa-linkedin fa-lg fa-fw"></i> Linked-In
                        </label>
                      </div>
                  </div>
                  
                  <div class="col-sm-5" id = "card_content_social_part_two" style = "display:none">
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="tumblrSelected" name ="tumblrSelected" value = "1"<?php echo $tumblrChecked;?>>&nbsp;&nbsp;<i class="fa fa-tumblr fa-lg fa-fw"></i> tumblr
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" name="youTubeSelected" id ="youtubeSelected" value = "1" <?php echo $youTubeChecked;?>>&nbsp;&nbsp;<i class="fa fa-youtube fa-lg fa-fw"></i> Youtube
                        </label>
                      </div>
                  </div>
                  
                  <div class="col-sm-5" id = "card_content_social_part_three" style = "display:none">
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="spotifySelected" name ="spotifySelected" value = "1"<?php echo $spotifyChecked;?>>&nbsp;&nbsp;<i class="fa fa-music fa-lg fa-fw"></i> Spotify
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="googlePlusSelected" name = "googlePlusSelected" value = "1" <?php echo $googlePlusChecked;?>>&nbsp;&nbsp;<i class="fa fa-google-plus-square fa-lg fa-fw"></i> Google+
                        </label>
                      </div>
                  </div>
                  
                  <div class="col-sm-5" id = "card_content_social_part_four" style = "display:none">
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="blogSelected" name ="blogSelected" value = "1" <?php echo $blogChecked;?>>&nbsp;&nbsp;<i class="fa fa-edit fa-lg fa-fw"></i> Blog
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="soundcloudSelected" name = "soundCloudSelected" value = "1" <?php echo $soundCloudChecked;?>>&nbsp;&nbsp;<i class="fa fa-cloud fa-lg fa-fw"></i> Soundcloud
                        </label>
                      </div>
                  </div>
                   
                  <!-- -->
                  
                  <div class="col-sm-5" id = "card_content_contact_part_two">
                    
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"  name = "appStoreSelected" id ="appStoreSelected"  value = "1" <?php echo $appStoreChecked;?>>&nbsp;&nbsp;<i class="fa fa-apple fa-lg fa-fw"></i> Apple App Store
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" name = "playStoreSelected" id = "playStoreSelected" value = "1" <?php echo $playStoreChecked;?>>&nbsp;&nbsp;<i class="fa fa-play fa-lg fa-fw"></i> Google Play Store
                        </label>
                      </div>
                  </div>
                  
                  
                  <!--  -->
                  <div class="col-sm-5" id = "card_content_contact_part_three">
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="phoneNumberSelected" name ="phoneNumberSelected" value = "1" <?php echo $phoneNumberChecked;?>>&nbsp;&nbsp;<i class="fa fa-mobile fa-lg fa-fw"></i> Phone Number
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="websiteSelected" name = "websiteSelected" value = "1" <?php echo $websiteChecked;?>>&nbsp;&nbsp;<i class="fa fa-globe fa-lg fa-fw"></i> Website
                        </label>
                      </div>
                  </div>
                  <div class="col-sm-5" id = "card_content_contact_part_four">
                    <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="emailSelected" name = "emailSelected"  value = "1" <?php echo $emailChecked;?>>&nbsp;&nbsp;<i class="fa fa-envelope-o fa-lg fa-fw"></i> Email
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id = "smsSelected" name = "smsSelected" value = "1" <?php echo $smsChecked;?>>&nbsp;&nbsp;<i class="fa fa-envelope fa-lg fa-fw"></i> SMS
                        </label>
                      </div>
                  </div>
                  <!--  -->
                  
                  
                   <!--  -->
                  <div class="col-sm-5" id = "card_content_contact_part_five">
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="skypeSelected" name ="skypeSelected" value = "1" <?php echo $skypeChecked;?>>&nbsp;&nbsp;<i class="fa fa-skype fa-lg fa-fw"></i> Skype
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="addContactSelected"  name ="addContactSelected" value = "1" <?php echo $contactChecked;?>>&nbsp;&nbsp;<i class="fa fa-users fa-lg fa-fw"></i> Add Contact
                        </label>
                      </div>
                  </div>
                  <div class="col-sm-5" id = "card_content_contact_part_six">
                    <div class="checkbox">
                        <label>
                          <input type="checkbox" id ="addWeblinkSelected" name ="addWeblinkSelected" value = "1" <?php echo $addWeblinkChecked;?>>&nbsp;&nbsp;<i class="fa fa-chain fa-lg fa-fw"></i> Add Web Link
                        </label>
                      </div>
                     <div class="checkbox">
                        <label>
                          <input type="checkbox" id = "addressSelected" name ="addressSelected" value = "1" <?php echo $addressChecked;?>>&nbsp;&nbsp;<i class="fa fa-map-marker fa-lg fa-fw"></i> Address
                        </label>
                      </div>
                  </div>
                  <!--  -->
                  
                 
                  
                  
                
            </div>
          
            
            
            
            <div class="row">
              <div class="col-lg-6 col-md-6">
                <hr>
                
                <div class=" <?php echo $playStore_hidden;?>" id = "the_play_store">
                    <input class="form-control" type="text" placeholder="Google Play Store" name = "playStore">
‌                </div>

                 <div class=" <?php echo $appStore_hidden;?>" id = "the_apple_store">
                    <input class="form-control" type="text" placeholder="Apple Store" name = "appStore">
‌                </div>

                <div class=" <?php echo $skype_hidden;?>" id = "the_skype">
                    <input class="form-control" type="text" placeholder="Skype" name = "skype">
‌                </div>

                <div class=" <?php echo $shareFile_hidden;?>" id = "the_share_files">
                    <input class="form-control" type="text" placeholder="Share Files" name = "shareFile">
‌                </div>

                <div class=" <?php echo $sms_hidden;?>" id = "the_sms">
                    <input class="form-control" type="text" placeholder="SMS" name = "sms">
‌                </div>

                <div class=" <?php echo $twitter_hidden;?>" id = "the_twitter">
                    <input class="form-control" type="text" placeholder="Twitter" name = "twitter">
‌                </div>

                <div class=" <?php echo $facebook_hidden;?>" id = "the_facebook">
                    <input class="form-control" type="text" placeholder="Facebook" name = "facebook">
‌                </div>

                <div class=" <?php echo $linkedin_hidden;?>" id = "the_linkedin">
                    <input class="form-control" type="text" placeholder="LinkedIn" name = "linkedin">
‌                </div>
                
                <div class=" <?php echo $website_hidden;?>" id = "the_website">
                    <input class="form-control" type="text" placeholder="Website" name = "website">
‌                </div> 

                <div class=" <?php echo $promotion_hidden;?>" id = "the_promotion">
                    <input class="form-control" type="text" placeholder="Promotion" name = "promotion">
‌                </div> 

                <div class=" <?php echo $spotify_hidden;?>" id = "the_spotify">
                    <input class="form-control" type="text" placeholder="Spotify" name = "spotify">
‌                </div> 

                <div class=" <?php echo $email_hidden;?>" id = "the_email">
                    <input class="form-control" type="text" placeholder="Email" name = "email">
‌                </div> 

                <div class=" <?php echo $addContact_hidden;?>" id = "the_add_contact">
                    <input class="form-control" type="text" placeholder="Add Contact" name = "addContact">
‌                </div> 

                <div class=" <?php echo $addWeblink_hidden;?>" id = "the_weblink">
                    <input class="form-control" type="text" placeholder="Weblink" name = "addWeblink">
‌                </div> 

                <div class=" <?php echo $blog_hidden;?>" id = "the_blog">
                    <input class="form-control" type="text" placeholder="Blog" name = "blog">
‌                </div> 

               

                <div class=" <?php echo $youTube_hidden;?>" id = "the_youtube">
                    <input class="form-control" type="text" placeholder="Youtube" name = "youTube">
‌                </div> 

                <div class=" <?php echo $googlePlus_hidden;?>" id = "the_google_plus">
                    <input class="form-control" type="text" placeholder="Google +" name = "googlePlus">
‌                </div> 



                <div class=" <?php echo $soundCloud_hidden;?>" id = "the_sound_cloud">
                    <input class="form-control" type="text" placeholder="Sound Cloud" name = "soundCloud">
‌                </div> 

                 <div class=" <?php echo $requestMeeting_hidden;?>" id = "the_request_meeting">
                    <input class="form-control" type="text" placeholder="Request Meeting" name = "requestMeeting">
‌                </div> 

                <div class=" <?php echo $address_hidden;?>" id = "the_address">
                    <input class="form-control" type="text" placeholder="Address" name = "address">
‌                </div> 

                <div class=" <?php echo $phoneNumber_hidden;?>" id = "the_phone_number">
                    <input class="form-control" type="text" placeholder="Phone Number" name = "phoneNumber">
‌                </div> 

                <div class=" <?php echo $customerService_hidden;?>" id = "the_customer_service">
                    <input class="form-control" type="text" placeholder="Customer Service" name = "customerService">
‌                </div> 

                <div class=" <?php echo $calendar_hidden;?>" id = "the_calendar">
                    <input class="form-control" type="text" placeholder="Calendar" name = "calendar">
‌                </div> 

                <div class=" <?php echo $tumblr_hidden;?>" id = "the_tumblr">
                    <input class="form-control" type="text" placeholder="Tumblr" name = "tumblr">
‌                </div> 


                



              </div>
            </div>
            
            
            
            
            <button class="btn btn-primary btn-block btn-lg">
              Save and Continue‌
              <i class="fa fa-arrow-circle-right"></i>
            </button>
            
          </div>
        </div>
      </div>
    </div>
    
     <div class="right-container">
      
     </div>
</div>


 <script>$(function(){
      $("#logo").change(function(){
        $("#ajax_loader").toggle();
          $("#template_form").submit();
      });
  });</script>  
