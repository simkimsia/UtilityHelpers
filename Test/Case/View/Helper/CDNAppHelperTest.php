<?php
/**
 * CDNAppHelperTest file
 *
 * PHP 5
 *
 * This test is for CDNAppHelper
 * http://github.com/simkimsia/UtilityHelpers
 * 
 * Test case written for Cakephp 2.x
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
 * @lastmodified 2013-10-17
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('View', 'View');
App::uses('Helper', 'View');
App::uses('Model', 'Model');
App::uses('Router', 'Routing');
App::uses('CDNAppHelper', 'UtilityHelpers.View/Helper');

class TestHelper extends CDNAppHelper {

/**
 * Settings for this helper.
 *
 * @var array
 */
	public $settings = array(
		'key1' => 'val1',
		'key2' => array('key2.1' => 'val2.1', 'key2.2' => 'val2.2')
	);

/**
 * Helpers for this helper.
 *
 * @var array
 */
	public $helpers = array('Html');

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

}

/**
 * CDNAppHelperTest class
 *
 * @package       Cake.Test.Case.View
 */
class CDNAppHelperTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		ClassRegistry::flush();
		Router::reload();
		$null = null;
		$this->View = new View($null);
		$this->Helper = new TestHelper($this->View);
		$this->Helper->request = new CakeRequest(null, false);

		Configure::write('App.assetsUrl', 'http://cdn.cloudfront.net');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		Configure::delete('Asset');

		CakePlugin::unload();
		unset($this->Helper, $this->View);
	}

/**
 * test assetUrl application
 *
 * @return void
 */
	public function testAssetUrl() {
		$this->Helper->webroot = '';
		$result = $this->Helper->assetUrl(array(
				'controller' => 'js',
				'action' => 'post',
				'ext' => 'js'
			)
		);
		$cdnBaseUrl = Configure::read('App.assetsUrl');
		$this->assertEquals($cdnBaseUrl . '/js/post.js', $result);

		$result = $this->Helper->assetUrl('foo.jpg', array('pathPrefix' => 'img/'));
		$this->assertEquals("$cdnBaseUrl/img/foo.jpg", $result);

		$result = $this->Helper->assetUrl('foo.jpg', array('fullBase' => true));
		$this->assertEquals("$cdnBaseUrl/foo.jpg", $result);

		$result = $this->Helper->assetUrl('style', array('ext' => '.css'));
		$this->assertEquals("$cdnBaseUrl/style.css", $result);

		$result = $this->Helper->assetUrl('dir/sub dir/my image', array('ext' => '.jpg'));
		$this->assertEquals($cdnBaseUrl . '/dir/sub%20dir/my%20image.jpg', $result);

		$result = $this->Helper->assetUrl('foo.jpg?one=two&three=four');
		$this->assertEquals($cdnBaseUrl . '/foo.jpg?one=two&amp;three=four', $result);

		$result = $this->Helper->assetUrl('dir/big+tall/image', array('ext' => '.jpg'));
		$this->assertEquals($cdnBaseUrl . '/dir/big%2Btall/image.jpg', $result);
	}

/**
 * Test assetUrl with no rewriting.
 *
 * @return void
 */
	public function testAssetUrlNoRewrite() {
		$this->Helper->request->addPaths(array(
			'base' => '/cake_dev/index.php',
			'webroot' => '/cake_dev/app/webroot/',
			'here' => '/cake_dev/index.php/tasks',
		));
		$result = $this->Helper->assetUrl('img/cake.icon.png', array('fullBase' => true));
		$cdnBaseUrl = Configure::read('App.assetsUrl');
		$expected = $cdnBaseUrl . '/cake_dev/app/webroot/img/cake.icon.png';
		$this->assertEquals($expected, $result);
	}

}