<?php $amvc = CAmvc::Instance(); ?>
<nav>
  <h1>Navigation</h1>
  <ul>
<?php /* I know this code should not be in the theme, I'll move it later */ ?>
<?php foreach(array_keys($amvc->config['controllers']) AS $controller) { ?>
    <li><a href="<?=create_url($controller)?>"><?=ucfirst($controller)?></a></li>
<?php } ?>
  </ul>
</nav>

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