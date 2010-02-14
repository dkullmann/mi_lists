<div class = "container halfWidthLeft">
	<?php echo $this->element('mi_lists/select'); ?>
</div>
<div class="halfWidthRight">
	<div class="container droppable">
		<h3>Seccion Principa [2]</h3>
		<?php
		echo $this->element('mi_lists/pick_list', array('data' => $sections[1], 'section' => 1));
		?>
	</div>
	<div class="container droppable">
		<h3>Seccion Segundario [6]</h3>
		<?php
		echo $this->element('mi_lists/pick_list', array('data' => $sections[2], 'section' => 2));
		?>
	</div>
	<div class="container droppable">
		<h3>Seccion Pie [8]</h3>
		<?php
		echo $this->element('mi_lists/pick_list', array('data' => $sections[3], 'section' => 3));
		?>
	</div>
</div>
<?php
echo $form->create();
echo $form->submit('Grabar', array('name' => 'submit'));
echo $form->end();