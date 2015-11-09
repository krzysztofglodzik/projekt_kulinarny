<?php echo $this->Form->create('User',  array('type'=>'file')); ?>
    <fieldset>
        <legend>
            <?php echo __('Dodaj avatar'); ?>
        </legend>
        <?php echo $this->Form->input('avatar',array('type' => 'file') );
        
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Zapisz')); ?>