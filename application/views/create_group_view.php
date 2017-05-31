    <div class="container-b">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 buffer-bottom-md">
            <?php echo validation_errors(); ?>
            <?php 
                      echo $error."<br /><br />";

                      $attributes = array('name' => 'create_group', 'id' => 'upload_csv');
                      echo form_open_multipart('creategroup', $attributes);
                      

                      echo "Group Name<br /><br />";
                      $data = array('name'=>'group_name',  'class' =>'form-control' );
                      echo form_input($data);
                      $submit_data = array('name'  => 'submit', 'value' =>'Add Group', 'class' => 'btn btn-primary btn-block btn-sm');
                 ?>
                  <div class="col-md-6">
                    <br /><?php     
                       echo form_submit($submit_data);
                    ?>
                  </div>
          </div>
        </div>
      </div>
    </div>