<?php
/**
* A container to hold a bunch of views.
*
* @package AnotherMVCCore
*/
class CViewContainer {

  /**
  * Members
  */
  private $data = array();
  private $views = array();


  /**
  * Constructor
  */
  public function __construct() { ; }


  /**
  * Getters.
  */
  public function GetData() { return $this->data; }


  /**
  * Set the title of the page.
  *
  * @param $value string to be set as title.
  */
  public function SetTitle($value) {
    $this->SetVariable('title', $value);
    return $this;
  }


  /**
  * Set any variable that should be available for the theme engine.
  *
  * @param $value string to be set as title.
  */
  public function SetVariable($key, $value) {
    $this->data[$key] = $value;
    return $this;
  }


  /**
  * Add a view as file to be included and optional variables.
  *
  * @param $file string path to the file to be included.
  * @param vars array containing the variables that should be avilable for the included file.
  */
  public function AddInclude($file, $variables=array()) {
    // variables must be saved together with $this->data so that we can pass along all the data
    foreach($variables AS $key => $value)
    {
      $this->SetVariable($key, $value);
    }
    $this->views[] = array('type' => 'include', 'file' => $file, 'variables' => $this->data);
    return $this;
  }


  /**
  * Render all views according to their type.
  */
  public function Render() {
    foreach($this->views as $view) {
      switch($view['type']) {
        case 'include':
          extract($view['variables']);
          include($view['file']);
          break;
      }
    }
  }

}