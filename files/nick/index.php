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
              <h1>Table of Contents</h1>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 buffer-bottom-md">
              <ul>
                <li><a href="business-card.php">Business Card Landing Page</a></li>
                <li><a href="business-card-create.php">Business Card Create</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once('includes/js.php'); ?>
</body>
</html>