<!DOCTYPE html>
<html>
<head>
  <title>Tactify</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
   <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

	<link href="<?php echo base_url('components/css/bootstrap.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('components/css/font-awesome.min.css');?>" rel="stylesheet">
	<link href='//fonts.googleapis.com/css?family=Open+Sans+Condensed:700' rel='stylesheet' type='text/css'>
	<link href="<?php echo base_url('components/css/tactify.css');?>" rel="stylesheet">
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--<script src="https://code.jquery.com/jquery.js"></script>-->
<!--<script src="<?php //echo base_url('components/js/jquery.smooth-scroll.js');?>"></script>-->
<!--<script src="<?php //echo base_url('components/js/form_plugin.js');?>"></script>-->

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo base_url('components/js/jquery.js');?>"></script>
<script src="<?php echo base_url('components/js/bootstrap.min.js');?>"></script>

<script src="<?php echo base_url('components/color_picker/js/colpick.js');?>" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url('components/color_picker/css/colpick.css');?>" type="text/css"/>
		
		
<script type="text/javascript">

//Initial load of page
$(document).ready(sizeContent);
//Every resize of window
$(window).resize(sizeContent);
//Dynamically assign height
function sizeContent() {

	// Decide which menu is the tallest
	if ($("#main-menu").height() >= $("#sub-menu").height() && $("#main-menu").height() >= $(".sub-menu2").height()) {
		var menuHeight = $("#main-menu").height() + 80;
	}else if($("#sub-menu").height() >= $("#main-menu").height() && $("#sub-menu").height() >= $(".sub-menu2").height()) {
		var menuHeight = $("#sub-menu").height() + 110;
	}else if($(".sub-menu2").height() >= $("#main-menu").height() && $(".sub-menu2").height() >= $("#sub-menu").height()) {
		var menuHeight = $(".sub-menu2").height() + 140;
	}

	// Set the new height of the menu columns
	if ($(".wrapper").height() <= $(window).height() && menuHeight <= $(window).height()) {
		var newHeight = ($(window).height()) + "px";
	}else if ($(".wrapper").height() <= $(window).height() && menuHeight > $(window).height()) {
		var newHeight = menuHeight + "px";
	}else{
		if ($(".wrapper").height() <= menuHeight) {
			var newHeight = menuHeight + "px";
		}else{
			var newHeight = $(".wrapper").height() + "px";
		};
	};
	$(".tactify-menu-container").css("height", newHeight);
	$(".tactify-sub-menu-container").css("height", newHeight);

	//Reset some stuff at breakpoint
	if ($(window).width() > 991) {
		$(".right-container").css("height", newHeight);
		$(".wrapper").css("width", "100%");
	}else{
		$(".right-container").css("height", "auto");
	};
}
$(document).ready(function() {
	$('.tactify-menu-button').click(function(){
		var newWidth = ($(window).width()) + "px";
		$(".wrapper").css("width", newWidth);
	    $('.wrapper').toggleClass("slide-over");

	    sizeContent();
	});
});
</script><link href="<?php echo base_url('components/css/lander.css');?>" rel="stylesheet">
</head>
<body <?php	if($this->uri->segment(1)=='log_in')
			echo 'class="login-page"';
	  ?>>

  <!-- Header -->
  <div class="wrapper">
	  <div class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="navbar-header">
    <a href="#" class="tactify-menu-button"><i class="fa fa-bars"></i></a>
    <a href="#" class="logo"><img src="<?php echo base_url('img/logo.png');?>" /></a>
  </div>
  <div class="pull-right user-details">
      <a href="#"><span class="semi-bold"><?php echo $username;?></span></a>
      <?php echo $log_out_button;?>
  </div><!--/.nav-collapse -->
</div>
	<!-- Header End-->
	
	<!-- Breadcrumbs -->
      <div class="breadcrumbs">
		<?php echo $bread_crumb_title;?>
	</div>
      <!-- End Breadcrumbs -->
  <div class="container-a">
  	
  	

      