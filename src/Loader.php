<?php
namespace QKPHP\Common;

class Loader {
  const NS_SEPARATOR     = '\\';
  const NAME_SEPARATOR = '_';

  public static $classMap = array();
  public static $prefixDir = '';

  public static function setPrefixDir($dir) {
    self::$prefixDir = $dir;
  }

  public static function load() {
    if (defined(SITE_BASE)) {
      self::setPrefixDir(SITE_BASE);
    }
    spl_autoload_register(function ($class) {
      if (isset(Loader::$classMap[$class])) {
        include(Loader::$classMap[$class]);
      } else {
        // replace '\' and '_' to DIRECTORY_SEPARATOR
        $file = str_replace(Loader::NAME_SEPARATOR, DIRECTORY_SEPARATOR, $class);
        if (false !== strpos($class, Loader::NS_SEPARATOR)) {
          $file = str_replace(Loader::NS_SEPARATOR, DIRECTORY_SEPARATOR, $file);
        }
        if (!empty(Loader::$prefixDir)) {
          $file = Loader::$prefixDir . DIRECTORY_SEPARATOR . $file;
        }
        $file = $file . ".php";
        if (file_exists($file)) {
          Loader::$classMap[$class] = $file;
          include $file;
        }
      }
    });
  }
}

Loader::load();
