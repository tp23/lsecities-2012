<?php
/* This class processes assets to be included in template pages
 * 
 * example code taken from:
 * http://scribu.net/wordpress/optimal-script-loading.html
 */

class LcAssetPipeline {
  static $asset_map;
  
  static function init($asset_map) {
    self::$asset_map = $asset_map;
  }
}
