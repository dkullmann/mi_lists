<?php
class MiList extends MiListsAppModel {

	var $name = 'MiList';

	var $validate = array(
		'model' => array(
			'notempty' => array('rule' => array('notempty')),
		),
		'foreign_id' => array(
			'notempty' => array('rule' => array('notempty')),
		),
	);

	public $actsAs = array(
		'Mi.List' => array(
			'scope' => array('section')
		)
	);

	function autoPopulate($sections = array()) {
		$sections = (array)$sections;
		ksort($sections);
		$this->deleteAll(array('section' => $sections));
		foreach($sections as $section) {
			$this->_autoPopulate($section);
		}
	}

	function _autoPopulate($section = null) {
		$settings = MiCache::setting('Lists.' . $section);
		$Model = ClassRegistry::init($settings['model']);
		$this->debug(2, true);
		$conditions = (array)json_decode($settings['conditions'], true);
		$this->Behaviors->disable('List');
		$conditions['NOT']['id'] = array_values($this->find('list', array(
			'conditions' => array('super_section' => $settings['superSection']),
			'fields' => array('foreign_id', 'foreign_id'),
		)));
		$this->Behaviors->enable('List');
		$rows = $Model->find('list', array(
			'conditions' => $conditions,
			'fields' => array('id', 'id'),
			'limit' => $settings['limit'],
			'order' => $settings['order']
		));
		foreach($rows as $id) {
			$this->create();
			$toSave = array(
				'section' => $section,
				'super_section' => $settings['superSection'],
				'model' => $settings['model'],
				'foreign_id' => $id,
			);
			$this->save($toSave);
		}
	}
}