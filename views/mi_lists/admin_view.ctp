<?php
extract($data);
$this->set('title_for_layout', $MiList['id']);
$linkedController = Inflector::underscore(Inflector::pluralize($MiList['model']));
?>
<h3><?php echo $MiList['id']; ?></h3>
<div class="odd clearfix">
	<div class="field athird">
		<div class="name"><?php __d('mi_lists_field_names', 'Mi List Order') ?></div>
		<div class="value"><?php echo $enum->display('MiList.order', $MiList['order']); ?></div>
	</div>
</div>
<h3>half</h3>
<div class="odd clearfix">
	<div class="field half">
		<div class="name"><?php __d('mi_lists_field_names', 'Mi List Section') ?></div>
		<div class="value"><?php echo $MiList['section']; ?></div>
	</div>
</div>
<div class="even clearfix">
	<div class="field half">
		<div class="name"><?php __d('mi_lists_field_names', 'Mi List Model') ?></div>
		<div class="value"><?php echo $MiList['model']; ?></div>
	</div>
	<div class="field half">
		<div class="name"><?php __d('mi_lists', 'Linked to') ?></div>
		<div class="value"><?php echo $html->link(${$linkedController}[$MiList['foreign_id']], array('controller' => $linkedController, 'action' => 'view', $MiList['foreign_id'])); ?></div>
	</div>
</div>
<h3>default</h3>
<?php
$menu->settings(__d('mi_lists', 'This Mi List', true));
$menu->add(array(
	array('title' => __d('mi_lists', 'Edit', true), 'url' => array('action' => 'edit', $MiList['id'])),
	array('title' => __d('mi_lists', 'Delete', true), 'url' => array('action' => 'delete', $MiList['id']))
));