<?php
class MiListsController extends MiListsAppController {

	public $name = 'MiLists';

	public $components = array(
	);

	public $helpers = array(
	);

	public function admin_auto_populate() {
		$toProcess = array();
		$lists = MiCache::setting('Lists');
		foreach($lists as $section => $params) {
			if (empty($params['allowAutoUpdate'])) {
				continue;
			}
			$toProcess[$params['superSection']][$params['priority']] = $section;
		}
		foreach($toProcess as $listPacket) {
			$this->MiList->autoPopulate($listPacket);
		}
		$this->redirect(array('action' => 'index'));
	}

	public function admin_add() {
		if ($this->data) {
			if ($this->MiList->saveAll($this->data)) {
				$display = $this->MiList->display();
				$this->Session->setFlash(sprintf(__d('mi_lists', 'Mi list "%1$s" added', true), $display));
				return $this->_back();
			} else {
				$this->data = $this->MiList->data;
				if (Configure::read()) {
					foreach ($this->MiList->validationErrors as $i => &$error) {
						if (is_array($error)) {
							$error = implode($error, '<br />');
						}
					}
					$this->Session->setFlash(implode($this->MiList->validationErrors, '<br />'));
				} else {
					$this->Session->setFlash(__d('mi_lists', 'errors in form', true));
				}
			}
		}
		$this->_setSelects(false);
		$this->render('admin_edit');
	}

	public function admin_delete($id = null) {
		$this->MiList->id = $id;
		if ($id && $this->MiList->exists()) {
			$display = $this->MiList->display($id);
			if ($this->MiList->delete($id)) {
				$this->Session->setFlash(sprintf(__d('mi_lists', 'Mi list %1$s "%2$s" deleted', true), $id, $display));
			} else {
				$this->Session->setFlash(sprintf(__d('mi_lists', 'Problem deleting mi list %1$s "%2$s"', true), $id, $display));
			}
		} else {
			$this->Session->setFlash(sprintf(__d('mi_lists', 'Mi list with id %1$s doesn\'t exist', true), $id));
		}
		return $this->_back();
	}

	public function admin_edit($id = null) {
		if ($this->data) {
			if ($this->MiList->saveAll($this->data)) {
				$display = $this->MiList->display();
				$this->Session->setFlash(sprintf(__d('mi_lists', 'Mi list "%1$s" updated', true), $display));
				return $this->_back();
			} else {
				$this->data = $this->MiList->data;
				if (Configure::read()) {
					foreach ($this->MiList->validationErrors as $i => &$error) {
						if (is_array($error)) {
							$error = implode($error, '<br />');
						}
					}
					$this->Session->setFlash(implode($this->MiList->validationErrors, '<br />'));
				} else {
					$this->Session->setFlash(__d('mi_lists', 'errors in form', true));
				}
			}
		} elseif ($id) {
			$this->data = $this->MiList->read(null, $id);
			if (!$this->data) {
				$this->Session->setFlash(sprintf(__d('mi_lists', 'Mi list with id %1$s doesn\'t exist', true), $id));
				$this->_back();
			}
		} else {
			return $this->_back();
		}
		$this->_setSelects(false);
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

	public function admin_manage($superSection = null) {

	}

	public function admin_multi_add() {
		if ($this->data) {
			$data = array();
			foreach ($this->data as $key => $row) {
				if (!is_numeric($key) || !array_filter(current($row))) {
					continue;
				}
				$data[$key] = $row;
			}
			if ($this->MiList->saveAll($data, array('validate' => 'first', 'atomic' => false))) {
				$this->Session->setFlash(sprintf(__d('mi_lists', 'Milists added', true)));
				$this->_back();
			} else {
				if (Configure::read()) {
					foreach ($this->MiList->validationErrors as $i => &$error) {
						if (is_array($error)) {
							$error = implode($error, '<br />');
						}
					}
					if($this->MiList->validationErrors) {
						$this->Session->setFlash(implode($this->MiList->validationErrors, '<br />'));
					} else {
						$this->Session->setFlash(__d('mi_lists', 'Save did not succeed with no validation errors', true));
					}
				} else {
					$this->Session->setFlash(__d('mi_lists', 'Some or all additions did not succeed', true));
				}
			}
		} else {
			$this->data = array('1' => array('MiList' => $this->MiList->create()));
			$this->data[1]['MiList']['id'] = null;
		}
		$this->_setSelects(false);
		$this->render('admin_multi_edit');
	}

	public function admin_multi_edit() {
		if ($this->data) {
			$data = array();
			foreach ($this->data as $key => $row) {
				if (!is_numeric($key)) {
					continue;
				}
				$data[$key] = $row;
			}
			if ($this->MiList->saveAll($data, array('validate' => 'first'))) {
				$this->Session->setFlash(sprintf(__d('mi_lists', 'Milists updated', true)));
			} else {
				if (Configure::read()) {
					foreach ($this->MiList->validationErrors as $i => &$error) {
						if (is_array($error)) {
							$error = implode($error, '<br />');
						}
					}
					if($this->MiList->validationErrors) {
						$this->Session->setFlash(implode($this->MiList->validationErrors, '<br />'));
					} else {
						$this->Session->setFlash(__d('mi_lists', 'Save did not succeed with no validation errors', true));
					}
				} else {
					$this->Session->setFlash(__d('mi_lists', 'Some or all updates did not succeed', true));
				}
			}
			$this->params['paging'] = $this->Session->read('MiList.paging');
			$this->helpers[] = 'Paginator';
		} else {
			$args = func_get_args();
			call_user_func_array(array($this, 'admin_index'), $args);
			array_unshift($this->data, 'dummy');
			unset($this->data[0]);
			$this->Session->write('MiList.paging', $this->params['paging']);
		}
		$this->_setSelects(false);
	}

	public function admin_multi_process($action = null) {
		if (!$this->data) {
			$this->_back();
		}
		$ids = array_filter($this->data['MiList']);
		if (!$ids) {
			$this->Session->setFlash(__d('mi_lists', 'Nothing selected, nothing to do', true));
			$this->_back();
		}
		if($action === null) {
			if (isset($_POST['deleteAll'])) {
				$action = 'delete';
				$message = __d('mi_lists', 'Milists deleted.', true);
			} elseif (isset($_POST['editAll'])) {
				$ids = array_keys(array_filter($this->data['MiList']));
				return $this->redirect(array(
					'action' => 'multi_edit',
					'id' => '(' . implode($ids, ',') . ')'
				));
			} else {
				$this->Session->setFlash(__d('mi_lists', 'No action defined, don\'t know what to do', true));
				$this->_back();
			}
		}
		foreach($ids as $id => $do) {
			switch($action) {
				case 'delete':
					$this->MiList->delete($id);
					break;
			}
		}
		$this->Session->setFlash($message);
		$this->_back();
	}

	public function admin_search($term = null) {
		if ($this->data) {
			$term = trim($this->data['MiList']['query']);
			$url = array(urlencode($term));
			if (!empty($this->data['MiList']['extended'])) {
				$url['extended'] = true;
			}
			$this->redirect($url);
		}
		$request = $_SERVER['REQUEST_URI'];
		$term = trim(str_replace(Router::url(array()), '', $request), '/');
		if (!$term) {
			$this->redirect(array('action' => 'index'));
		}
		$conditions = $this->MiList->searchConditions($term, isset($this->passedArgs['extended']));
		$this->Session->setFlash(sprintf(__d('mi_lists', 'All milists matching the term "%1$s"', true), htmlspecialchars($term)));
		$this->data = $this->paginate($conditions);
		$this->_setSelects();
		$this->render('admin_index');
	}

	public function admin_view($id = null) {
		$this->data = $this->MiList->read(null, $id);
		$Model = ClassRegistry::init($this->data['MiList']['model']);
		$alias = Inflector::underscore(Inflector::pluralize($this->data['MiList']['model']));
		$values[$this->data['MiList']['foreign_id']] = $Model->display($this->data['MiList']['foreign_id']);
		$this->set($alias, $values);

		$this->_setSelects();
		if(!$this->data) {
			$this->Session->setFlash(__d('mi_lists', 'Invalid mi list', true));
			return $this->_back();
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