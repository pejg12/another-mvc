<p>A controller to manage the actions for content; mainly list, create, edit, delete, view.</p>

<h2>All content</h2>
<?php if($contents != null):?>
  <ul>
  <?php foreach($contents as $val):?>
    <li>
      <?=$val['id']?>, <?=$val['title']?> by <?=$val['owner']?>
      ( <a href='<?=create_url('content', 'edit', $val['id'])?>'>edit</a>
      | <a href='<?=create_url("page/view/{$val['id']}")?>'>view</a>
      )
    </li>
<?php endforeach; ?>
  </ul>
<?php else:?>
  <p>No content exists.</p>
<?php endif;?>

<h2>Actions</h2>
<ul>
  <li><a href='<?=create_url('content', 'init')?>'>Init database, create tables and sample content</a>
  <li><a href='<?=create_url('content', 'create')?>'>Create new content</a>
  <li><a href='<?=create_url('blog')?>'>View as blog</a>
</ul>
