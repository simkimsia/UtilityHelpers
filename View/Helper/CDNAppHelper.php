<?php
/**
 * CDNAppHelperTest file
 *
 * PHP 5
 *
 * This is for app helper to extend from.
 * It will prepend the cdn domain.
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
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class CDNAppHelper extends Helper {
/**
 * Generate url for given asset file that prepends with the cdn base url. Depending on options passed provides full url with domain name.
 * Also calls Helper::assetTimestamp() to add timestamp to local files
 *
 * @param string|array Path string or url array
 * @param array $options Options array. Possible keys:
 *   `fullBase` Return full url with domain name
 *   `pathPrefix` Path prefix for relative URLs
 *   `ext` Asset extension to append
 *   `plugin` False value will prevent parsing path as a plugin
 * @return string Generated url with cdn domain prepended.
 */
    public function assetUrl($path, $options = array()) {
        $cdnBaseUrl = Configure::read('App.assetsUrl');
        $legitCDN = (strpos($cdnBaseUrl, '://') !== false);
        if (is_array($path)) {
            $path = $this->url($path, !empty($options['fullBase']));
            if ($legitCDN) {
                return rtrim($cdnBaseUrl, '/') . '/' . ltrim($path, '/');
            }
            return $path;
        }
        if (strpos($path, '://') !== false) {
            return $path;
        }
        if (!array_key_exists('plugin', $options) || $options['plugin'] !== false) {
            list($plugin, $path) = $this->_View->pluginSplit($path, false);
        }
        if (!empty($options['pathPrefix']) && $path[0] !== '/') {
            $path = $options['pathPrefix'] . $path;
        }
        if (
            !empty($options['ext']) &&
            strpos($path, '?') === false &&
            substr($path, -strlen($options['ext'])) !== $options['ext']
        ) {
            $path .= $options['ext'];
        }
        if (isset($plugin)) {
            $path = Inflector::underscore($plugin) . '/' . $path;
        }

        $path = $this->_encodeUrl($this->assetTimestamp($this->webroot($path)));
        if ($legitCDN) {
            $path = rtrim($cdnBaseUrl, '/') . '/' . ltrim($path, '/');
        }
        return $path;
    }
}