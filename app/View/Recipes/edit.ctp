<div class="recipes form">
<?php echo $this->Form->create('Recipe', array('type'=>'file')); ?>
	<fieldset>
		<legend><?php echo __('Edytuj przepis'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array ('label'=>'Nazwa'));
        echo $this->Form->input('content', array ('label'=>'Przepis'));
		echo $this->Form->input('category_id', array ('label'=>'Kategoria','empty'=>'---'));
		echo $this->Form->input('time', array ('label'=>'Czas przygotowania (min)','min'=>'0'));
		echo $this->Form->input('level_id', array ('label'=>'Poziom trudności'));
         echo $this->Form->input('picture', array ('label'=>'Dodaj obrazek','type'=>'file'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Zapisz')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Opcje'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Usuń przepis'), array('action' => 'delete', $this->Form->value('Recipe.id')), array(), __('Czy jesteś pewny/a, że chcesz usunąć przepis # %s?', $this->Form->value('Recipe.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Lista przepisów'), array('action' => 'index')); ?></li>
    </ul>
</div>
