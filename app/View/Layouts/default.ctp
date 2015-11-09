<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div style="float: left;">
            <?php
            echo $this->Html->link($this->Html->image('logo.png',array('height'=>'100px')),'/',array('escape'=>false));
            ?>
        </div>
        <div style="float: right;" id="header">
		<?php
        if($this->Session->check('Auth.User.name')){
            echo 'Witaj '.$this->Session->read('Auth.User.name');
             echo ' '.$this->Html->link('Wyloguj się',array('controller'=>'users','action'=>'logout'));
             echo ' '.$this->Html->link('Moje konto ',array('controller'=>'users','action'=>'edit'));
             echo $this->Html->image('/'.$userData['User']['avatar'],array('height'=>'100px'));
         
        } else {
             echo ' '.$this->Html->link('Zaloguj się',array('controller'=>'users','action'=>'login'));
        }
       
        ?>
        </div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
		
			<p>
			
			</p>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
