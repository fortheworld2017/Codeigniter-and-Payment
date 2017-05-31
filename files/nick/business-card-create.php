<!DOCTYPE html>
<html>
<head>
  <title>Tactify</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once('includes/head.php'); ?>
</head>
<body>
  <?php require_once('includes/header.php'); ?>
  <div class="container-a">
    <?php require_once('includes/tactify-menu.php'); ?>
    <div class="container-b">
      <?php require_once('includes/breadcrumbs.php'); ?>
      <?php require_once('includes/tactify-sub-menu.php'); ?>
      <div class="container-c">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-8 buffer-bottom-md">
              <div class="row">
                <div class="col-md-12 section-header">
                  <h1>Create Business Card</h1>
                  <ul class="strip-ul stages">
                    <li>Content</li>
                    <li class="previous">Design</li>
                    <li class="current">Finalise</li>
                    <li>Shimmy</li>
                  </ul>
                  <h4>Step 3: Finalise Order and Payment</h4>
                  <hr>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                <h3>Use a Template</h3>
                  <p>If you have previously created a template for your digital profile please select it from the list, ortherwise select no template.</p>
                  <select class="form-control selectwidthauto">
                    <option>Tactify Cards</option>
                    <option>Streamline Ninja</option>
                    <option>Chunky but Funky</option>
                  </select>
                  <hr>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                <h3>Logo</h3>
                  <p>Upload a logo for the card.</p>
                  <button class="btn btn-primary buffer-bottom-sm">Upload File</button><br>
                  <small>Reccomended 250 px by 250 px transperant PNG</small>
                </div>
                <div class="col-md-6">
                <h3>Profile Pic <small>(Optional)</small></h3>
                  <p>Upload a profile picture for the card.</p>
                  <button class="btn btn-primary buffer-bottom-sm">Upload File</button><br>
                  <small>Reccomended 300px by 300px jpeg</small>
                </div>
              </div>
            </div>
            <div class="col-md-4 card-preview-holder">
              <h4 class="buffer-top-sm text-center">Digital Card Preview</h4>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once('includes/js.php'); ?>
</body>
</html>