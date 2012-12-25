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

    <link rel='shortcut icon' href='<?=theme_url($favicon)?>'/>
    <link rel="stylesheet" href="<?=theme_parent_url('css/normalize.css')?>">
    <link rel="stylesheet" href="<?=theme_parent_url('css/main.css')?>">
    <link rel="stylesheet" href="<?=theme_url($stylesheet)?>">
    <script src="<?=theme_parent_url('js/vendor/modernizr-2.6.2.min.js')?>"></script>

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
      <a href='<?=base_url()?>'><img src='<?=theme_url($logo)?>' alt='Logo' width='<?=$logo_width?>' height='<?=$logo_height?>' /></a>
      <h1><?=$site_title?></h1>
      <p><?=$slogan?></p>
    </header>

<?php if(region_has_content('flash')): ?>
    <header>
<?=render_views('flash')?>
    </header>
<?php endif; ?>

<?php if(region_has_content('featured-left', 'featured-middle', 'featured-right')): ?>
    <header>
      <aside class='small left'>
<?php if(region_has_content('featured-left')): ?>
<?=render_views('featured-left')?>
<?php else: ?>
&nbsp;
<?php endif; ?>
      </aside>
      <section class='small middle'>
<?php if(region_has_content('featured-middle')): ?>
<?=render_views('featured-middle')?>
<?php else: ?>
&nbsp;
<?php endif; ?>
      </section>
      <section class='small right'>
<?php if(region_has_content('featured-right')): ?>
<?=render_views('featured-right')?>
<?php else: ?>
&nbsp;
<?php endif; ?>
      </section>
    </header>
<?php endif; ?>

    <article>
<?=get_messages_from_session()?>
<?=@$main?>
<?=render_views('primary')?>
<?=render_views()?>

    </article>

    <section>
<?php if(region_has_content('navbar')): ?>
      <nav>
        <h1>Navigation</h1>
        <ul>
<?=render_views('navbar')?>
        </ul>
      </nav>
<?php endif; ?>

<?php if(region_has_content('sidebar')): ?>
<?=render_views('sidebar')?>
<?php endif; ?>

    </section>

<?php if(region_has_content('triptych-left', 'triptych-middle', 'triptych-right')): ?>
    <footer>
      <section class='small left'>
<?php if(region_has_content('triptych-left')): ?>
<?=render_views('triptych-left')?>
<?php else: ?>
&nbsp;
<?php endif; ?>
      </section>
      <section class='small middle'>
<?php if(region_has_content('triptych-middle')): ?>
<?=render_views('triptych-middle')?>
<?php else: ?>
&nbsp;
<?php endif; ?>
      </section>
      <aside class='small right'>
<?php if(region_has_content('triptych-right')): ?>
<?=render_views('triptych-right')?>
<?php else: ?>
&nbsp;
<?php endif; ?>
      </aside>
    </footer>
<?php endif; ?>

    <footer>
<?=render_views('footer')?>
<?=$footer?>
<?=get_tools()?>
<?=get_debug()?>
    </footer>

  </body>
</html>
