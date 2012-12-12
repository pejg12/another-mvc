<?php if($content['created']): ?>
  <p>You can edit and save this content.</p>
<?php else: ?>
  <p>Create new content.</p>
<?php endif; ?>

<?=$form->GetHTML(array('class'=>'content-edit'))?>

<p class='muted'>
<?php if($content['created']): ?>
  This content were created by <?=$content['owner']?> at <?=$content['created']?>.
<?php else: ?>
  Content not yet created.
<?php endif; ?>

<?php if(isset($content['updated'])):?>
  Last updated at <?=$content['updated']?>.
<?php endif; ?>
</p>

<p><a href='<?=create_url('content')?>'>View all content</a></p>
