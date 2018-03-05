<?php
namespace QKPHP\Common\Utils;

class Utils {

  public static function toXML($params) {
    $params0 = array();
    foreach($params as $k=>$v) {
      $params0[] = '<'.$k.'>'.$v.'</'.$k.'>';
    }
    return '<xml>'.implode('', $params0).'</xml>';
  }

  public static function xmlToArr($xml) {
    if (empty($xml)) {
      return null;
    }
    return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
  }

  public static function rdir ($dir) {
    $files = array();
    if ($handle = opendir($dir)) {

      while (false !== ($file = readdir($handle))) {
        if ($file == '.' || $file == '..') {
          continue;
        }
        if (is_dir($file)) {
          $files = array_merge($files, rdir($dir . DIRECTORY_SEPARATOR . $file));
        } else {
          $files[] = $dir . DIRECTORY_SEPARATOR . $file;
        }
      }
    }
    return $files;
  }

}
