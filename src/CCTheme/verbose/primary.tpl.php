<p><code>&lt;article&gt;</code></p>
<p><code>&lt;h2&gt;</code>Article header<code>&lt;/h2&gt;</code></p>

<aside class='small right'>
  <h1>Theme helper</h1>
  <p>
    Current theme is: <strong><?=$theme_name?></strong>
    <br />See the <a href='<?=create_url('theme', 'quiet')?>'>quiet</a> example.
  </p>
  <p>
    <code>&lt;aside class="small right"&gt;</code>
    <br /><code>&lt;/aside&gt;</code>
  </p>
</aside>

<p><code>&lt;p&gt;</code> This theme was created with the semantic discipline in mind. Each element is created with basic HTML5 elements, no classes or id necessary. The main navigation bar on the left is created with a simple <code>&lt;nav&gt;</code> (navigation) element, with its links in an <code>&lt;ul&gt;</code> (unordered list). The main content here is simply an <code>&lt;article&gt;</code> and if you want you can add peripheral information in <code>&lt;aside&gt;</code> elements. If you absolutely must provide content in a specific visual manner, the navigation menu in the top right corner can be created with a specific id <code>&lt;nav id='top'&gt;</code> and the asides can be made smaller with <code>class='small'</code> and even positioned in a three-column grid by specifying the classes <code>class='small left'</code>, <code>class='small right'</code> and <code>class='small middle'</code>. The middle one will only work if all three positions are used.</p>

<aside>
  <p><code>&lt;aside&gt;</code></p>
  <p><code>&lt;/aside&gt;</code></p>
</aside>

<p>Notice that the <code>&lt;section&gt;</code> and <code>&lt;aside&gt;</code> elements can be used for the same visual appearance, they are treated identically in the CSS and should be used where they are semantically sound; aside elements for related but peripheral content, section elements for unrelated content.</p>

<p>If your page requires multiple <code>&lt;article&gt;</code> elements, they can be nested inside the main article. <code>&lt;/p&gt;</code></p>

<aside class='small'>
  <p><code>&lt;aside class="small"&gt;</code></p>
  <p><code>&lt;/aside&gt;</code></p>
</aside>

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque congue accumsan metus eget pharetra. Curabitur eu rhoncus est. Nam eleifend metus in elit posuere dapibus. Mauris non ante vulputate nisl condimentum molestie. Nam gravida vestibulum mauris. Donec feugiat sagittis nulla non vehicula. Nulla et justo nec lectus pharetra scelerisque. Aliquam tristique blandit adipiscing. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque congue accumsan metus eget pharetra. Curabitur eu rhoncus est. Nam eleifend metus in elit posuere dapibus.</p>

<aside class='small left'>
  <p><code>&lt;aside class='small left'&gt;</code></p>
  <p><code>&lt;/aside&gt;</code></p>
</aside>

<aside class='small middle'>
  <p><code>&lt;aside class='small middle'&gt;</code></p>
  <p><code>&lt;/aside&gt;</code></p>
</aside>

<aside class='small right'>
  <p><code>&lt;aside class='small right'&gt;</code></p>
  <p><code>&lt;/aside&gt;</code></p>
</aside>

<p>Donec risus metus, congue dapibus pellentesque ac, porttitor vitae magna. Pellentesque eget pellentesque libero. Sed non sapien mi. In laoreet mi quis nisi ultricies placerat. Aliquam id magna a odio egestas convallis.</p>

<p><code>&lt;/article&gt;</code></p>
