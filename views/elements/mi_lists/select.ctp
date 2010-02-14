<h3><?php echo $title ?></h3>
<?php
$asset->js(array(
	'jquery.mi.ajax',
	'/mi_lists/js/manage'
	),
	$this->name
);
echo $form->create(false, array('url' => array()));
echo $form->input('query', array('label' => false));
echo $form->end('Search');

$this->set('mainDivClass', 'floatWrapper clearfix');
$this->set('title_for_layout', sprintf(__d('mi_lists', 'Manage list "%s"', true), $this->params['pass'][0]));
echo $this->element('mi_lists/pick_list', array('class' => 'draggableItems'));
echo $this->element('paging');