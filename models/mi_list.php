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

	public $order = array(
		'super_section',
		'section',
		'order'
	);

	function autoPopulate($superSection = null, $sections = array()) {
		$sections = (array)$sections;
		ksort($sections);
		if($sections) {
			$this->deleteAll(array('section' => $sections));
		} else {
			$this->deleteAll(array('super_section' => $superSection));
			$sections = array_keys(MiCache::setting("Lists.$superSection.sublists"));
		}
		foreach($sections as $section) {
			$this->_autoPopulate($superSection, $section);
		}
	}

	function _autoPopulate($superSection, $section = null) {
		$sSettings = MiCache::setting("Lists.$superSection");
		$settings = MiCache::setting("Lists.$superSection.sublists.$section");
		$settings = array_merge($sSettings, $settings);
		$Model = ClassRegistry::init($settings['model']);
		$conditions = $settings['conditions'];
		$this->Behaviors->disable('List');
		$conditions['NOT']['id'] = array_values($this->find('list', array(
			'conditions' => array('super_section' => $superSection),
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
				'section' => $settings['name'],
				'super_section' => $superSection,
				'model' => $settings['model'],
				'foreign_id' => $id,
			);
			$this->save($toSave);
		}
	}
}