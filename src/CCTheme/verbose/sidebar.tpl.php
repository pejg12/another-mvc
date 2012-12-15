<?php $amvc = CAmvc::Instance(); ?>
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