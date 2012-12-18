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
   * @param $region string the theme region, uses string 'default' as default region.
   * @returns $this.
   */
  public function AddInclude($file, $variables=array(), $region='default') {
    // variables must be saved together with $this->data so that we can pass along all the data
    if(is_array($variables))
    {
      foreach($variables AS $key => $value)
      {
        $this->SetVariable($key, $value);
      }
    }
    $this->views[$region][] = array('type' => 'include', 'file' => $file, 'variables' => $this->data);
    return $this;
  }


  /**
   * Render all views according to their type.
   *
   * @param $region string the region to render views for.
   */
  public function Render($region='default') {
    if(!isset($this->views[$region])) return;
    foreach($this->views[$region] as $view) {
      switch($view['type']) {
        case 'include':
          extract($view['variables']);
          include($view['file']);
          break;
        case 'string':
          extract($view['variables']);
          echo $view['string'];
          break;
      }
    }
  }


  /**
   * Add text and optional variables.
   *
   * @param $string string content to be displayed.
   * @param $vars array containing the variables that should be avilable for the included file.
   * @param $region string the theme region, uses string 'default' as default region.
   * @returns $this.
   */
  public function AddString($string, $variables=array(), $region='default') {
    // variables must be saved together with $this->data so that we can pass along all the data
    if(is_array($variables))
    {
      foreach($variables AS $key => $value)
      {
        $this->SetVariable($key, $value);
      }
    }
    $this->views[$region][] = array('type' => 'string', 'string' => $string, 'variables' => $this->data);
    return $this;
  }


  /**
   * Add inline style.
   *
   * @param $value string to be added as inline style.
   * @returns $this.
   */
  public function AddStyle($value) {
    if(isset($this->data['inline_style'])) {
      $this->data['inline_style'] .= $value;
    } else {
      $this->data['inline_style'] = $value;
    }
    return $this;
  }


  /**
   * Check if views for a specific region actually exists.
   *
   * @param $region string/array the theme region(s).
   * @returns boolean true if region has views, else false.
   */
  public function RegionHasView($region) {
    if(is_array($region)) {
      foreach($region as $val) {
        if(isset($this->views[$val])) {
          return true;
        }
      }
      return false;
    } else {
      return(isset($this->views[$region]));
    }
  }

}
