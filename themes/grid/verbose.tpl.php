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
          <li><code>&lt;header id='top'&gt;</code> <code>&lt;ul&gt;</code></li>
          <li><code>&lt;li&gt;</code><a href="<?=create_url('index')?>">Home</a><code>&lt;/li&gt;</code></li>
<?=login_menu()?>
          <li><code>&lt;/ul&gt;</code> <code>&lt;/header&gt;</code></li>
        </ul>
      </nav>
    </header>

    <header>
      <h1><?=$title?></h1>
      <p><code>&lt;header&gt;</code> <code>&lt;h1&gt;</code> <?=$title?> <code>&lt;/h1&gt;</code> <code>&lt;p&gt;</code> <code>&lt;/p&gt;</code> <code>&lt;/header&gt;</code></p>
    </header>

    <header>
      <p><code>&lt;header&gt;</code></p>
      <aside class='small left'>
        <p><code>&lt;aside class='small left'&gt;</code></p>
        <p><code>&lt;/aside&gt;</code></p>
      </aside>
      <section class='small middle'>
        <p><code>&lt;section class='small middle'&gt;</code></p>
        <p><code>&lt;/section&gt;</code></p>
      </section>
      <section class='small right'>
        <p><code>&lt;section class='small right'&gt;</code></p>
        <p><code>&lt;/section&gt;</code></p>
      </section>
      <p><code>&lt;/header&gt;</code></p>
    </header>

    <article>
<?=get_messages_from_session()?>
<?=@$main?>
<?=render_views()?>

    </article>

    <nav>
      <p><code>&lt;nav&gt;</code> <br /> <code>&lt;ul&gt;</code></p>
      <ul>
<?php /* I know this code should not be in the theme, I'll move it later */ ?>
<?php foreach(array_keys($amvc->config['controllers']) AS $controller) { ?>
        <li><code>&lt;li&gt;</code><a href="<?=create_url($controller)?>"><?=ucfirst($controller)?></a><code>&lt;/li&gt;</code></li>
<?php } ?>
      </ul>
      <p><code>&lt;/ul&gt;</code> <br /> <code>&lt;/nav&gt;</code></p>
    </nav>

    <section>
      <p><code>&lt;section&gt;</code></p>
      <p><code>&lt;p&gt;</code>The sidebar contains elements nested inside of a <code>&lt;section&gt;</code> element.<code>&lt;/p&gt;</code></p>

      <section>
        <p><code>&lt;section&gt;</code></p>
        <p><code>&lt;p&gt;</code>If they're not nested inside the section, they will fall out of the sidebar if it's taller than the <code>&lt;article&gt;</code> element.<code>&lt;/p&gt;</code></p>
        <p><code>&lt;/section&gt;</code></p>
      </section>

      <aside>
        <p><code>&lt;aside&gt;</code></p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque congue accumsan metus eget pharetra. Curabitur eu rhoncus est. Nam eleifend metus in elit posuere dapibus.</p>
        <p><code>&lt;/aside&gt;</code></p>
      </aside>

      <aside>
        <p><code>&lt;aside&gt;</code></p>
        <p>Notice how this is still in the sidebar.</p>
        <p><code>&lt;/aside&gt;</code></p>
      </aside>
      <p><code>&lt;/section&gt;</code></p>
    </section>

    <footer>
      <p><code>&lt;footer&gt;</code></p>
      <section class='small left'>
        <p><code>&lt;section class='small left'&gt;</code></p>
        <p><code>&lt;/section&gt;</code></p>
      </section>
      <section class='small middle'>
        <p><code>&lt;section class='small middle'&gt;</code></p>
        <p><code>&lt;/section&gt;</code></p>
      </section>
      <aside class='small right'>
        <p><code>&lt;aside class='small right'&gt;</code></p>
        <p><code>&lt;/aside&gt;</code></p>
      </aside>
      <p><code>&lt;/footer&gt;</code></p>
    </footer>

    <footer>
      <p><code>&lt;footer&gt;</code></p>
      <?=$footer?>
      <?=get_debug()?>
      <p><code>&lt;/footer&gt;</code></p>
    </footer>

  </body>
</html>