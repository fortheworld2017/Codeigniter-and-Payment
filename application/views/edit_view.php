<?php 
//Groups Array
$groups_dropdown=array('0' => 'Change Group');
foreach($user_groups as $val =>$row)
  {
    $groups_dropdown[$row->id] = html_escape(ucwords($row->name));
  }
?>
    <div class="container-b">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 buffer-bottom-md">
            <div class="row">
              <div class="col-md-12 section-header" style="margin-bottom:60px;">
                <h1>Edit Interactions</h1>
                <p>Select a group or individual interaction to edit, delete or duplicate. If you have not completed the order, you will find your interactions inpending</p>
                <div class="btn-group">
                  <button type="button" class="btn btn-default inner-glow">Ordered</button>
                  <button type="button" class="btn btn-default inner-glow">Pending (9)</button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-5">
                <a href = "<?php echo base_url('creategroup');?>"<button class="btn btn-default pull-right">Create Group</button></a>
                <p>Create a group to organise your individual interactions</p>
              </div>
              <div class="col-md-5 col-md-offset-2">
                <div class="input-group">
                  <input type="text" class="form-control">
                  <span class="input-group-btn">
                    <button class="btn btn-default inner-glow" type="button">Go!</button>
                  </span>
                </div><!-- /input-group -->
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="edit-table-group">
                  
                  
                  
                    <?php
                      foreach($user_groups as $val=>$row)
                        {
                          ?>  
                            <div class="pull-right group-actions">
                              <a href="<?php echo base_url('editgroup/edit/'.$row->id);?>"><i class="fa fa-pencil fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                              <a href="#"><i class="fa fa-trash-o fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                              <a href="#"><i class="fa fa-user fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                            </div>
                            <h4><i class="fa fa-caret-down fa-lg"></i>&nbsp;&nbsp;&nbsp;<?php echo html_escape(ucwords($row->name));?></h4>
                            <table class="table edit-table table-striped">
                               
                               <?php 
                               $sql = "SELECT * FROM  TACTIFY_cardDetails WHERE fkUserId = ".$this->session->userdata['logged_data']['member_id']." AND fkGroupId = ".$row->id;
                                  $query = $this->db->query($sql);
                                  foreach ($query->result() as $row_details)
                                  {
                                     ?>
                                     <tr>
                                      <td width="50"><i class="fa fa-ticket fa-2x"></i></td>
                                      <td><?php echo html_escape(ucwords($row_details->firstName));?>&nbsp; <?php echo html_escape(ucfirst($row_details->lastName));?></td>
                                      <td>
                                         <?php
                                          echo form_open('edit/update_group');
                                          echo form_dropdown('groups', $groups_dropdown,'0', 'onchange="this.form.submit();" class="form-control selectwidthauto"');
                                          echo form_hidden('id', $row_details->id);
                                          echo form_close();
                                         ?> 
                                      </td>
                                      <td class="text-right">
                                        <a href="#"><i class="fa fa-pencil fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                                        <a href="#"><i class="fa fa-trash-o fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                                        <a href="#"><i class="fa fa-user fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                                      </td>
                                    </tr> 
                                     <?php
                                  }
                               ?> 
                                
                    
                          </table>  
                    <?php } ?>        
                                
                </div><!-- end edit table group -->
                <div class="edit-table-group">
                  <h4><i class="fa fa-caret-down fa-lg"></i>&nbsp;&nbsp;&nbsp;Uncategorised</h4>
                  <table class="table edit-table table-striped">
                    
                    <?php
                      
                      foreach($list_cards_with_no_group as $val=>$row)
                        {
                          ?>
                            <tr>
                              <td width="50"><i class="fa fa-ticket fa-2x"></i></td>
                              <td><?php echo html_escape(ucwords($row->firstName));?> <?php echo html_escape(ucwords($row->lastName));?></td>
                              <td>
                                <?php
                                  echo form_open('edit/update_group');
                                  echo form_dropdown('groups', $groups_dropdown,'0', 'onchange="this.form.submit();" class="form-control selectwidthauto"');
                                    echo form_hidden('id', $row->id);
                                  echo form_close();      
                                ?>    
                              </td>
                              <td class="text-right">
                                <a href="#"><i class="fa fa-pencil fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                                <a href="#"><i class="fa fa-trash-o fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                                <a href="#"><i class="fa fa-user fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                              </td>
                            </tr>
                    <?php } ?>        
                  </table>                
                </div><!-- end edit table group -->


                <!---->
                <h4><i class="fa fa-caret-down fa-lg"></i>&nbsp;&nbsp;&nbsp;Business Card Templates</h4>
                  <table class="table edit-table table-striped">
                    <?php
                      foreach($user_templates as $val=>$row)
                        {
                          ?>
                          <tr>
                            <td width="50"><i class="fa fa-ticket fa-2x"></i></td>
                            <td><?php echo $row->id;?></td>
                            <td>
                              <?php echo html_escape($row->templateName);?>
                            </td>
                            <td class="text-right">
                              <a href="<?php echo base_url('upload_csv/check/'.$row->id);?>">Upload Csv</a>&nbsp;&nbsp;&nbsp;
                              <a href="<?php echo base_url('template_csv/download/'.$row->id);?>">Download Csv Sturucture</a>&nbsp;&nbsp;&nbsp;
                              <a href="<?php echo base_url('editbusinesscard/edit/'.$row->id);?>"><i class="fa fa-pencil fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                              <a href="#"><i class="fa fa-trash-o fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                              <a href="#"><i class="fa fa-user fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                            </td>
                          </tr>
                    <?php  }?>      
                  </table>                
                </div><!-- end edit table group -->
                <div class="edit-table-group">
                  <div class="pull-right group-actions">
                    <a href="#"><i class="fa fa-pencil fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                    <a href="#"><i class="fa fa-trash-o fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                    <a href="#"><i class="fa fa-user fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                  </div>
                <!---->

                <div class="clearfix"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>