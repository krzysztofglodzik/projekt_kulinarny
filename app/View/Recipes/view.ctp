<div class="recipes view">
<h2><?php echo __('Przepisy'); ?></h2>
	<dl>
		<dt><?php echo __('#'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nazwa'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Kategoria'); ?></dt>
		<dd>
	         <?php  echo $recipe['Category']['name'];?>
			&nbsp;
		</dd>
		<dt><?php echo __('Czas przygotowania (min)'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Poziom trud.'); ?></dt>
		<dd>
			<?php echo h($recipe['Level']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Użytkownik'); ?></dt>
		<dd>
			<?php  echo $recipe['User']['name'];//$this->Html->link($recipe['User']['name'], array('controller' => 'users', 'action' => 'view', $recipe['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Utworzono'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['created']); ?>
			&nbsp;
		
        </dd>
        <dt>&nbsp;
        <?php echo $this->Html->image('/'.$recipe['Recipe']['picture'],array('height'=>'500px')); ?>
			&nbsp;</dt>
		<dd>
			
		
        </dd>
        	<dt><?php echo __('Przepis'); ?></dt>
        	<dd>
            <?=str_replace(PHP_EOL,"</br>",$recipe['Recipe']['content'])?><!-- zamienia znaki nowej lini na znaki br- czyli nowej lini w html -->
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Opcje'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Lista przepisów'), array('action' => 'index')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Komentarze'); ?></h3>
	<?php if (!empty($recipe['Comment'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Komentarz'); ?></th>
        	<th><?php echo __('Poziom'); ?></th>
		<th><?php echo __('Czas przygotowania (min)'); ?></th>
        <th></th>
	</tr>
	<?php foreach ($recipe['Comment'] as $comment): ?>
		<tr>
			<td><?php echo $comment['comment']; ?></td>
			<td>  <?php echo $levels[$comment['level_id']]; ?></td>
			<td><?php echo $comment['time']; ?></td>
            <td><?php
            if (isset ($userData['User']['id']) &&  $userData['User']['id'] == $comment['user_id'])
             echo $this->Html->link(__('Usuń komentarz'), array('action' => 'deleteComment', $comment['id'])); ?>  </td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

<?php
if($this->Session->check('Auth.User.name')){// sprawdza czy użytkownik jest zalogowany i pozwala lub nie dodawac komentarze
echo $this->Form->create('Comment');
echo $this->Form->input('comment', array ('label'=>'Komentarz'));
echo $this->Form->input('level_id', array ('label'=>'Poziom trudności','empty'=>'---'));
echo $this->Form->hidden('recipe_id',array('value'=>$recipe['Recipe']['id']));

echo $this->Form->input('time', array ('label'=>'Czas przygotowania (min)','min'=>'0'));
echo $this->Form->end('Dodaj');
}
?>

	
</div>
