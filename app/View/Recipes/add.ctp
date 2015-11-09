<div class="recipes form">
<?php echo $this->Form->create('Recipe', array('type'=>'file')); ?>
	<fieldset>
		<legend><?php echo __('Dodaj przepis'); ?></legend>
	<?php
		echo $this->Form->input('name', array ('label'=>'Nazwa'));
        echo $this->Form->input('content', array ('label'=>'Przepis'));
		echo $this->Form->input('category_id', array ('label'=>'Kategoria','empty'=>'---'));
		echo $this->Form->input('time', array ('label'=>'Czas przygotowania (min)','min'=>'0'));
		echo $this->Form->input('level_id', array ('label'=>'Poziom trudności'));
        echo $this->Form->input('picture', array ('label'=>'Dodaj obrazek','type'=>'file'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Dodaj')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Opcje'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Lista przepisów'), array('action' => 'index')); ?></li>
	</ul>
</div>
