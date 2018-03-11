<?php

namespace QKPHP\Common\Config;

class Parser {

  private $configDir;
  private $configs = array();

  public function __construct ($configDir=null) {
    $this->configDir = $configDir;
  }

  public function getValue($appName, $key=null, $type=null) {
    if (empty($type)) {
      $type = '';
    }
    if (!isset($this->configs[$type][$appName])) {
      $conf = require($this->configDir . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $appName . '.php');
      $this->configs[$type][$appName] = $conf;
    }
    if (empty($key)) {
      return $this->configs[$type][$appName];
    }
    return $this->configs[$type][$appName][$key];
  }

}
