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
                  alert('Hi');

                    //Change button type
                    $('#rubber').click(function() {
                            $('#customer_service_image').attr('src','<?php echo base_url('components/tileicon/rubber/contact.png')?>');
                          $('#soundcloud_image').attr('src','<?php echo base_url('components/tileicon/rubber/soundcloud.png')?>');
                          $('#request_meeting_image').attr('src','<?php echo base_url('components/tileicon/rubber/request_meet.png')?>');
                        $('#googleplus_image').attr('src','<?php echo base_url('components/tileicon/rubber/ios_appstore.png')?>');
                          $('#blog_image').attr('src','<?php echo base_url('components/tileicon/rubber/blog.png')?>');
                          $('#spotify_image').attr('src','<?php echo base_url('components/tileicon/rubber/spotify.png')?>');
                          $('#youtube_image').attr('src','<?php echo base_url('components/tileicon/rubber/youtube.png')?>');
                          $('#tumblr_image').attr('src','<?php echo base_url('components/tileicon/rubber/tumblr.png')?>');
                          $('#linkedin_image').attr('src','<?php echo base_url('components/tileicon/rubber/linkedin.png')?>');
                          $('#facebook_image').attr('src','<?php echo base_url('components/tileicon/rubber/facebook.png')?>');
                          $('#viber_image').attr('src','<?php echo base_url('components/tileicon/rubber/viber.png')?>');
                          $('#add_contact_image').attr('src','<?php echo base_url('components/tileicon/rubber/contact.png')?>');
                          $('#add_web_link_image').attr('src','<?php echo base_url('components/tileicon/rubber/contact2.png')?>');
                          $('#address_image').attr('src','<?php echo base_url('components/tileicon/rubber/map.png')?>');
                        $('#skype_image').attr('src','<?php echo base_url('components/tileicon/rubber/skype.png')?>');
                          $('#sms_image').attr('src','<?php echo base_url('components/tileicon/rubber/sms.png')?>');
                          $('#website_image').attr('src','<?php echo base_url('components/tileicon/rubber/www.png')?>');
                          $('#email_image').attr('src','<?php echo base_url('components/tileicon/rubber/mail.png')?>');
                          $('#phone_image').attr('src','<?php echo base_url('components/tileicon/rubber/phone.png')?>');
                          $('#ios_appstore_image').attr('src','<?php echo base_url('components/tileicon/rubber/iosapp_store.png')?>');
                          $('#google_play_store_image').attr('src','<?php echo base_url('components/tileicon/rubber/google_platstore.png')?>');
                          $('#request_meet_image').attr('src','<?php echo base_url('components/tileicon/rubber/request_meet.png')?>');
                          $('#promotion_image').attr('src','<?php echo base_url('components/tileicon/rubber/promotion.png')?>');
                          $('#calander_image').attr('src','<?php echo base_url('components/tileicon/rubber/calender.png')?>');
                          $('#share_files_image').attr('src','<?php echo base_url('components/tileicon/rubber/shared_doc.png')?>');
                    }); 
                    //Change button type


                    //Change button type
                    $('#steel').click(function() {

                        $('#soundcloud_image').attr('src','<?php echo base_url('components/tileicon/metal/soundcloud.png')?>');
                          $('#request_meeting_image').attr('src','<?php echo base_url('components/tileicon/metal/request_meet.png')?>');
                        $('#googleplus_image').attr('src','<?php echo base_url('components/tileicon/metal/ios_appstore.png')?>');
                          $('#blog_image').attr('src','<?php echo base_url('components/tileicon/metal/blog.png')?>');
                          $('#spotify_image').attr('src','<?php echo base_url('components/tileicon/metal/spotify.png')?>');
                          $('#youtube_image').attr('src','<?php echo base_url('components/tileicon/metal/youtube.png')?>');
                          $('#tumblr_image').attr('src','<?php echo base_url('components/tileicon/metal/tumblr.png')?>');
                          $('#add_contact_image').attr('src','<?php echo base_url('components/tileicon/metal/contact.png')?>');
                          $('#linkedin_image').attr('src','<?php echo base_url('components/tileicon/metal/linkedin.png')?>');
                          $('#facebook_image').attr('src','<?php echo base_url('components/tileicon/metal/facebook.png')?>');
                          $('#viber_image').attr('src','<?php echo base_url('components/tileicon/metal/viber.png')?>');
                          $('#add_web_link_image').attr('src','<?php echo base_url('components/tileicon/metal/contact2.png')?>');
                          $('#address_image').attr('src','<?php echo base_url('components/tileicon/metal/map.png')?>');
                          $('#skype_image').attr('src','<?php echo base_url('components/tileicon/metal/skype.png')?>');
                          $('#sms_image').attr('src','<?php echo base_url('components/tileicon/metal/sms.png')?>');
                          $('#website_image').attr('src','<?php echo base_url('components/tileicon/metal/www.png')?>');
                          $('#email_image').attr('src','<?php echo base_url('components/tileicon/metal/mail.png')?>');
                          $('#phone_image').attr('src','<?php echo base_url('components/tileicon/metal/phone.png')?>');
                          $('#ios_appstore_image').attr('src','<?php echo base_url('components/tileicon/metal/ios_appstore.png')?>');
                          $('#google_play_store_image').attr('src','<?php echo base_url('components/tileicon/metal/google_platstore.png')?>');
                          $('#request_meet_image').attr('src','<?php echo base_url('components/tileicon/metal/request_meet.png')?>');
                          $('#promotion_image').attr('src','<?php echo base_url('components/tileicon/metal/promotion.png')?>');
                          $('#calander_image').attr('src','<?php echo base_url('components/tileicon/metal/calender.png')?>');
                          $('#share_files_image').attr('src','<?php echo base_url('components/tileicon/metal/shared_doc.png')?>');
                          $('#customer_service_image').attr('src','<?php echo base_url('components/tileicon/metal/contact.png')?>');
                      });   
                    //Change button type

                    //Rows button:
                    $('#button_format_row').click(function() {
                                $("#event-actions").show();
                                $("#steel_rubber").hide();
                                $('#buttonFormat_DB').val('2');
                    }); 

                    //Tiles Button
                    $('#button_format_steel_rubber').click(function() {

                        $("#event-actions").hide();
                        $("#steel_rubber").show();
                        $('#buttonFormat_DB').val('1');
                        
                    }); 

                    //Still
                    $('#steel').click(function() {
                        $('#buttonStyle_DB').val('1');  
                    }); 


                    //Rubber
                    $('#rubber').click(function() {
                        $('#buttonStyle_DB').val('2');  
                    }); 


                    
                        
                    //Validation    
                    $('#save_now').click(function() {

                    
                    
                    var value = $('#template_name').val();
                    if( value.length < 2 || value.length > 35  )
                        {
                            alert('Please select a name between 2 and 35 characters for this template');
                        }
                    else
                        {
                            $( "#template_form" ).submit();
                        }
                    }); 
                    //Ends Validation   


                    
                    $('#customerServiceSelected').click(function () {
                        $("#customer_service").toggle(this.checked);
                        $("#customer_service_row").toggle(this.checked);
                    });
                    $('#app_storeSelected').click(function () {
                        $("#app_store").toggle(this.checked);
                        $("#app_store_row").toggle(this.checked);
                    });
                    $('#google_play_storeSelected').click(function () {
                        $("#google_play_store").toggle(this.checked);
                        $("#google_play_store_row").toggle(this.checked);
                    });
                    $('#request_meetingSelected').click(function () {
                        $("#request_meeting").toggle(this.checked);
                        $("#request_meeting_row").toggle(this.checked);
                    });
                    $('#phoneNumberSelected').click(function () {
                        $("#phone_number").toggle(this.checked);
                        $("#phone_number_row").toggle(this.checked);
                    });
                    $('#emailSelected').click(function () {
                        $("#email").toggle(this.checked);
                        $("#email_row").toggle(this.checked);
                    });
                    $('#skypeSelected').click(function () {
                        $("#skype").toggle(this.checked);
                        $("#skype_row").toggle(this.checked);
                    });
                    $('#phoneNumberSelected').click(function () {
                        $("#phone_number").toggle(this.checked);
                        $("#phone_number_row").toggle(this.checked);
                    });
                    $('#viberSelected').click(function () {
                        $("#viber").toggle(this.checked);
                        $("#viber_row").toggle(this.checked);
                    });
                    $('#addressSelected').click(function () {
                        $("#address").toggle(this.checked);
                        $("#address_row").toggle(this.checked);
                    });
                    $('#addWeblinkSelected').click(function () {
                        $("#add_web_link").toggle(this.checked);
                        $("#add_web_link_row").toggle(this.checked);
                    });
                    $('#websiteSelected').click(function () {
                        $("#website").toggle(this.checked);
                        $("#website_row").toggle(this.checked);
                    });
                    $('#smsSelected').click(function () {
                        $("#sms").toggle(this.checked);
                        $("#sms_row").toggle(this.checked);
                    });
                    $('#addContactSelected').click(function () {
                        $("#add_contact").toggle(this.checked);
                        $("#add_contact_row").toggle(this.checked);
                    });
                    $('#facebookSelected').click(function () {
                        $("#facebook").toggle(this.checked);
                        $("#facebook_row").toggle(this.checked);
                    });
                    $('#youtubeSelected').click(function () {
                        $("#youtube").toggle(this.checked);
                        $("#youtube_row").toggle(this.checked);
                    });
                    $('#googleplusSelected').click(function () {
                        $("#googleplus").toggle(this.checked);
                        $("#googleplus_row").toggle(this.checked);
                    });
                    $('#soundcloudSelected').click(function () {
                        $("#soundcloud").toggle(this.checked);
                        $("#soundcloud_row").toggle(this.checked);
                    });
                    $('#spotifySelected').click(function () {
                        $("#spotify").toggle(this.checked);
                        $("#spotify_row").toggle(this.checked);
                    });
                    $('#blogSelected').click(function () {
                        $("#blog").toggle(this.checked);
                        $("#blog_row").toggle(this.checked);
                    });
                    $('#linkedinSelected').click(function () {
                        $("#linkedin").toggle(this.checked);
                        $("#linkedin_row").toggle(this.checked);
                    });
                    $('#tumblrSelected').click(function () {
                        $("#tumblr").toggle(this.checked);
                        $("#tumblr_row").toggle(this.checked);
                    });
                    $('#calenderSelected').click(function () {
                        $("#calendar").toggle(this.checked);
                        $("#calendar_row").toggle(this.checked);
                    });
                    $('#promotionSelected').click(function () {
                        $("#promotion").toggle(this.checked);
                        $("#promotion_row").toggle(this.checked);
                    });
                    $('#shareFilesSelected').click(function () {
                        $("#share_files").toggle(this.checked);
                        $("#share_files_row").toggle(this.checked);
                    });


                    
                    
                });
