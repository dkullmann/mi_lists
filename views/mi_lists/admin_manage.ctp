<div class = "container halfWidthLeft">
	<?php echo $this->element('mi_lists/select'); ?>
</div>
<div class="halfWidthRight">
<?php foreach ($sections as $id => $section): ?>
	<div class="container droppable">
		<h3><?php echo $section['name'] . ' [' . $section['limit'] . ' ]' ?></h3>
		<?php
		echo $this->element('mi_lists/pick_list', array('data' => $section, 'section' => 1));
		?>
	</div>
<?php endforeach; ?>
</div>
<?php
echo $form->create();
echo $form->submit('Save', array('name' => 'submit'));
echo $form->end();