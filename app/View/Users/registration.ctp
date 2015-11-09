<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Dodaj użytkownika'); ?></legend>
        <?php
         echo $this->Form->input('name', array('label'=>'Imię i nazwisko') );
        echo $this->Form->input('email', array('label'=>'Podaj email'));
         echo $this->Form->input('password', array('label'=>'Podaj hasło'));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Zapisz')); ?>
</div>