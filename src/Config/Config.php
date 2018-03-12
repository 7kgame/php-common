<?php

namespace QKPHP\Common\Config;

use \QKPHP\Common\Config\Parser;

class Config {

  public static $configDir;
  private static $configs = array();

  public static function setConfigDir ($configDir) {
    self::$configDir = $configDir;
  }

  public static function getAppConf($appName, $key=null) {
    return self::getConf($appName, $key, 'app');
  }

  public static function getDBConf($appName, $key=null) {
    return self::getConf($appName, $key, 'db');
  }

  public static function getServiceConf($appName, $key=null) {
    return self::getConf($appName, $key, 'service');
  }

  public static function getConf($appName, $key=null, $type=null) {
    if (empty(self::$configDir)) {
      return null;
    }
    if (empty($type)) {
      $type = '';
    }
    if (!isset(self::$configs[$type][$appName])) {
      $conf = require(self::$configDir . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $appName . '.php');
      self::$configs[$type][$appName] = $conf;
    }
    if (empty($key)) {
      return self::$configs[$type][$appName];
    }
    return self::$configs[$type][$appName][$key];
  }

}
