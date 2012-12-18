<section>
<h4>All modules</h4>
<p>All Another MVC modules.</p>
<ul>
<?php foreach($modules as $module): ?>
  <li><a href='<?=create_url('', 'view', $module['name']);?>'><?=$module['name']?></a></li>
<?php endforeach; ?>
</ul>
</section>


<section>
<h4>Another MVC core</h4>
<p>Another MVC core modules.</p>
<ul>
<?php foreach($modules as $module): ?>
  <?php if($module['isAmvcCore']): ?>
  <li><a href='<?=create_url('', 'view', $module['name']);?>'><?=$module['name']?></a></li>
  <?php endif; ?>
<?php endforeach; ?>
</ul>
</section>


<section>
<h4>Another MVC CMF</h4>
<p>Another MVC Content Management Framework (CMF) modules.</p>
<ul>
<?php foreach($modules as $module): ?>
  <?php if($module['isAmvcCMF']): ?>
  <li><a href='<?=create_url('', 'view', $module['name']);?>'><?=$module['name']?></a></li>
  <?php endif; ?>
<?php endforeach; ?>
</ul>
</section>


<section>
<h4>Models</h4>
<p>A class is considered a model if its name starts with CM.</p>
<ul>
<?php foreach($modules as $module): ?>
  <?php if($module['isModel']): ?>
  <li><a href='<?=create_url('', 'view', $module['name']);?>'><?=$module['name']?></a></li>
  <?php endif; ?>
<?php endforeach; ?>
</ul>
</section>


<section>
<h4>Controllers</h4>
<p>Implements interface <code>IController</code>.</p>
<ul>
<?php foreach($modules as $module): ?>
  <?php if($module['isController']): ?>
  <li><a href='<?=create_url('', 'view', $module['name']);?>'><?=$module['name']?></a></li>
  <?php endif; ?>
<?php endforeach; ?>
</ul>
</section>


<section>
<h4>Contains SQL</h4>
<p>Implements interface <code>IHasSQL</code>.</p>
<ul>
<?php foreach($modules as $module): ?>
  <?php if($module['hasSQL']): ?>
  <li><a href='<?=create_url('', 'view', $module['name']);?>'><?=$module['name']?></a></li>
  <?php endif; ?>
<?php endforeach; ?>
</ul>
</section>


<section>
<h4>More modules</h4>
<p>Modules that does not implement any specific Another MVC interface.</p>
<ul>
<?php foreach($modules as $module): ?>
  <?php if(!($module['isController'] || $module['isAmvcCore'] || $module['isAmvcCMF'])): ?>
  <li><a href='<?=create_url('', 'view', $module['name']);?>'><?=$module['name']?></a></li>
  <?php endif; ?>
<?php endforeach; ?>
</ul>
</section>
