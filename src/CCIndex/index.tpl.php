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

<p>Secondly, Another MVC used mod_rewrite. If you see this page (the Index Controller) from your own installation, but no other links are working, that means your server has specific needs for <code>.htaccess</code> instructions. Contact your server admin for help on how to make your <code>.htaccess</code> file work with mod_rewrite.</p>

<p>Finally, Another MVC has some modules that need to be initialized. You can do this through a controller. Point your browser to the following link.</p>
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
<blockquote>
  <pre>$amvc->config['theme'] = array(
  /* ... */
  'data' => array(
    'site_title' => '<strong>Another MVC</strong>',
    /* ... */
  ),
);</pre>
</blockquote>

<h3>Footer</h3>
<p>To change the site footer, open up <code>site/config.php</code> in your text editor and change the bolded text of this code.</p>
<blockquote>
  <pre>$amvc->config['theme'] = array(
  /* ... */
  'data' => array(
    /* ... */
    'footer' => '<strong>&lt;p&gt;Another MVC &amp;copy; pejg12 (pejg12@student.bth.se) &lt;br /&gt; Fork of Lydia &amp;copy; Mikael Roos (mos@dbwebb.se)&lt;/p&gt;</strong>',
  ),
);</pre>
</blockquote>

<h3>Navigation</h3>
<p>To change the site navigation menu, open up <code>site/config.php</code> in your text editor and change the bolded text of this code.</p>
<blockquote>
  <pre>$amvc->config['theme'] = array(
  /* ... */
  'menu_to_region' => array('<strong>my-navbar</strong>'=>'navbar'),
  /* ... */
);

$amvc->config['menus'] = array(
  '<strong>my-navbar</strong>' => array(
    '<strong>name</strong>' => array('label'=>'<strong>Example</strong>', 'url'=>'<strong>controller/method</strong>'),
  ),
);</pre>
</blockquote>
<p>In the code above, the first <code>my-navbar</code> has to be identical to the second <code>my-navbar</code>, because this is where Another MVC is told which menu to display. There can be many menus defined, but only one of them is displayed at any given time. If you change the name of your menu, you will need to make sure to map the new name in the <code>menu_to_region</code> config.</p>
<p>Inside of the <code>my-navbar</code> array you may add any number of menu items, each with a unique <code>name</code>. The <code>name</code> can be anything as it is not used in the actual code and will not be seen by anyone except the developer. The <code>label</code> (defined to <code><strong>Example</strong></code> above) is what your website visitors will click on, and the <code>url</code> (defined to <code><strong>controller/method</strong></code> above) is what url the link will go to. The above example will output HTML similar to this: <br /> <code>&lt;a href='http://example.com/controller/method'&gt;Example&lt;/a&gt;</code></p>

<h2>New content</h2>
<p>Another MVC has built-in support for blog entries and simple page creation using the website GUI. If you have not done so already, make sure to install these modules by visiting <a href='<?=create_url('modules', 'install')?>'>modules/install</a>. This will create a few sample blog entries and pages which can be deleted or modified by you.</p>
<p>Once the modules have been installed, visit <a href='<?=create_url('content')?>'>content</a> to view and modify the sample content. You will see a list of all content, blog posts and pages mixed together, with links to edit or view each entry. Below this list there will be an option to initiate the database (this will delete all current content and replace it with the built-in sample content) as well as an option to create new content. It is recommended that you view the sample content first, then delete it, then create your own new content.</p>
<p>Before you create any content, make sure you are <a href='<?=create_url('user', 'profile')?>'>logged in</a> as the correct user. It is possible to <a href='<?=create_url('user', 'create')?>'>create</a> a brand new user for yourself unless this option has been turned off in <code>site/config.php</code>, but if you initiate the database all the new users will be deleted.</p>

<h3>New blog</h3>
<p>Another MVC only supports one blog per site, so if you want your own unique blog you will first have to delete the sample blog entries. Visit <a href='<?=create_url('blog')?>'>blog</a>, click the edit link below each entry, then click the Delete button at the bottom of the form.</p>
<p>To create a new blog post, visit <a href='<?=create_url('content')?>'>content</a>, then click <a href='<?=create_url('content', 'create')?>'>Create new content</a>.</p>
<ul>
<li>The <strong>Title</strong> should be a human-readable title of the post, such as <code>We're 5 Years Ahead!</code>.</li>
<li>The <strong>Slug</strong> is often a version of the human-readable title which consists of nothing but lowercase letters, digits and dashes, such as <code>were-5-years-ahead</code>.</li>
<li>The <strong>Content</strong> is your entire blog post.</li>
<li>The <strong>Type</strong> must be <code>post</code> for all blog entries.</li>
<li>The <strong>Filter</strong> defines how you want your blog post to be filtered. The options are <code>plain</code>, <code>htmlpurify</code>, <code>bbcode</code> and <code>mediawiki</code>. If your post only contains pure text, the <code>plain</code> filter should be suitable, as it makes sure all special characters are shown as-is with no interpretation. However, if you want to bold your text, or use headers that are actually headers, you can use one of three markup languages (<a href='http://en.wikipedia.org/wiki/HTML'>HTML</a>, <a href='http://en.wikipedia.org/wiki/BBCode'>BBCode</a> or a limited interpretation of the <a href='http://en.wikipedia.org/wiki/Help:Wiki_markup'>MediaWiki markup</a>) to do this. The <code>htmlpurify</code> filter should accept all HTML except what might be considered harmful to the site, while the <code>bbcode</code> and <code>mediawiki</code> filters are very limited to text formatting only. You might be familiar with BBCode from various forums, and the MediaWiki markup is what is used to edit Wikipedia and Wikia articles. Examples of bold text:
  <ul>
    <li><code>This is a &lt;strong&gt;bold&lt;/strong&gt; word.</code> (HTML)</li>
    <li><code>This is a [b]bold[/b] word.</code> (BBCode)</li>
    <li><code>This is a '''bold''' word.</code> (MediaWiki markup)</li>
  </ul></li>
</ul>

<h3>New page</h3>
<p>Instead of deleting the sample pages, it is recommended that you edit their content to reflect your site. To edit old pages you must visit <a href='<?=create_url('content')?>'>content</a> and then click on the edit link next to the page you want to modify.</p>
<p>To create a new page, simply visit <a href='<?=create_url('content')?>'>content</a> and click <a href='<?=create_url('content', 'create')?>'>Create new content</a>, follow the instructions for blog posts (above) to fill out the form, but in the <strong>Type</strong> field you must enter <code>page</code> instead.</p>

<h2>Your own controller</h2>
<p>A custom title, maybe custom CSS and personal blog posts&mdash;these are all important details to customize your website for yourself, but they're not enough. You will also need to add your own controllers to make use of Another MVC as intended.</p>

<p>Create a new directory in <code>site/src/</code> and then create a file with the same name as the directory (plus the PHP file extension). For example, create the directory <code>site/src/CCMyController/</code> and then the file <code>site/src/CCMyController/CCMyController.php</code>. All controllers should implement the <code>IController</code> interface, which means they also need to define an <code>Index()</code> method, and to gain access to the core variables all controllers should also extend <code>CObject</code>. Add this code to your <code>CCMyController.php</code> file:</p>
<blockquote>
<pre>&lt;?php
class CCMyController extends CObject implements IController {
  public function Index() {
  }
}</pre>
</blockquote>
<p>To use your new controller (although it doesn't do anything yet) you will need to enable it in <code>site/config.php</code>.</p>
<blockquote>
<pre>$amvc->config['controllers'] = array(
  /* ... */
  '<strong>my</strong>' => array('enabled' => <strong>true</strong>,'class' => '<strong>CCMyController</strong>'),
);</pre>
</blockquote>
<p>The name of the controller (defined as <code>my</code> above) is what the user will see in the url. If they go to <code>http://example.com/my</code> then Another MVC will try to load the <code>Index()</code> method of the controller <code>CCMyController/CCMyController.php</code>. If you ever want to disable the controller, just change <code>true</code> to <code>false</code>.</p>
<p>Now, let's let your <code>Index()</code> method load the sample About page. Go back to your <code>CCMyController.php</code> file and modify it.</p>
<blockquote>
<pre>&lt;?php
class CCMyController extends CObject implements IController {
  public function Index() {<strong>
    $content = new CMContent(5);

    $this->views->SetTitle(htmlEnt($content['title']));

    $this->views->AddInclude(__DIR__ . '/about.tpl.php', array(
      'content' => $content,
    ));
  </strong>}
}</pre>
</blockquote>
<p>This will first load the content with id 5 (which is the id of the sample About page) into the variable <code>$content</code>. It then proceeds to set the page HTML title to a safely escaped version of the About page's title, using the <code>$this->views->SetTitle()</code> and <code>htmlEnt()</code> methods. Lastly it will include the file <code>about.tpl.php</code> (we'll get to that in a bit), making sure that this file has access to the <code>$content</code> variable.</p>
<p>Now, create the file <code>site/src/CCMyController/about.tpl.php</code> and write the HTML for displaying your content.</p>
<blockquote>
<pre>&lt;?php if($content['id']): ?&gt;
  &lt;h1&gt;&lt;?php echo $content['title']; ?&gt;&lt;/h1&gt;
  &lt;p&gt;&lt;?php echo $content-&gt;GetFilteredData(); ?&gt;&lt;/p&gt;
&lt;?php else: ?&gt;
  &lt;p&gt;404: No such page exists.&lt;/p&gt;
&lt;?php endif; ?&gt;</pre>
</blockquote>
<p>As you can see, this is an ordinary PHP file. It has access to the <code>$content</code> variable because we sent it in the second parameter to the <code>$this->views->AddInclude()</code> method in the controller. It uses the method <code>GetFilteredData()</code> to fetch the content of the page from the database, filtered using the filter you defined when you created the page (or whatever filter was defined for the sample).</p>
<p>Following the same steps, you should be able to create the method <code>Blog()</code>, displaying your blog posts in the file <code>blog.tpl.php</code>. For further help, study the <code>Index()</code> method in the built-in blog controller <code>src/CCBlog/CCBlog.php</code> and its HTML output <code>src/CCBlog/index.tpl.php</code>.</p>
<p>Note that you do not need to enable individual methods, only the controllers. Since <code>CCMyController</code> is already enabled in <code>site/config.php</code>, users will automatically be able to access the <code>Blog()</code> method by visiting <code>http://example.com/my/blog</code>.</p>
