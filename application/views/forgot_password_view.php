<div class="container-c">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 section-header buffer-bottom-md">
              <h1>Forgot Password?</h1>
              <?php echo validation_errors(); ?>
              <?php 
              echo form_open('forgot_password/check');
              echo "Enter email: ";
              echo form_input('email');
              echo "<br /><br />";
              echo form_submit('submit', 'Reset');
              ?>
              <br /><br />

            </div>
          </div>
          
        </div>
      </div>