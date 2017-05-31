<div class="container-c">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 section-header buffer-bottom-md">
              <h1>New Password</h1>
              <?php echo $expiry;?><br /><br />
              <?php echo validation_errors(); ?>
						<?php 
						$attributes = array('role' => 'form');
						echo form_open(site_url('new_password/update/'.$email.'/'.$token), $attributes);
						?>
                         <div class="form_row">
                             <p class="form_pra">New Password</p>
                             <?php 
							  $data = array(
				              'name'        => 'password',
				              'class'       => 'form_input_1',
							  'placeholder' => ''
							  
				            );
							echo form_password($data);
							  ?><br /><br />
							   <p class="form_pra">Repeat Password</p>
							  <?php 
							  $data = array(
				              'name'        => 'password_repeat',
				              'class'       => 'form_input_1',
							  'placeholder' => ''
							  
				            );
							echo form_password($data);
							
							  ?><br /><br />
						<?php 
						echo form_submit('submit', 'Reset');
						?>	  
                         </div>
              <br /><br />

            </div>
          </div>
          
        </div>
      </div>