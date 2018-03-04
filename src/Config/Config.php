<?php

namespace QKPHP\Common\Config;

use \QKPHP\Common\Config\Parser;

class Config {

  private static $parser;
  private static $configDir;

  public static function setConfigDir ($configDir) {
    self::$configDir = $dir;
  }

  public static function getAppConf($appName, $key) {
    return self::getParser()->getValue('app', $appName, $key);
  }

  public static function getDBConf($appName, $key="mysql") {
    return self::getParser()->getValue('db', $appName, $key);
  }

  public static function getServiceConf($appName, $key) {
    return self::getParser()->getValue('service', $appName, $key);
  }

  public static function getConf($type, $appName, $key) {
    return self::getParser()->getValue($type, $appName, $key);
  }

  private static function getParser($name) {
    if (empty(self::$parser)) {
      self::$parser = new Parser(self::$configDir); 
    }
    return self::$parser;
  }

}
