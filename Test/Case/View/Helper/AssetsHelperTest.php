<?php
/**
 * AssetsHelperTest file
 *
 * PHP 5
 *
 * This is for testing AssetsHelper
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2011-2013, Kim Stacks.
 * @link http://stacktogether.com
 * @author Kim Stacks <kim@stacktogether.com>
 * @package UtilityHelpers
 * @subpackage UtilityHelpers.Test.Case.View.Helper
 * @filesource
 * @version 0.1
 * @lastmodified 2013-10-20
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('Helper', 'View');
App::uses('AppHelper', 'View/Helper');
App::uses('AssetsHelper', 'UtilityHelpers.View/Helper');
App::uses('ClassRegistry', 'Utility');
App::uses('Folder', 'Utility');

if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', 'http://cakephp.org');
}

/**
 * TheAssetsTestController class
 *
 * @package       Cake.Test.Case.View.Helper
 */
class TheAssetsTestController extends Controller {

/**
 * name property
 *
 * @var string
 */
	public $name = 'TheTest';

/**
 * uses property
 *
 * @var mixed null
 */
	public $uses = null;
}

class TestAssetsHelper extends AssetsHelper {

/**
 * expose a method as public
 *
 * @param string $options
 * @param string $exclude
 * @param string $insertBefore
 * @param string $insertAfter
 * @return void
 */
	public function parseAttributes($options, $exclude = null, $insertBefore = ' ', $insertAfter = null) {
		return $this->_parseAttributes($options, $exclude, $insertBefore, $insertAfter);
	}

/**
 * Get a protected attribute value
 *
 * @param string $attribute
 * @return mixed
 */
	public function getAttribute($attribute) {
		if (!isset($this->{$attribute})) {
			return null;
		}
		return $this->{$attribute};
	}

}

/**
 * AssetsHelperTest class
 *
 * @package       Cake.Test.Case.View.Helper
 */
class AssetsHelperTest extends CakeTestCase {

/**
 * Assets property
 *
 * @var object
 */
	public $Assets = null;

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->View = $this->getMock('View', array('append'), array(new TheAssetsTestController()));
		$this->Assets = new TestAssetsHelper($this->View);
		$this->Assets->request = new CakeRequest(null, false);
		$this->Assets->request->webroot = '';
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		unset($this->Assets, $this->View);
	}

/**
 * testCssFiles method
 *
 * @return void
 */
	public function testCssFiles() {
		// WHEN we test if cssfiles is an array
		// THEN we expect true
		$this->assertTrue(is_array($this->Assets->cssFiles));
	}
}
