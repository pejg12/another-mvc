<?php
/**
 * A form to login the user profile.
 *
 * @package AnotherMVCCore
 */
class CFormUserLogin extends CForm {

  /**
   * Constructor
   */
  public function __construct($object) {
    parent::__construct();
    $this->AddElement(new CFormElementText('acronym', array('required'=>true)))
         ->AddElement(new CFormElementPassword('password', array('required'=>true)))
         ->AddElement(new CFormElementSubmit('login', array('class'=>'btn', 'callback'=>array($object, 'DoLogin'))));

    $this->SetValidation('acronym', array('not_empty'))
         ->SetValidation('password', array('not_empty'));
  }

} // end class
