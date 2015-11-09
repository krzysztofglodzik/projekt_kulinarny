<div class="recipes index">
	<h2><?php echo __('Przepisy'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id','#'); ?></th>
			<th><?php echo $this->Paginator->sort('name','Nazwa'); ?></th>
			<th><?php echo $this->Paginator->sort('category_id','Kategoria'); ?></th>
			<th><?php echo $this->Paginator->sort('time','Czas przygotowania (min)'); ?></th>
			<th><?php echo $this->Paginator->sort('level_id','Poziom trudności'); ?></th>
			<th><?php echo $this->Paginator->sort('created','Utworzono'); ?></th>
			<th class="actions"><?php echo __('Opcje'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($recipes as $recipe): ?>
	<tr>
		<td><?php echo h($recipe['Recipe']['id']); ?>&nbsp;</td>
		<td><?php echo h($recipe['Recipe']['name']); ?>&nbsp;</td>
		<td>
			<?php echo $recipe['Category']['name'] ?>
		</td>
		<td><?php echo h($recipe['Recipe']['time']); ?>&nbsp;</td>
		<td><?php echo $levels[$recipe['Recipe']['level_id']]; ?>&nbsp;</td>
		<td><?php echo h($recipe['Recipe']['created']); ?>&nbsp;</td>
			<td class="actions">
			<?php echo $this->Html->link(__('Zobacz'), array('action' => 'view', $recipe['Recipe']['id'])); ?>
			<?php echo $this->Html->link(__('Edytuj'), array('action' => 'edit', $recipe['Recipe']['id'])); ?>
			<?php echo $this->Form->postLink(__('Usuń'), array('action' => 'delete', $recipe['Recipe']['id']), array('confirm' => __('Czy jesteś pewny/a, że chcesz usunąć przepis  # %s?', $recipe['Recipe']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Strona {:page} z {:pages}, pokazuje {:current} wpisy z {:count} , starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('poprzednia'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('następna') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Opcje'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Nowy przepis'), array('action' => 'add')); ?></li>

	</ul>
</div>
