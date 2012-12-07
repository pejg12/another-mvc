<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="sv-SE"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?=$title?></title>
		<!--meta name="description" content="<?php /*echo $meta_description;*/ ?>"-->
		<meta name="viewport" content="width=device-width">

		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

		<!--link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/bootstrap.min.css"-->
		<link rel="stylesheet" href="<?=$stylesheet?>">
		<!--script src="js/vendor/modernizr-2.6.2.hennes.js"></script-->
	</head>
	<body>
		<div id="header">
			<?=$header?>
		</div>
		<div id="main" role="main">
			<?=@$main?>
            <?=render_views()?>
		</div>
		<div id="footer">
			<?=$footer?>
            <?=get_debug()?>
		</div>
		<!-- Boilerplate footer  -->
	<!-- Disabled until I actually use JS
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.hennes.js"></script>
		<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.hennes.js"><\/script>')</script>
		<script src="js/plugins.js"></script>
		<script src="js/main.js"></script>
	-->

		<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
	<!-- Disabled since I don't have GA yet
		<script>
			var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
			(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
			g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
			s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
	-->
	</body>
</html>