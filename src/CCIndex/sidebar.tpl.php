<section>
<h1>Controllers and methods</h1>
<p>The following controllers exists. You enable and disable controllers in <code>site/config.php</code>.</p>

<ul>
<?php foreach($controllers as $key => $val): ?>
  <li>
    <a href='<?=create_url($key)?>'><?=$key?></a>
<?php   if(!empty($val)): ?>
    <ul>
<?php       foreach($val as $method): ?>
      <li><a href='<?=create_url($key, $method)?>'><?=$method?></a></li>
<?php       endforeach; ?>
    </ul>
<?php   endif; ?>
  </li>
<?php endforeach; ?>
</ul>
</section>
