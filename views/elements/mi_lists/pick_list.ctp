<?php
if (!isset($class)) {
	$class = '';
}
if ($class === 'draggableItems') {
	$section = $superSection;
}
?>
<ol id="section-<?php echo $section ?>" class="<?php echo $class?>">
<?php
foreach ($data as $id => $title) {
	if (is_array($title)) {
		if (empty($model)) {
			$model = key($title);
		}
		$id = $title[$model]['id'];
		$title = $titles[$title[$model]['id']];
	}
	echo "<li id='Row-$id'>";
	echo $html->link($text->truncate($title, 60), array('controller' => $controller, 'action' => 'view', $id));
	$menu->settings('listManage', array('class' => 'actions tree-options'));
	if ($class === 'draggableItems') {
		foreach($sections as $s => $_) {
			$menu->add(array(
				array('title' => '+ ' . $s, 'url' => array ('action' => 'add', $superSection, $s, $id), 'class' => 'ini-icon ini-plus'),
			));
		}
	} else {
		$menu->add(array(
			array('title' => 'x', 'url' => array('action' => 'delete', $superSection, $section, $id), 'class' => 'ini-icon ini-close'),
			array('title' => '↑', 'url' => array ('action' => 'move_up', $superSection, $section, $id), 'class' => 'ini-icon ini-arrowthick-1-n'),
			array('title' => '↓', 'url' => array ('action' => 'move_down', $superSection, $section, $id), 'class' => 'ini-icon ini-arrowthick-1-s'),
		));
	}
	echo $menu->display();
	echo '</li>';
}
?>
</ol>