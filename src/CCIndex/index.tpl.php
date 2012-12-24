<h1>Index Controller</h1>
<p>Welcome to Another MVC index controller.</p>

<h2>Download</h2>
<p>You can download Another MVC from github.</p>
<blockquote>
  <pre>git clone git://github.com/pejg12/another-mvc.git</pre>
</blockquote>
<p>You can review its source directly on github: <a href='https://github.com/pejg12/another-mvc'>https://github.com/pejg12/another-mvc</a></p>

<h2>Installation</h2>
<p>First you have to make the data directory writable. This is the place where Another MVC needs to be able to write and create files.</p>
<blockquote>
  <pre>chmod 777 another-mvc/site/data</pre>
</blockquote>

<p>If your server has specific needs for <code>.htaccess</code> instructions, remember to take care of that before trying to use the site.</p>

<p>Second, Another MVC has some modules that need to be initialized. You can do this through a controller. Point your browser to the following link.</p>
<blockquote>
  <a href='<?=create_url('modules', 'install')?>'>modules/install</a>
</blockquote>

<h2>Configuration</h2>
<p>After installing Another MVC, you will of course need to configure it to suit your needs. The configuration file can be found in <code>site/config.php</code> and contains further instructions and information about all the settings.</p>

<h2>Customization</h2>
<p>To make your new site look like yours, you will need to configure the theme. Simple changes are made in <code>site/config.php</code> and more advanced theming (HTML and CSS) are made in <code>themes/</code> or <code>site/themes/</code>. For more advanced theming it is recommended that you create a new directory in <code>site/themes/</code> and specify a <code>parent</code> in <code>site/config.php</code> instead of modifying the original theme.</p>

<h3>Logo</h3>
<p>To change the site logo, open up <code>site/config.php</code> in your text editor and change the bolded text of this code.</p>

<h3>Title</h3>
<p>To change the site title, open up <code>site/config.php</code> in your text editor and change the bolded text of this code.</p>
<pre>$amvc->config['theme'] = array(
  /* ... */
  'data' => array(
    'site_title' => '<strong>Another MVC</strong>',
    /* ... */
  ),
);</pre>

<h3>Footer</h3>
<p>To change the site footer, open up <code>site/config.php</code> in your text editor and change the bolded text of this code.</p>
<pre>$amvc->config['theme'] = array(
  /* ... */
  'data' => array(
    /* ... */
    'footer' => '<strong>&lt;p&gt;Another MVC &amp;copy; pejg12 (pejg12@student.bth.se) &lt;br /&gt; Fork of Lydia &amp;copy; Mikael Roos (mos@dbwebb.se)&lt;/p&gt;</strong>',
  ),
);</pre>

<h3>Navigation</h3>
<p>To change the site navigation menu, open up <code>site/config.php</code> in your text editor and change the bolded text of this code.</p>
<pre>$amvc->config['menus'] = array(
  '<strong>my-navbar</strong>' => array(
    '<strong>name</strong>' => array('label'=>'<strong>Example</strong>', 'url'=>'<strong>controller/method</strong>'),
  ),
);

$amvc->config['theme'] = array(
  /* ... */
  'menu_to_region' => array('<strong>my-navbar</strong>'=>'navbar'),
  /* ... */
);</pre>
<p>In the code above, the first <code>my-navbar</code> has to be identical to the second <code>my-navbar</code>, because this is where Another MVC is told which menu to display. There can be many menus defined, but only one of them is displayed at any given time. If you change the name of your menu, you will need to make sure to map the new name in the <code>menu_to_region</code> config.</p>
<p>The <code>name</code> can be anything as it is not used in the actual code and will not be seen by anyone except the developer. The <code>label</code> (defined to <code><strong>Example</strong></code> above) is what your website visitors will click on, and the <code>url</code> (defined to <code><strong>controller/method</strong></code> above) is what url the link will go to. The above example will output HTML similar to this: <br /> <code>&lt;a href='controller/method'&gt;Example&lt;/a&gt;</code></p>
<p>Inside of the <code>my-navbar</code> array you may add any number of menu items, each with a unique <code>name</code>.</p>
