<?php foreach(array_keys(CAmvc::Instance()->config['controllers']) AS $controller): ?>
<li>
  <code>&lt;li&gt;</code>
  <a href="<?=create_url($controller)?>"><?=ucfirst($controller)?></a>
  <code>&lt;/li&gt;</code>
</li>
<?php endforeach; ?>
