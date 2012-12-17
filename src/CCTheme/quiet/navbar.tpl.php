<?php foreach(array_keys(CAmvc::Instance()->config['controllers']) AS $controller): ?>
<li><a href="<?=create_url($controller)?>"><?=ucfirst($controller)?></a></li>
<?php endforeach; ?>
