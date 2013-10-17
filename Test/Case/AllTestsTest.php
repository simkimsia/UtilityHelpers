<?php

class AllTestsTest extends PHPUnit_Framework_TestSuite {

/**
 * suite method, defines tests for this suite.
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All Tests');
		$suite->addTestDirectoryRecursive(App::pluginPath('UtilityHelpers') . 'Test' . DS . 'Case' . DS . 'View' . DS . 'Helper');

		return $suite;
	}
}