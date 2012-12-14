<h2>Header</h2>

<aside class='small right'>
  <h1>Theme helper</h1>
  <p>
    Current theme is: <strong><?=$theme_name?></strong>.
    <br />See the <a href='<?=create_url('theme', 'verbose')?>'>verbose</a> example.
  </p>
  <p>This is a small aside positioned on the right side.</p>
</aside>

<p>This theme was created with the semantic discipline in mind. Each element is created with basic HTML5 elements, no classes or id necessary. The main navigation bar on the left is created with a simple <code>&lt;nav&gt;</code> (navigation) element, with its links in an <code>&lt;ul&gt;</code> (unordered list). The main content here is simply an <code>&lt;article&gt;</code> and if you want you can add peripheral information in <code>&lt;aside&gt;</code> elements. If you absolutely must provide content in a specific visual manner, the navigation menu in the top right corner can be created with a specific id <code>&lt;nav id='top'&gt;</code> and the asides can be made smaller with <code>class='small'</code> and even positioned in a three-column grid by specifying the classes <code>class='small left'</code>, <code>class='small right'</code> and <code>class='small middle'</code>. The middle one will only work if all three positions are used.</p>

<aside>
  <h1>Aside</h1>
  <p>This is a basic aside, with no visual markup. I don't understand why there's no extra line below this paragraph, when there is extra space on the small asides and the main navigation nav.</p>
</aside>

<p>Nulla facilisi. Sed hendrerit, nibh eget rutrum tempus, eros massa convallis turpis, eu molestie dui dolor eget nunc. Etiam quam nisl, tempor euismod condimentum ut, placerat ac metus.</p>

<aside class='small'>
  <h1>Aside (small)</h1>
  <p>Small asides will automatically be on the left side unless a position is specified.</p>
</aside>

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque congue accumsan metus eget pharetra. Curabitur eu rhoncus est. Nam eleifend metus in elit posuere dapibus. Mauris non ante vulputate nisl condimentum molestie. Nam gravida vestibulum mauris. Donec feugiat sagittis nulla non vehicula. Nulla et justo nec lectus pharetra scelerisque. Aliquam tristique blandit adipiscing. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque congue accumsan metus eget pharetra. Curabitur eu rhoncus est. Nam eleifend metus in elit posuere dapibus. Mauris non ante vulputate nisl condimentum molestie.</p>

<aside class='small left'>
  <h1>Aside (left)</h1>
  <p>This aside is <strong>above</strong> the other two in the markup.</p>
</aside>

<aside class='small middle'>
  <h1>Aside (middle)</h1>
  <p>This aside is in the <strong>middle</strong> of the other two in the markup.</p>
</aside>

<aside class='small right'>
  <h1>Aside (right)</h1>
  <p>This aside is <strong>below</strong> the other two in the markup.</p>
</aside>

<p>Donec risus metus, congue dapibus pellentesque ac, porttitor vitae magna. Pellentesque eget pellentesque libero. Sed non sapien mi. In laoreet mi quis nisi ultricies placerat. Aliquam id magna a odio egestas convallis.</p>
