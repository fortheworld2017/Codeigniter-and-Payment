<div class="login-container">
        <div class="container-fluid">
          <!---->
          <div class="row">
            <div class="col-md-4 col-md-offset-4 section-header buffer-bottom-md">
              <h1>Please sign in</h1>
              <?php echo validation_errors(); ?>
                <?php 
                $attributes = array('style' => 'padding:0 50px;');
                echo form_open('log_in/check', $attributes);
                ?>
                <table width="100%" cellpadding="5">
                  <tr>
                    <td>
                      Username:
                    </td>
                    <td>
                      <?php
                       $data_username = array('name'  => 'username', 'class' =>'form-control');
                       echo form_input($data_username);
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Password:
                    </td>
                    <td>
                      <?php
                       $data_password = array('name'  => 'password', 'class' =>'form-control');
                       echo form_password($data_password);
                      ?>
                    </td>
                  </tr>
                </table>
                <br>
                <input class="btn btn-primary" type="submit" name="submit" value="Login"><br><br>
                <a href="<?php echo site_url('forgot_password');?>">I can't access my account</a>
              </form>
            </div>
          </div>
          <!---->
          
        </div>
      </div>