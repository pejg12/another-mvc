<?php
/**
* A utility class to easy creating and handling of forms
*
* @package AnotherMVCCore
*/
class CForm implements ArrayAccess {

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
    * Implementing ArrayAccess for this->elements
    */
  public function offsetSet($offset, $value) { if (is_null($offset)) { $this->elements[] = $value; } else { $this->elements[$offset] = $value; }}
  public function offsetExists($offset) { return isset($this->elements[$offset]); }
  public function offsetUnset($offset) { unset($this->elements[$offset]); }
  public function offsetGet($offset) { return isset($this->elements[$offset]) ? $this->elements[$offset] : null; }


  /**
    * Add a form element
    */
  public function AddElement($element) {
    $this[$element['name']] = $element;
    return $this;
  }


  /**
    * Return HTML for the form
    */
  public function GetHTML($attributes=null) {
    if(is_array($attributes)) {
      $this->form = array_merge($this->form, $attributes);
    }
    $id       = isset($this->form['id'])      ?     " id='{$this->form['id']}'"     : null;
    $class    = isset($this->form['class'])   ?         " {$this->form['class']}"   : null;
    $name     = isset($this->form['name'])    ?   " name='{$this->form['name']}'"   : null;
    $action   = isset($this->form['action'])  ? " action='{$this->form['action']}'" : null;
    $method   = " method='post'";

    $form_open = "<form class='form-horizontal{$class}' {$id}{$name}{$action}{$method}>";

    if(
      ($attributes == 'form')
      OR (isset($attributes['start']) && $attributes['start'])
    ) {
      return $form_open;
    }

    $elements = $this->GetHTMLForElements();
    $html     = <<<EOD
\n{$form_open}
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
    foreach($this->elements as $element) {
      $html .= $element->GetHTML();
    }
    return $html;
  }


  /**
   * Get the value of a element
   */
  public function GetValue($key) {
    return (isset($_POST[$key])) ? $_POST[$key] : null;
  }


  /**
   * Set validation to a form element
   *
   * @param $element string the name of the form element to add validation rules to.
   * @param $rules array of validation rules.
   * @returns $this CForm
   */
  public function SetValidation($element, $rules) {
    $this[$element]['validation'] = $rules;
    return $this;
  }


  /**
   * Check if a form was submitted and perform validation and call callbacks.
   *
   * The form is stored in the session if validation or callback fails. The
   * page should then be redirected to the original form page, the form will
   * populate from the session and should be rendered again.
   *
   * @returns boolean true if submitted&validates and callbacks are successfull, false if not validate or callback fails, null if not submitted.
   */
  public function Check() {
    $validates = null;
    $callbackStatus = null;
    $values = array();
    if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
      unset($_SESSION['form-failed']);
      $validates = true;
      foreach($this->elements as $element) {
        if(isset($_POST[$element['name']])) {
          $values[$element['name']]['value'] = $element['value'] = $_POST[$element['name']];
          if(isset($element['validation'])) {
            $element['validation-pass'] = $element->Validate($element['validation']);
            if($element['validation-pass'] === false) {
              $values[$element['name']] = array('value'=>$element['value'], 'validation_messages'=>$element['validation_messages']);
              $validates = false;
            }
          }
          if(isset($element['callback']) && $validates) {
            if(isset($element['callback-args'])) {
              if(call_user_func_array($element['callback'], array_merge(array($this), $element['callback-args'])) === false) {
                $callbackStatus = false;
              }
            } else {
              if(call_user_func($element['callback'], $this) === false) {
                $callbackStatus = false;
              }
            }
          }
        }
      }
    } else if(isset($_SESSION['form-failed'])) {
      foreach($_SESSION['form-failed'] as $key => $val) {
        $this[$key]['value'] = $val['value'];
        if(isset($val['validation_messages'])) {
          $this[$key]['validation_messages'] = $val['validation_messages'];
          $this[$key]['validation-pass'] = false;
        }
      }
      unset($_SESSION['form-failed']);
    }
    if(
      ($validates === false)
      OR ($callbackStatus === false)
    ) {
      $_SESSION['form-failed'] = $values;
    }
    if($callbackStatus === false)
      return false;
    else 
      return $validates;
  }

} // end class


class CFormElement implements ArrayAccess {

  /**
   * Properties
   */
  public $attributes;
  public $characterEncoding;


  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    $this->attributes = $attributes;   
    $this['name'] = $name;
    if(is_callable('CAmvc::Instance()')) {
      $this->characterEncoding = CAmvc::Instance()->config['character_encoding'];
    } else {
      $this->characterEncoding = 'UTF-8';
    }
  }


  /**
   * Implementing ArrayAccess for this->attributes
   */
  public function offsetSet($offset, $value) { if (is_null($offset)) { $this->attributes[] = $value; } else { $this->attributes[$offset] = $value; }}
  public function offsetExists($offset) { return isset($this->attributes[$offset]); }
  public function offsetUnset($offset) { unset($this->attributes[$offset]); }
  public function offsetGet($offset) { return isset($this->attributes[$offset]) ? $this->attributes[$offset] : null; }


  /**
   * Get HTML code for a element.
   *
   * @returns HTML code for the element.
   */
  public function GetHTML() {
    $validates = ((isset($this['validation-pass']) AND ($this['validation-pass'] === false)) ? ' validation-failed' : null);
    $status    = ($validates ? ' error' : null);

    $id        = (isset($this['id']) ? $this['id'] : "form-element-{$this['name']}");
    $class     = (isset($this['class']) ? $this['class'] : null);
    $class     = ((isset($class) OR isset($validates)) ? " class='{$class}{$validates}'" : null);
    $name      = " name='{$this['name']}'";
    $label     = (isset($this['label']) ? ($this['label'] . ((isset($this['required']) && $this['required']) ? "<span class='form-element-required'>*</span>" : null)) : null);
    $autofocus = ((isset($this['autofocus']) && $this['autofocus']) ? " autofocus='autofocus'" : null);
    $readonly  = ((isset($this['readonly']) && $this['readonly']) ? " readonly='readonly'" : null);
    $type      = (isset($this['type']) ? " type='{$this['type']}'" : null);
    $onlyValue = isset($this['value']) ? htmlentities($this['value'], ENT_COMPAT, $this->characterEncoding) : null;
    $value     = isset($this['value']) ? " value='{$onlyValue}'" : null;

    $messages = null;
    if(isset($this['validation_messages'])) {
      $message = null;
      foreach($this['validation_messages'] as $val) {
        $message .= "{$val} ";
      }
      $messages = "<span class='help-inline'>{$message}</span>\n";
    }

    if($type && ($this['type'] == 'submit')) {
      $label = null;
      $input = "<input id='{$id}'{$type}{$class}{$name}{$value}{$autofocus}{$readonly} />";
    } else if($type && ($this['type'] == 'hidden')) {
      $label = null;
      $input = "<input id='$id'{$type}{$class}{$name}{$value} />";
    } else if($type && ($this['type'] == 'textarea')) {
      $input = "<textarea id='$id'{$type}{$class}{$name}{$autofocus}{$readonly}>{$onlyValue}</textarea>";
    } else {
      $input = "<input id='{$id}'{$type}{$class}{$name}{$value}{$autofocus}{$readonly} />";
    }

    if($label) {
      $label = "<label class='control-label' for='{$id}'>{$label}</label>\n";
    }

    return "<div class='control-group{$status}'>\n" . $label . "<div class='controls'>\n" . $input . "\n{$messages}</div>\n</div>\n";
  }


  /**
   * Use the element name as label if label is not set.
   */
  public function UseNameAsDefaultLabel() {
    if(!isset($this['label'])) {
      $this['label'] = ucfirst(strtolower(str_replace(array('-','_'), ' ', $this['name'])));
    }
  }


  /**
   * Use the element name as value if value is not set.
   */
  public function UseNameAsDefaultValue() {
    if(!isset($this['value'])) {
      $this['value'] = ucfirst(strtolower(str_replace(array('-','_'), ' ', $this['name'])));
    }
  }

  /**
   * Validate the form element value according to a set of rules.
   *
   * @param $rules array of validation rules.
   * returns boolean true if all rules pass, else false.
   */
  public function Validate($rules) {
    $tests = array(
      'fail' => array(
        'message' => 'Will always fail.',
        'test' => 'return false;',
      ),
      'pass' => array(
        'message' => 'Will always pass.',
        'test' => 'return true;',
      ),
      'not_empty' => array(
        'message' => 'This field is required.',
        'test' => 'return $value != "";',
      ),
    );
    $pass = true;
    $messages = array();
    $value = $this['value'];
    foreach($rules as $key => $val) {
      $rule = is_numeric($key) ? $val : $key;
      if(!isset($tests[$rule])) throw new Exception('Validation of form element failed, no such validation rule exists.');
      if(eval($tests[$rule]['test']) === false) {
        $messages[] = $tests[$rule]['message'];
        $pass = false;
      }
    }
    if(!empty($messages)) $this['validation_messages'] = $messages;
    return $pass;
  }

} // end class


class CFormElementText extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'text';
    $this->UseNameAsDefaultLabel();
  }

} // end class


class CFormElementTextarea extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'textarea';
    $this->UseNameAsDefaultLabel();
  }
} // end class


class CFormElementHidden extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'hidden';
  }
} // end class


class CFormElementPassword extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'password';
    $this->UseNameAsDefaultLabel();
  }

} // end class


class CFormElementSubmit extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'submit';
    $this->UseNameAsDefaultValue();
  }

} // end class
