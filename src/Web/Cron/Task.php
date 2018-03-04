<?php

namespace QKPHP\Common\Web\Cron;

abstract class Task extends \QKPHP\Common\Web\Object {

  abstract public function process($params=array());

}
