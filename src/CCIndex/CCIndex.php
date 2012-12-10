<?php
/**
* Standard controller layout.
*
* @package AnotherMVCCore
*/
class CCIndex extends CObject implements IController {

  /**
    * Constructor
    */
  public function __construct() {
      parent::__construct();
  }

  /**
    * Implementing interface IController. All controllers must have an index action.
    */
  public function Index() {
    $this->views->SetTitle('The Index Controller');
    $this->views->AddInclude(__DIR__ . '/index.tpl.php');
  }

} 