<div id="tabWrap" class="form-container">
<ul>
		<li><a href="#tab1">Tab 1</a></li>
	</ul>
<?php
if ($this->action === 'admin_add') {
	$this->set('title_for_layout', __d('mi_lists', 'New Mi List', true));
} else {
	$this->set('title_for_layout', __d('mi_lists', 'Edit Mi List', true));
}
?>
<div class="form-container">
<?php
echo $form->create(null, array('type' => 'file')); // Default to enable file uploads
echo '<div id="tab1">';
echo $form->inputs(array(
	'legend' => false,
	'id',
	'section',
	'model',
	'foreign_id',
));
echo '</div>';
echo $form->end(__d('mi_lists', 'Submit', true));
$asset->js('jquery-ui.tabs', $this->name);
$asset->codeBlock('
  $(document).ready(function(){
    $("#tabWrap").tabs();
  });
');
?></div>
</div>