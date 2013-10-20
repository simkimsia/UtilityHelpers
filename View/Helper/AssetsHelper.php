<?php
/**
 * AssetsHelper file
 *
 * PHP 5
 *
 * This is for keeping track of cssfiles that are already invoked in the particular view
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
App::uses('AppHelper', 'View/Helper');
class AssetsHelper extends AppHelper {

	public $cssFiles = array();

}