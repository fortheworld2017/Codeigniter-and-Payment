    <div class="container-b">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 buffer-bottom-md">
            <div class="row">
              <div class="col-lg-6 col-md-6 section-header" style="margin-bottom:60px;">
                <h1>Upload CSV</h1>
                <?php echo $error['error'];?>
                <?php
                  if($success!=TRUE)
                      {?>
                <p>Select a csv format file to upload
                 <?php 
                      $attributes = array('name' => 'upload_csv', 'id' => 'upload_csv');
                      echo form_open_multipart('upload_csv/check/'.$id, $attributes);
                      $file_data = array('name'  => 'file');
                      echo form_upload($file_data);
                      $submit_data = array('name'  => 'submit', 'value' =>'Upload', 'class' => 'btn btn-primary btn-block btn-lg');
                 ?>
                  <div class="col-md-6">
                    <br /><?php     
                       echo form_submit($submit_data);
                    ?>
                  </div>
                  <?php } ?>

                </p>
              </div>
            </div>
                </div><!-- end edit table group -->
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
        