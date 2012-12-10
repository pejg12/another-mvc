<p>This is what you can do for now.</p>

<ul>
<?php foreach($menu as $val): ?>
<li><a href='<?=create_url($val)?>'><?=$val?></a></li>
<?php endforeach; ?>
</ul>
