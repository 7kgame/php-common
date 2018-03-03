<?php

namespace QKPHP\Common\WWW;

abstract class Controller {

  //Section init
  protected $annotation = array();

  public function setAnnotation($annotation) {
    if (is_array($annotation)) {
      $this->annotation = $annotation;
    }
  }

  //Section lifecycle
  public function beforeCall() {
  }

  public function afterCall() {
  }

  //Section view
  private $template;
  private $view;

  private function initTemplate() {
    if(empty($this->template)) {
      $this->template = new namespace\Template();
      $this->view = $this->template->view;
    }
  }

  /**
   * Assign template value with a template file
   */
  protected function template($var, $templateFile) {
    $this->initTemplate();
    $this->template->assign($var, $templateFile);
  }

  /**
   * Assign template value pair
   */
  protected function templateValue($var, $value) {
    $this->initTemplate();
    $this->template->assignValue($var, $value);
  }

  /**
   * Assign multiple template values
   */
  protected function templateValues($pairs = array()) {
    $this->initTemplate();
    if (is_array($pairs)) {
      foreach($pairs AS $var => $value){
        $this->templateValue($var, $value);
      }
    }
  }

  /**
   * Render the template
   */
  protected function show($templateFile) {
    $this->initTemplate();
    $this->template->show($templateFile);
  }

  //Section service container
  private $serviceContainer = array();

  protected function registerService($serviceName, $servicePath) {
    if(isset($this->serviceContainer[$serviceName])) {
      return;
    }
    $this->serviceContainer[$serviceName] = $servicePath;
  }

  public function __get($serviceName) {
    if(isset($this->$serviceName)) {
      return $this->$serviceName;
    }
    if(!isset($this->serviceContainer[$serviceName]) || empty($this->serviceContainer[$serviceName])) {
      return null;
    }

    $type = gettype($this->serviceContainer[$serviceName]);
    if($type == "object") {
      return $this->serviceContainer[$serviceName];
    } else if($type == "string") {
      $service = $this->serviceContainer[$serviceName];
      $this->serviceContainer[$serviceName] = new $service;
      return $this->serviceContainer[$serviceName];
    } else {
      return null;
    }
  }

  //Section transacation
  private $transacationServiceName;

  protected function addTransacationService($serviceName) {
    $this->transacationServiceName = $serviceName;
  }

  private function getTransactionService() {
    $transacationServiceName = $this->transacationServiceName;
    $type = getType($this->$transacationServiceName);
    if (empty($transacationServiceName) || $type != "object") {
      return null;
    }
    return $this->$transacationServiceName;
  }

  public function begin() {
    $transacationService = $this->getTransactionService();
    if (empty($transacationService)) {
      return;
    }
    $transacationService->beginGlobal();
  }

  public function commit() {
    $transacationService = $this->getTransactionService();
    if (empty($transacationService)) {
      return;
    }
    $transacationService->commitGlobal();
  }

  public function rollback() {
    $transacationService = $this->getTransactionService();
    if (empty($transacationService)) {
      return;
    }
    $transacationService->rollBackGlobal();
  }

}
