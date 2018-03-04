<?php

namespace QKPHP\Common\Config;

use \QKPHP\Common\Config\Parser;

class Config {

  private static $parser;
  private static $configDir;

  public static function setConfigDir ($configDir) {
    self::$configDir = $configDir;
  }

  public static function getAppConf($appName, $key=null) {
    return self::getParser()->getValue($appName, $key, 'app');
  }

  public static function getDBConf($appName, $key="mysql") {
    return self::getParser()->getValue($appName, $key, 'db');
  }

  public static function getServiceConf($appName, $key=null) {
    return self::getParser()->getValue($appName, $key, 'service');
  }

  public static function getConf($appName, $key=null, $type=null) {
    return self::getParser()->getValue($appName, $key, $type);
  }

  private static function getParser() {
    if (empty(self::$parser)) {
      self::$parser = new Parser(self::$configDir); 
    }
    return self::$parser;
  }

}
