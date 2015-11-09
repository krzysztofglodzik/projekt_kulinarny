<div>
<div style="width: 25%;float: left;">
<h3>Kategorie</h3>
<ul>
<?php 
foreach ($categories as $category) {
  echo '<li>'.
  $this->Html->link($category['Category']['name'],array('controller'=>'recipes','action'=>'all',$category['Category']['id'])).'</li>';  // zmienna przekazana z widoku i iterujemy po kazdej kategorii i wypisujemy
  
	
}
?></ul>
</div>
<div style="width: 50%;float: left;">
<h3>Lista przepisów</h3>
<ul>
<?php 
foreach ($recipes as $recipe) {
  echo '<li>'.$this->Html->link($recipe['Recipe']['name'],array('controller'=>'recipes','action'=>'view',$recipe['Recipe']['id'])).'</li>';  // zmienna przekazana z widoku i iterujemy po kazdym przepisie i wypisujemy
  
	
}
?></ul>

</div>
<div style="width: 25%;float: left;">
<?php

   echo $this->Html->link('Zarejestruj się',array('controller'=>'users','action'=>'registration'));
    
    echo $this->Form->create('Recipe', array('type' => 'get'));
    	echo $this->Form->input('name',array('value'=>$name,'label'=>'Szukaj po nazwie','required'=>false));//formularz wyszukiwarki 
        echo $this->Form->end(__('Wyszukaj'));
        
    
?>
</div>

</div>


