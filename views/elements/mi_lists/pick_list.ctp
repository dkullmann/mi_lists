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
foreach ($data as $id => $title) {
	echo '<li>';
	echo $html->link($text->truncate($title, 60), array('controller' => $controller, 'action' => 'view', $id));
	$menu->settings('listManage', array('class' => 'actions tree-options'));
	if ($class === 'draggableItems') {
		foreach($sections as $s) {
			$menu->add(array(
				array('title' => '+ ' . $s, 'url' => array ('add' => $id, 'section' => $s), 'class' => 'mini-icon mini-plus'),
			));
		}
	} else {
		$menu->add(array(
			array('title' => 'x', 'url' => array('delete' => $id, 'section' => $section), 'class' => 'mini-icon mini-close'),
			array('title' => '↑', 'url' => array ('move_up' => $id, 'section' => $section), 'class' => 'mini-icon mini-arrowthick-1-n'),
			array('title' => '↓', 'url' => array ('move_down' => $id, 'section' => $section), 'class' => 'mini-icon mini-arrowthick-1-s'),
		));
	}
	echo $menu->display();
	echo '</li>';
}
?>
</ol>