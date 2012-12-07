<?php
/**
* Holding a instance of CAmvc to enable use of $this in subclasses.
*
* @package AnotherMVCCore
*/
class CObject {

   public $config;
   public $request;
   public $data;
   public $db;
   public $views;

   /**
    * Constructor
    */
   protected function __construct() {
    $amvc = CAmvc::Instance();
    $this->config   = &$amvc->config;
    $this->request  = &$amvc->request;
    $this->data     = &$amvc->data;
    $this->db       = &$amvc->db;
    $this->views    = &$amvc->views;
  }

}
