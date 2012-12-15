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

<?php if(isset($inline_style)): ?>
    <style>
<?=$inline_style?>
    </style>
<?php endif; ?>

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
<?php if(region_has_content('flash')): ?>
<?=render_views('flash')?>
<?php endif; ?>
    </header>

<?php if(region_has_content('featured-left', 'featured-middle', 'featured-right')): ?>
    <header>
      <aside class='small left'>
<?=render_views('featured-left')?>&nbsp;
      </aside>
      <section class='small middle'>
<?=render_views('featured-middle')?>&nbsp;
      </section>
      <section class='small right'>
<?=render_views('featured-right')?>&nbsp;
      </section>
    </header>
<?php endif; ?>

    <article>
<?=get_messages_from_session()?>
<?=render_views('primary')?>

    </article>

<?php if(region_has_content('sidebar')): ?>
    <section>
<?=render_views('sidebar')?>
    </section>
<?php endif; ?>

<?php if(region_has_content('triptych-left', 'triptych-middle', 'triptych-right')): ?>
    <footer>
      <section class='small left'>
<?=render_views('triptych-left')?>&nbsp;
      </section>
      <section class='small middle'>
<?=render_views('triptych-middle')?>&nbsp;
      </section>
      <aside class='small right'>
<?=render_views('triptych-right')?>&nbsp;
      </aside>
    </footer>
<?php endif; ?>

    <footer>
<?=render_views('footer')?>
    </footer>

  </body>
</html>