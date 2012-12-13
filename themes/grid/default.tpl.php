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
    <link rel="stylesheet" href="<?=$stylesheet?>">
    <script src="<?=$themeUrl?>/js/vendor/modernizr-2.6.2.min.js"></script>
  </head>
  <body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

    <!-- Add your site or application content here -->

    <header id='top'>
      <nav>
        <ul>
<li><a href="<?=create_url('index')?>">Home</a></li>
<?=login_menu()?>
        </ul>
      </nav>
    </header>

    <header>
      <h1><?=$title?></h1>
    </header>

    <nav>
      <ul>
<?php /* I know this code should not be in the theme, I'll move it later */ ?>
<?php foreach(array_keys($amvc->config['controllers']) AS $controller) { ?>
        <li><a href="<?=create_url($controller)?>"><?=ucfirst($controller)?></a></li>
<?php } ?>
      </ul>
    </nav>

    <article>
<?=get_messages_from_session()?>
<?=@$main?>
<?=render_views()?>

    </article>

    <footer>
      <?=$footer?>
      <?=get_debug()?>
    </footer>

  </body>
</html>