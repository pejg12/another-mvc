<?php
/**
* A form to manage content.
*
* @package AnotherMVCCore
*/
class CFormContent extends CForm {

  /**
    * Properties
    */
  private $content;

  /**
    * Constructor
    */
  public function __construct($content) {
    parent::__construct();
    $this->content = $content;
    $save = isset($content['id']) ? 'save' : 'create';
    $this->AddElement(new CFormElementHidden('id', array('value'=>$content['id'])))
         ->AddElement(new CFormElementText('title', array('value'=>$content['title'])))
         ->AddElement(new CFormElementText('slug', array('value'=>$content['slug'])))
         ->AddElement(new CFormElementTextarea('data', array('label'=>'Content:', 'value'=>$content['data'])))
         ->AddElement(new CFormElementText('type', array('value'=>$content['type'])))
         ->AddElement(new CFormElementText('filter', array('value'=>$content['filter'])))
         ->AddElement(new CFormElementSubmit($save, array('callback'=>array($this, 'DoSave'), 'callback-args'=>array($content))));

    $this->SetValidation('title', array('not_empty'))
         ->SetValidation('slug', array('not_empty'));
  }


  /**
    * Callback to save the form content to database.
    */
  public function DoSave($form, $content) {
    $content['id']     = $form['id']['value'];
    $content['title']  = $form['title']['value'];
    $content['slug']   = $form['slug']['value'];
    $content['data']   = $form['data']['value'];
    $content['type']   = $form['type']['value'];
    $content['filter'] = $form['filter']['value'];
    return $content->Save();
  }

} // end class
