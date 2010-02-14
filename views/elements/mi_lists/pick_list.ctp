<?php
if (!isset($class)) {
	$class = '';
}
?>
<ol class="<?php echo $class?>">
<?php
if (!$data) {
	echo '<li class="empty"> </li>';
}
foreach ($data as $i => $row) {
	if (empty($model)) {
		$model = key($row);
	}
	extract($row);
	echo '<li>';
	echo $text->truncate($titles[$row[$model]['id']], 60);
	$menu->settings('listMove', array('class' => 'actions tree-options'));
	if ($class === 'draggableItems') {
		foreach(array_keys($sections) as $section) {
			$menu->add(array(
				array('title' => '+ ' . $section, 'url' => array ('add' => $row[$model]['id'], 'section' => $section), 'class' => 'mini-icon mini-plus'),
			));
		}
	} else {
		$menu->add(array(
			array('title' => 'x', 'url' => array('delete' => $row[$model]['id'], 'section' => $section), 'class' => 'mini-icon mini-close'),
			array('title' => '↑', 'url' => array ('move_up' => $row[$model]['id'], 'section' => $section), 'class' => 'mini-icon mini-arrowthick-1-n'),
			array('title' => '↓', 'url' => array ('move_down' => $row[$model]['id'], 'section' => $section), 'class' => 'mini-icon mini-arrowthick-1-s'),
		));
	}
	echo $menu->display();
	echo '</li>';
}
?>
</ol>