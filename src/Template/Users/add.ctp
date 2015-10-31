<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Bookmarks'), ['controller' => 'Bookmarks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bookmark'), ['controller' => 'Bookmarks', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user,['novalidate']) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->input('email');
						echo $this->Form->input('name');
            echo $this->Form->input('password');
            echo $this->Captcha->create('securitycode', ['type'=>'image' //or 'math'
						, 'theme'=>'random']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<script 
src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
jQuery('.creload').on('click', function() {
    var mySrc = $(this).prev().attr('src');
    var glue = '?';
    if(mySrc.indexOf('?')!=-1)  {
        glue = '&';
    }
    $(this).prev().attr('src', mySrc + glue + new Date().getTime());
    return false;
});
</script>
