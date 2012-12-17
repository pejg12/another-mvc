<?php
/**
* Holding a instance of CAmvc to enable use of $this in subclasses.
*
* @package AnotherMVCCore
*/
class CObject {

   public $amvc;
   public $config;
   public $request;
   public $data;
   public $db;
   public $views;
   public $session;
   public $user;

   /**
    * Constructor
    */
   protected function __construct($amvc=null) {
    if(!$amvc) {
      $amvc = CAmvc::Instance();
    }
    $this->amvc     = &$amvc;
    $this->config   = &$amvc->config;
    $this->request  = &$amvc->request;
    $this->data     = &$amvc->data;
    $this->db       = &$amvc->db;
    $this->views    = &$amvc->views;
    $this->session  = &$amvc->session;
    $this->user     = &$amvc->user;
  }


  /**
   * Wrapper for same method in CAmvc.
   */
  protected function RedirectTo($urlOrController=null, $method=null, $arguments=null) {
    $this->amvc->RedirectTo($urlOrController, $method, $arguments);
  }


  /**
   * Wrapper for same method in CAmvc.
   */
  protected function RedirectToController($method=null, $arguments=null) {
    $this->amvc->RedirectToController($method, $arguments);
  }


  /**
   * Wrapper for same method in CAmvc.
   */
  protected function RedirectToControllerMethod($controller=null, $method=null, $arguments=null) {
    $this->amvc->RedirectToControllerMethod($controller, $method, $arguments);
  }


  /**
   * Wrapper for same method in CAmvc.
   */
  protected function AddMessage($type, $message, $alternative=null) {
    return $this->amvc->AddMessage($type, $message, $alternative);
  }


  /**
   * Wrapper for same method in CAmvc.
   */
  protected function CreateUrl($urlOrController=null, $method=null, $arguments=null) {
    return $this->amvc->CreateUrl($urlOrController, $method, $arguments);
  }

}
