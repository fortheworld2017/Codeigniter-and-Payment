<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700' rel='stylesheet' type='text/css'>
<link href="css/tactify.css" rel="stylesheet">


<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

<script type="text/javascript">

//Initial load of page
$(document).ready(sizeContent);
//Every resize of window
$(window).resize(sizeContent);
//Dynamically assign height
function sizeContent() {
	if ($(".container-c").height() <= $(window).height() ) {
		var newPHHeight = ($(window).height()) + "px";
		$(".tactify-menu-container").css("height", newPHHeight);
		$(".tactify-sub-menu-container").css("height", newPHHeight);
		if ($(window).width() > 991) {
			$(".right-container").css("height", newPHHeight);
			$(".wrapper").css("width", "100%");
		}else{
			$(".right-container").css("height", "auto");
		};
	}else{
		var newHeight = $(".wrapper").height() + "px";
		$(".tactify-menu-container").css("height", newHeight);
		$(".tactify-sub-menu-container").css("height", newHeight);
		if ($(window).width() > 991) {
			$(".right-container").css("height", newHeight);
			$(".wrapper").css("width", "100%");
		}else{
			$(".right-container").css("height", "auto");
		};
	}
}
$(document).ready(function() {
	$('.tactify-menu-button').click(function(){
		var newWidth = ($(window).width()) + "px";
		$(".wrapper").css("width", newWidth);
	    $('.wrapper').toggleClass("slide-over");

	    sizeContent();
	});
});
</script>