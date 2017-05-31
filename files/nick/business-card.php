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
            <div class="col-md-12 section-header buffer-bottom-md">
              <h1>Create Business Card</h1>
              <p class="lead">Order and create your own personalised NFC business cards. All your details are now only a tap away, created simply and stylishly using Tactify.</p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 text-center">
            <img src="img/business-card/bc1.jpg" alt="Business Card Image" />
            </div>
            <div class="col-md-6">
            <h4 class="double-lined"><i class="fa fa-search"></i> Details</h4>
            <p>Create Interactive NFC business cards by simply selecting a suite of options including social media, saving card details, requesting meetings and more. Then just submit your card designs, and they will be printed and sent directly to your door.</p>

            <h5>Download card template</h5>
            <p>Before getting started you can download the printed card template here. You will need this to finalise your order.</p>
            <p>
              <img src="img/global/icon-indesign.gif" alt="Business Card Image" />
              <img src="img/global/icon-illustrator.gif" alt="Business Card Image" />
              QR and NFC
            </p>
            <p>
              <img src="img/global/icon-indesign.gif" alt="Business Card Image" />
              <img src="img/global/icon-illustrator.gif" alt="Business Card Image" />
              NFC Only
            </p>
            <p>
              <img src="img/global/icon-indesign.gif" alt="Business Card Image" />
              <img src="img/global/icon-illustrator.gif" alt="Business Card Image" />
              QR Only
            </p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 text-center">
            <img src="img/business-card/bc2.jpg" alt="Business Card Image" />
            </div>
            <div class="col-md-6">
              <h4 class="double-lined"><i class="fa fa-square"></i> Create Single Card</h4>
              <button class="btn btn-primary pull-right">Create</button>
              <p>Create and order a set of cards for a single user  from scratch or using a created template.</p>
              <h4 class="double-lined"><i class="fa fa-th-large"></i> Create Multiple Cards</h4>
              <button class="btn btn-primary pull-right">Create</button>
              <p>Update a CSV to create multiple sets of cards with using the same digital template.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once('includes/js.php'); ?>
</body>
</html>