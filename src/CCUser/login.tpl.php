<p>Enter your acronym or email to log in.</p>
<?=$login_form->GetHTML('form')?>
  <fieldset>
    <?=$login_form['acronym']->GetHTML()?>
    <?=$login_form['password']->GetHTML()?> 
    <?=$login_form['login']->GetHTML()?>
    <?php if($allow_create_user) : ?>
      <div class='controls btn form-action-link'>
        <a href='<?=$create_user_url?>' title='Create a new user account'>Create new user</a>
      </div>
    <?php endif; ?>
  </fieldset>
</form>