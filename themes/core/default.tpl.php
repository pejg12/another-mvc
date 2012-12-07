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

		<link rel="stylesheet" href="<?=$themeUrl?>/css/normalize.css">
		<link rel="stylesheet" href="<?=$themeUrl?>/css/main.css">
		<link rel="stylesheet" href="<?=$themeUrl?>/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?=$stylesheet?>">
		<script src="<?=$themeUrl?>/js/vendor/modernizr-2.6.2.min.js"></script>
	</head>
	<body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->

        <div class="container" id='maincontent'>
            <div class="row">
                <div class="span12">
                    <div class='page-header'>
                        <h1><?=$title?></h1>
                        <p><?=$header?></p>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="span12">
                  <?=@$main?>
                  <?=render_views()?>
                </div> <!-- span -->

            </div> <!-- row -->
        </div> <!-- container -->

        <footer>
            <div class="navbar navbar-static-bottom">
                <div class="navbar-inner">
                    <div class="container">
                        <?=$footer?>
                        <?=get_debug()?>
                    </div> <!-- container -->
                </div> <!-- navbar-inner -->
            </div> <!-- navbar -->
        </footer>

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