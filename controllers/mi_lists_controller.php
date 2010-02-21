<?php
class MiListsController extends MiListsAppController {

	public $name = 'MiLists';

	public $components = array(
	);

	public $helpers = array(
	);

	public $uses = array(
		'MiLists.MiList',
		'MiDataBuckets.DataBucket'
	);

	public function beforeFilter() {
		parent::beforeFilter();
		$superSection = $this->Session->read('MiLists.superSection');
		$userId = $this->Auth->user('id');
		$this->DataBucket->id = $this->DataBucket->field('id', array(
			'key' => "MiLists.$superSection.$userId"
		));
	}

	public function admin_auto_populate($super = null, $section = null) {
		if ($super) {
			$supers = array($super);
		} else {
			$supers = array_keys(MiCache::setting('MiLists'));
			$section = null;
		}
		foreach($supers as $super) {
			if ($section) {
				$sections = array($section);
			} else {
				$sections = array_keys(MiCache::setting("MiLists.$super.sublists"));
			}
			foreach($sections as $section) {
				$this->MiList->autoPopulate($super, $section);
			}
		}
		$this->redirect(array('action' => 'index'));
	}

	public function admin_add($superSection = null, $section = null, $id = null) {
		$data = $this->DataBucket->read();
		debug(MiCache::setting("List")); die;
		list($ids) = array_chunk($ids, MiCache::setting("List.$superSection.sublist.$section.limit" - 1, true));
		$ids[$id] = $id;
		break;
		debug ($data); die;

	}

	public function admin_delete($id = null) {
	}

	public function admin_move_down($id = null) {
	}

	public function admin_move_up($id = null) {
	}

	public function admin_index() {
		if (isset($this->SwissArmy)) {
			$conditions = $this->SwissArmy->parseSearchFilter();
		} else {
			$conditions = array();
		}
		if ($conditions) {
			$this->set('filters', $this->MiList->searchFilterFields());
			$this->set('addFilter', true);
		}
		$this->data = $this->paginate($conditions);
		$this->_setSelects();
	}

	public function admin_lookup($input = '') {
		$this->autoRender = false;
		if (!$input) {
			$input = $this->params['url']['q'];
		}
		if (!$input) {
			$this->output = '0';
			return;
		}
		$conditions = array(
			'id LIKE' => $input . '%',
			'id LIKE' => $input . '%'
		);
		if (!$this->data = $this->MiList->find('list', compact('conditions'))) {
			$this->output = '0';
			return;
		}
		return $this->render('/elements/lookup_results');
	}

	function admin_home($term = null) {
		if ($this->data) {
			if (!empty($_POST['submit']) && $_POST['submit'] === 'Grabar') {
				$Portada = ClassRegistry::init('Portada')->update($this->Session->read('Noticias.Home'));
				$this->Session->write(__d('panel', 'Index updated', true));
				$this->redirect(array('plugin' => false, 'prefix' => false, 'admin' => false, 'action' => 'index'));
			}

			if (!empty($this->data['query'])) {
				$term = trim($this->data['query']);
				$url = array(urlencode($term));
				$this->redirect($url);
			}
		}
		if ($this->params['named']) {
			$keys = array_intersect_key(
				$this->params['named'],
				array_flip(	array(
					'add',
					'delete',
					'move_down',
					'move_up',
					'section'
				))
			);
			if (!empty($keys['section'])) {
				$section = $keys['section'];
				unset($keys['section']);
				$action = key($keys);
				$id = current($keys);
				$ids = $this->Session->read('Noticias.Home.' . $section);
				switch ($action) {
					case 'add':
						$maxSizes = array(1 => 2, 2 => 6, 3 => 8);
						$maxSize = $maxSizes[$section];
						list($ids) = array_chunk($ids, $maxSize - 1, true);
						$ids[$id] = $id;
						break;
					case 'delete':
						$key = array_search($id, $ids);
						unset ($ids[$key]);
						break;
					case 'move_up':
						$key = array_search($id, $ids);
						$_key = $prev = null;
						while (list($_key, $_prev) = each($ids)) {
							if ($key === $_key) {
								break;
							}
							$prev = $_key;
						}
						if (!empty($ids[$prev])) {
							$ids[$key] = $ids[$prev];
							$ids[$prev] = $id;
							$ids = array_values($ids);
							$ids = array_combine($ids, $ids);
						}
						break;
					case 'move_down':
						$key = array_search($id, $ids); $_key = $_next = null;
						while (list($_key, $_next) = each($ids)) {
							if ($key === $_key) {
								list($next, $_next) = each($ids);
								break;
							}
						}
						if (!empty($ids[$next])) {
							$ids[$key] = $ids[$next];
							$ids[$next] = $id;
							$ids = array_values($ids);
							$ids = array_combine($ids, $ids);
						}
						break;
				}
				$this->Session->write("Noticias.Home.$section", $ids);
				$this->redirect(array());
			}
		}
		if ($term) {
			$conditions = $this->Noticia->searchConditions($term);
		} else {
			$conditions = array();
		}
		$conditions['Noticia.tipo'] = 1;
		$sections = $this->Session->read('Noticias.Home');
		if (!$sections || !empty($this->params['named']['reset'])) {
			$Portada = ClassRegistry::init('Portada');
			$sections = $Portada->find('list', array(
				'fields' => array('noticia_id', 'noticia_id', 'seccion'),
				'order' => 'orden'
			));
			$this->Session->write('Noticias.Home', $sections);
		}

		$alreadyChosen = array();
		foreach($sections as $ids) {
			$alreadyChosen = array_merge($alreadyChosen, $ids);
		}

		foreach($sections as $section => &$ids) {
			$rows = $this->Noticia->find('all', array(
				'conditions' => array('Noticia.id' => $ids)
			));
			foreach($rows as $row) {
				$ids[$row['Noticia']['id']] = $row;
			}
		}
		$this->set(compact('sections'));
		$conditions['NOT']['Noticia.id'] = $alreadyChosen;
		$this->data = $this->paginate($conditions);
		if (!empty($this->params['isAjax'])) {
			$this->set('class', 'draggableItems');
			return $this->render('/elements/noticias/home_select');
		}
		$this->_setSelects();
	}

	public function admin_manage($superSection = null, $section = null) {
		if ($superSection === 'index') { // TODO fix this
			$superSection = null;
		}
		if (!$superSection) {
			$config = MiCache::setting('MiLists');
			if (count($config) === 1) {
				$this->redirect(array(key($config)));
			} else {
				if (!$config) {
					$this->Session->setFlash(__d('mi_lists', 'No lists are defined', true));
					$this->_back();
				}
				$this->Session->setFlash(__d('mi_lists', 'Select a super section to manage', true));
				$this->redirect(array('action' => 'index'));
			}
		}
		if ($this->data) {
			if (!empty($_POST['submit']) && $_POST['submit'] === 'Save') {
				$this->loadModel('MiDataBuckets.DataBucket');
				$data = $this->DataBucket->data($key);
				$this->MiList->update($superSection, $section, $data);
				$this->redirect(array('action' => 'index'));
			}

			if (!empty($this->data['query'])) {
				$term = trim($this->data['query']);
				$url = array($superSection, $section, 'query' => urlencode($term));
				$this->redirect($url);
			}
		}

		$config = MiCache::setting('MiLists.' . $superSection);
		if ($section) {
			$sectionConfig = $config['sublists'][$section];
		} else {
			$sectionConfig = current($config['sublists']);
		}
		$sectionConfig = array_merge($config, $sectionConfig);
		unset($sectionConfig['sublists']);

		$conditions = array('super_section' => $superSection);
		if ($section) {
			$conditions = array('section' => $section);
		}

		$sections = null; // find from databucket
		if (!$sections || !empty($this->params['named']['reset'])) {
			$this->MiList->Behaviors->disable('List');
			$sections = $this->MiList->find('list', array(
				'fields' => array('foreign_id', 'foreign_id', 'section'),
				'conditions' => $conditions,
				'order' => array('super_section', 'section', 'order')
			));
			$this->MiList->Behaviors->enable('List');
		}

		$alreadyChosen = array();
		foreach($sections as $ids) {
			$alreadyChosen = array_merge($alreadyChosen, $ids);
		}

		$model = $sectionConfig['model'];
		$this->loadModel($model);

		foreach($sections as $section => &$ids) {
			$ids = $this->$model->find('list', array(
				'conditions' => array($model . '.id' => $ids)
			));
		}
		if (empty($this->params['named']['query'])) {
			$conditions = array();
		} else {
			$conditions = $this->$model->searchConditions($this->params['named']['query']);
		}
		if ($sectionConfig['conditions']) {
			$conditions = array_merge($conditions, $sectionConfig['conditions']);
		}
		$conditions['NOT'][$model . '.id'] = $alreadyChosen;
		$this->data = $this->paginate($model, $conditions);
		$alreadyChosen = array_merge($alreadyChosen, Set::extract($this->data, "/$model/id"));
		$titles = $this->$model->find('list', array(
			'conditions' => array($model . '.id' => $alreadyChosen)
		));
		$controller = __(Inflector::pluralize($model), true);
		$title = sprintf(__d('mi_lists', 'All %s', true), $controller);
		$this->set(compact('titles', 'sections', 'config', 'title', 'superSection', 'section', 'controller'));
		if (!empty($this->params['isAjax'])) {
			$this->set('class', 'draggableItems');
			return $this->render('/elements/mi_lists/select');
		}
	}

	protected function _setSelects($restrictToData = true) {
		if (is_array($this->data) && isset($this->data[0]) && is_array($this->data[0])) {
			$sets = $stacks = array();
			foreach($this->data as $row) {
				$stacks[$row['MiList']['model']][$row['MiList']['foreign_id']] = $row['MiList']['foreign_id'];
			}
			$models = array();
			foreach($stacks as $model => $ids) {
				if (isset($models[$model])) {
					$Model = $models[$model];
				} else {
					$models[$model] = $Model = ClassRegistry::init($model);
				}
				$alias = Inflector::underscore(Inflector::pluralize($model));
				$sets[$alias] = $Model->find('list', array('conditions' => array(
					$Model->alias . '.' . $Model->primaryKey => $ids
				)));
			}
		} else {
			$models = array_values(MiCache::mi('models'));
			$sets['models'] = array_combine($models, $models);
		}
		$this->set($sets);
	}
}