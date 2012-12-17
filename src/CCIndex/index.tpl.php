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

<p>Second, Another MVC has some modules that need to be initialized. You can do this through a controller. Point your browser to the following link.</p>
<blockquote>
  <a href='<?=create_url('modules', 'install')?>'>modules/install</a>
</blockquote>
