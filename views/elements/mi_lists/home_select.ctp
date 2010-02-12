<h3><?php echo $title ?></h3>
<?php
$asset->js('mi_lists/manage', $this->name);
$asset->js('jquery.mi.ajax', $this->name);
echo $form->create(false, array('url' => array()));
echo $form->input('query', array('label' => false));
echo $form->end('Search');

$this->set('mainDivClass', 'floatWrapper clearfix');
echo $this->element('mi_lists/pick_list', array('class' => 'draggableItems'));
echo $this->element('paging');