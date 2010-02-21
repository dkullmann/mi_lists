<div class = "container halfWidthLeft">
	<?php echo $this->element('mi_lists/select'); ?>
</div>
<div class="halfWidthRight">
<?php foreach ($config['sublists'] as $section): ?>
	<div class="container droppable">
		<h3><?php echo $section['name'] . ' [' . $section['limit'] . ' ]' ?></h3>
		<?php
		echo $this->element('mi_lists/pick_list', array(
			'data' => $sections[$section['name']],
			'section' => $section['name'],
			'superSection' => $this->params['pass'][0]
		));
		?>
	</div>
<?php endforeach; ?>
</div>
<?php
echo $form->create();
echo $form->submit('Save', array('name' => 'submit'));
echo $form->end();