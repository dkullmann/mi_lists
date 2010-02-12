<?php
/* MiLists Test cases generated on: 2010-02-11 23:02:40 : 1265929000*/
App::import('Controller', 'MiLists.MiLists');

class TestMiListsController extends MiListsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class MiListsControllerTestCase extends CakeTestCase {

	function startTest() {
		$this->MiLists = new TestMiListsController();
		$this->MiLists->constructClasses();
	}

	function endTest() {
		unset($this->MiLists);
		ClassRegistry::flush();
	}

}