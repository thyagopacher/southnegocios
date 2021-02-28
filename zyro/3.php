<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Contacts</title>
	<base href="{{base_url}}" />
			<meta name="viewport" content="width=992" />
		<meta name="description" content="" />
	<meta name="keywords" content="" />
		<meta name="generator" content="Zyro - Website Builder" />
	
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery-1.8.3.min.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<script src="js/main.js" type="text/javascript"></script>

	<link href="css/site.css?v=1.0.14" rel="stylesheet" type="text/css" />
	<link href="css/common.css?ts=1447089478" rel="stylesheet" type="text/css" />
	<link href="css/3.css?ts=1447089478" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript">var currLang = '';</script>		
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>


<body>{{ga_code}}<div class="root"><div class="vbox wb_container" id="wb_header">
	
<div id="wb_element_instance18" class="wb_element"><ul class="hmenu"><li><a href="Home/" target="_self" title="Home">Home</a></li><li><a href="Products/" target="_self" title="Products">Products</a></li><li class="active"><a href="Contacts/" target="_self" title="Contacts">Contacts</a></li></ul></div></div>
<div class="vbox wb_container" id="wb_main">
	
<div id="wb_element_instance20" class="wb_element"><img alt="" src="gallery_gen/350b22658709f30c146599365d43c5d7_400x200.jpg"></div><div id="wb_element_instance21" class="wb_element" style=" line-height: normal;"><h1 class="wb-stl-heading1">Contacts</h1></div><div id="wb_element_instance22" class="wb_element" style=" line-height: normal;"><p class="wb-stl-normal">Vestibulum antve ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Cras sapien mauris. antve ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Cras sapie. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo.</p></div><div id="wb_element_instance23" class="wb_element"><form class="wb_form" method="post"><input type="hidden" name="wb_form_id" value="4ca9926f"><textarea name="message" rows="3" cols="20" class="hpc"></textarea><table><tr><th>Name&nbsp;&nbsp;</th><td><input type="hidden" name="wb_input_0" value="Name"><input class="form-field" type="text" value="" name="wb_input_0"></td></tr><tr><th>E-mail&nbsp;&nbsp;</th><td><input type="hidden" name="wb_input_1" value="E-mail"><input class="form-field" type="text" value="" name="wb_input_1"></td></tr><tr class="area-row"><th>Message&nbsp;&nbsp;</th><td><input type="hidden" name="wb_input_2" value="Message"><textarea class="form-field form-area-field" rows="3" cols="20" name="wb_input_2"></textarea></td></tr><tr class="form-footer"><td colspan="2"><button type="submit" class="btn">Submit</button></td></tr></table></form><script type="text/javascript">
			var formValues = <?php echo json_encode($_POST); ?>;
			var formErrors = <?php global $formErrors; echo json_encode($formErrors); ?>;
			wb_form_validateForm("4ca9926f", formValues, formErrors);
			<?php global $wb_form_send_state; if (isset($wb_form_send_state) && $wb_form_send_state) { ?>
				setTimeout(function() {
					alert("<?php echo addcslashes($wb_form_send_state, "\\'\"&\n\r\0\t<>"); ?>");
				}, 1);
			<?php } ?>	
			</script></div><div id="wb_element_instance24" class="wb_element"><script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false&amp;libraries=places"></script><script type="text/javascript">
				function initialize() {
					if (window.google) {
						var div = document.getElementById("wb_element_instance24");
						var ll = new google.maps.LatLng(40.689247,-74.044502);
						var map = new google.maps.Map(div, {
							zoom: 16,
							center: ll,
							mapTypeId: "roadmap"
						});
						
						var marker = new google.maps.Marker({
							position: ll,
							clickable: false,
							map: map
						});
					}
				}
				google.maps.event.addDomListener(window, "load", initialize);
			</script></div><div id="wb_element_instance25" class="wb_element" style=" line-height: normal;"><h5 class="wb-stl-subtitle">+00 000 00000</h5>
<h5 class="wb-stl-subtitle">Empire State Building</h5>
<h5 class="wb-stl-subtitle">350 5th Ave</h5>
<h5 class="wb-stl-subtitle">New York</h5>
<h5 class="wb-stl-subtitle">NY 10118</h5>
<h5 class="wb-stl-subtitle">USA</h5></div><div id="wb_element_instance26" class="wb_element" style="width: 100%;">
			<?php
				global $show_comments;
				if (isset($show_comments) && $show_comments) {
					renderComments(3);
			?>
			<script type="text/javascript">
				$(function() {
					var block = $("#wb_element_instance26");
					var comments = block.children(".wb_comments").eq(0);
					var contentBlock = $("#wb_main");
					contentBlock.height(contentBlock.height() + comments.height());
				});
			</script>
			<?php
				} else {
			?>
			<script type="text/javascript">
				$(function() {
					$("#wb_element_instance26").hide();
				});
			</script>
			<?php
				}
			?>
			</div></div>
<div class="vbox wb_container" id="wb_footer" style="height: 164px;">
	
<div id="wb_element_instance19" class="wb_element" style=" line-height: normal;"><p class="wb-stl-footer">© 2015 <a href="http://southnegocios.com">southnegocios.com</a></p></div><div id="wb_element_instance27" class="wb_element" style="text-align: center; width: 100%;"><div class="wb_footer"></div><script type="text/javascript">
			$(function() {
				var footer = $(".wb_footer");
				var html = (footer.html() + "").replace(/^\s+|\s+$/g, "");
				if (!html) {
					footer.parent().remove();
					footer = $("#wb_footer");
					footer.height(130);
				}
			});
			</script></div></div><div class="wb_sbg"></div></div></body>
</html>