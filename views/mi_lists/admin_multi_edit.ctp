<?php
$this->set('title_for_layout', __d('mi_lists', 'Mi Lists', true));
echo $form->create(); ?>
<table>
<?php
$th = array(
	__d('mi_listsfield_names', 'Mi List Id', true),
	__d('mi_listsfield_names', 'Mi List Section', true),
	__d('mi_listsfield_names', 'Mi List Model', true),
	__d('mi_listsfield_names', 'Mi List Foreign', true),
);
echo $html->tableHeaders($th);
foreach ($data as $i => $row) {
	if (!is_array($row) || !isset($row['MiList'])) {
		continue;
	}
	extract($row);
	$tr = array(
		array(
			$MiList['id'] . $form->input($i . '.MiList.id', array('type' => 'hidden')),
			$form->input($i . '.MiList.section', array('div' => false, 'label' => false)),
			$form->input($i . '.MiList.model', array('div' => false, 'label' => false)),
			$form->input($i . '.MiList.foreign_id', array('div' => false, 'label' => false)),
		),
	);
	$class = $i%2?'even':'odd';
	if ($this->action === 'admin_multi_add') {
		$class .= ' clone';
	}
	echo $html->tableCells($tr, compact('class'), compact('class'));
}
?>
</table>
<?php
echo $form->end(__d('mi_lists', 'Submit', true));
if (isset($paginator) && $this->action !== 'admin_multi_add') {
	echo $this->element('paging');
}