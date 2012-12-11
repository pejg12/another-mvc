<?php
/**
* A utility class to easy creating and handling of forms
*
* @package AnotherMVCCore
*/
class CForm {

  /**
    * Properties
    */
  public $form;     // array with settings for the form
  public $elements; // array with all form elements


  /**
    * Constructor
    */
  public function __construct($form=array(), $elements=array()) {
    $this->form = $form;
    $this->elements = $elements;
  }


  /**
    * Add a form element
    */
  public function AddElement($key, $element) {
    $this->elements[$key] = $element;
    $this->elements[$key]['name'] = $key;
  }


  /**
    * Return HTML for the form
    */
  public function GetHTML() {
    $id       = isset($this->form['id'])      ?     " id='{$this->form['id']}'"     : null;
    $class    = isset($this->form['class'])   ?  " class='{$this->form['class']}'"  : null;
    $name     = isset($this->form['name'])    ?   " name='{$this->form['name']}'"   : null;
    $action   = isset($this->form['action'])  ? " action='{$this->form['action']}'" : null;
    $method   = " method='post'";
    $elements = $this->GetHTMLForElements();
    $html     = <<<EOD
\n<form{$id}{$class}{$name}{$action}{$method}>
<fieldset>
{$elements}
</fieldset>
</form>
EOD;
    return $html;
  }


  /**
    * Return HTML for the elements
    */
  public function GetHTMLForElements() {
    $html = null;
    $i = 0;
    foreach($this->elements as $key => $val) {
      $defaultId = "form-input-" . $i++;
      $id = isset($val['id']) ? $val['id'] : $defaultId;
      $class = isset($val['class']) ? " class='{$val['class']}'" : null;
      $name = " name='" . (isset($val['name']) ? $val['name'] : $key) . "'";
      $label = isset($val['label']) ? ($val['label'] . (isset($val['mandatory']) && $val['mandatory'] ? "<span class='form-element-mandatory'> *</span>" : null)) : null;
      $autofocus = isset($val['autofocus']) && $val['autofocus'] ? " autofocus='autofocus'" : null;

      $type    = isset($val['type']) ? " type='{$val['type']}'" : null;
      $value    = isset($val['value']) ? " value='{$val['value']}'" : null;
      $html .= "<p><label for='$id'>$label</label><br><input id='$id'{$type}{$class}{$name}{$value}{$autofocus} /></p>\n";
    }
    return $html;
  }

}