    <div class="container-b">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 section-header">
            <h1>Account</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <hr>
          </div>
        </div>
        <?php 
		  $attributes = array('name' => 'account_form', 'id' => 'account_form', 'enctype' => 'multipart/form-data');
		  echo form_open('account/update', $attributes);
		  //echo print_r($user_details[0]);
		  ?>
        <div class="row">
          <div class="col-md-4">
            <h4>Username/Password</h4>
            <div class="form-group"><input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= $user_details[0]->username ?>"></div>
            <div class="form-group"><input type="password" class="form-control" name="oldPassword" id="oldPassword" placeholder="Old Password"></div>
            <div class="form-group"><input type="password" class="form-control" placeholder="New Password"></div>
            <div class="form-group"><input type="password" class="form-control" placeholder="Confirm Password"></div>
            <h4>Profile Pic <small>(Optional)</small></h4>
            <div class="profile-pic">
              <a class="remove btn-danger" href="#"><i class="fa fa-times"></i></a>
              <img src="img/phone/profile-photo.jpg">
            </div>
            <button class="btn btn-default buffer-bottom-sm">Upload File</button><br>
            <small>Recommended 250 px by 250 px transparent PNG</small>
          </div>
          <div class="col-md-4">
            <h4>Contact Details</h4>
            <div class="form-group"><input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" value="<?= $user_details[0]->firstName ?>"></div>
            <div class="form-group"><input type="text" class="form-control" id="surName" name="surName" placeholder="Surname" class="form-control" value="<?= $user_details[0]->surName ?>"></div>
            <div class="form-group"><input type="text" class="form-control" id="company" name="company" placeholder="Company" class="form-control" value="<?= $user_details[0]->company ?>"></div>
            <div class="form-group"><input type="text" class="form-control" id="telephone" name="telephone" placeholder="Telephone" class="form-control" value="<?= $user_details[0]->telephone ?>"></div>
            <div class="form-group"><input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile" class="form-control" value="<?= $user_details[0]->mobile ?>"></div>
            <div class="form-group"><input type="text" class="form-control" id="email" name="email" placeholder="E-mail" class="form-control" value="<?= $user_details[0]->email ?>" readonly></div>
            <div class="form-group"><input type="text" class="form-control" id="website" name="website" placeholder="Website" class="form-control" value="<?= $user_details[0]->website ?>"></div>
          </div>
          <div class="col-md-4">
            <h4>Postal Address</h4>
            <div class="form-group"><input type="text" class="form-control" id="streetName" name="streetName" placeholder="Street Name" value="<?= $user_details[0]->streetName ?>"></div>
            <div class="form-group"><input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?= $user_details[0]->city ?>"></div>
            <div class="form-group"><input type="text" class="form-control" id="state" name="state" placeholder="State" value="<?= $user_details[0]->state ?>"></div>
            <div class="form-group"><input type="text" class="form-control" id="zipCode" name="zipCode" placeholder="ZIP Code" value="<?= $user_details[0]->zipCode ?>"></div>
            <div class="form-group"><input type="text" class="form-control" id="country" name="country" placeholder="Country" value="<?= $user_details[0]->country ?>"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <hr>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <button class="btn btn-primary">Save Details</button>
          </div>
        </div>
      </div>
    </div>
  </div>

