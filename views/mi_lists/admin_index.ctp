<?php
echo $form->create(null, array('action' => 'multi_process'));
?>
<table class="stickyHeader">
<?php
$this->set('title_for_layout', __d('mi_lists', 'Mi Lists', true));
$th = array(
	$form->checkbox('Mark.all Lists', array('class' => 'markAll')),
	$paginator->sort('super_section'),
	$paginator->sort('section'),
	$paginator->sort('order'),
	__d('mi_lists', 'Linked to', true),
	__d('mi_lists', 'actions', true)
);
echo $html->tableHeaders($th);
foreach ($data as $i => $row) {
	extract($row);
	$linkedController = Inflector::underscore(Inflector::pluralize($MiList['model']));
	$actions = array(
		$html->link(' ', array('action' => 'edit', $MiList['id']),
			array('class' => 'mini-icon mini-pencil', 'title' => __d('mi_lists', 'Edit', true))),
		$html->link(' ', array('action' => 'delete',  $MiList['id']),
			array('class' => 'mini-icon mini-close', 'title' => __d('mi_lists', 'Delete', true)))
	);
	$tr = array(
		array(
			$form->checkbox('MiList.' . $MiList['id'], array('class' => 'identifyRow')) .
				$html->link($MiList['id'], array('action' => 'view', $MiList['id']), array('class' => 'hidden')),
			$html->link($MiList['super_section'], array('action' => 'manage', $MiList['super_section'])),
			$html->link($MiList['section'], array('action' => 'manage', $MiList['super_section'], $MiList['section'])),
			$MiList['order'],
			$html->link(${$linkedController}[$MiList['foreign_id']], array('controller' => $linkedController, 'action' => 'view', $MiList['foreign_id'])),
			implode($actions)
		),
	);
	$class = $i%2?'even':'odd';
	echo $html->tableCells($tr, compact('class'), compact('class'));
}
?>
</table>
<div class="buttonChoice">
<p><?php __d('mi_lists', 'For the selected  Mi Lists:') ?></p>
<?php
echo $form->submit(__d('mi_lists', 'Delete', true), array('name' => 'deleteAll', 'div' => false));
echo $form->submit(__d('mi_lists', 'Edit', true), array('name' => 'editAll', 'div' => false));
//echo $form->submit(__d('mi_lists', 'Add to clipboard', true), array('name' => 'clipAll', 'div' => false));
echo $form->end();
?>
</div>
<?php
echo $this->element('mi_panel/paging');
$menu->settings(__d('mi_lists', 'Options', true), array());
$menu->add(array(
	array('title' => __d('mi_lists', 'Auto populate', true), 'url' => array('action' => 'auto_populate')),
	//array('title' => __d('mi_lists', 'Edit These Mi Lists', true), 'url' => am($this->passedArgs, array('action' => 'multi_edit')))
));
$sections = array_keys(MiCache::setting('Lists'));
foreach($sections as $section) {
	$menu->add(array(
		array('title' => sprintf(__d('mi_lists', 'Manage "%s"', true), $section), 'url' => array('action' => 'manage', $section)),
	));
}