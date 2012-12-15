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
      <p>This is the page header paragraph.</p>
    </header>

    <header>
      <aside class='small left'>
        <h1>Aside (left)</h1>
        <p>Wrapped in a header.</p>
      </aside>
      <section class='small middle'>
        <h1>Section (middle)</h1>
        <p>Wrapped in a header.</p>
      </section>
      <section class='small right'>
        <h1>Section (right)</h1>
        <p>Wrapped in a header.</p>
      </section>
    </header>

    <article id='primary'>
<?=get_messages_from_session()?>
<?=@$main?>
<?=render_views('primary')?>

    </article>

    <nav>
      <h1>Navigation</h1>
      <ul>
<?php /* I know this code should not be in the theme, I'll move it later */ ?>
<?php foreach(array_keys($amvc->config['controllers']) AS $controller) { ?>
        <li><a href="<?=create_url($controller)?>"><?=ucfirst($controller)?></a></li>
<?php } ?>
      </ul>
    </nav>

    <section id='sidebar'>
<?=render_views('sidebar')?>
      <h1>Section</h1>
      <p>The sidebar contains elements nested inside of a <code>&lt;section&gt;</code> element.</p>

      <section>
        <h1>Section</h1>
        <p>If they're not nested inside the section, they will fall out of the sidebar if it's taller than the <code>&lt;article&gt;</code> element.</p>
      </section>

      <aside>
        <h1>Aside</h1>
        <p>Nam gravida vestibulum mauris. Donec feugiat sagittis nulla non vehicula. Nulla et justo nec lectus pharetra scelerisque. Aliquam tristique blandit adipiscing. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque congue accumsan metus eget pharetra. Curabitur eu rhoncus est. Nam eleifend metus in elit posuere dapibus. Mauris non ante vulputate nisl condimentum molestie.</p>
      </aside>

      <aside>
        <h1>Aside</h1>
        <p>Notice how this is still in the sidebar.</p>
      </aside>
    </section>

    <footer>
      <section class='small left'>
        <h1>Section (left)</h1>
        <p>Wrapped in a footer.</p>
      </section>
      <section class='small middle'>
        <h1>Section (middle)</h1>
        <p>Wrapped in a footer.</p>
      </section>
      <aside class='small right'>
        <h1>Aside (right)</h1>
        <p>Wrapped in a footer.</p>
      </aside>
    </footer>

    <footer>
      <?=$footer?>
      <?=get_debug()?>
    </footer>

  </body>
</html>