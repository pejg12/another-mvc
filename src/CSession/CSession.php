<?php
/**
* Wrapper for session, read and store values on session. Maintains flash values for one pageload.
*
* @package AnotherMVCCore
*/
class CSession {

  /**
    * Members
    */
  private $akey;
  private $data = array();
  private $flash = null;
    

  /**
    * Constructor
    */
  public function __construct($akey) {
    $this->akey = $akey;
  }


  /**
    * Set values
    */
  public function __set($akey, $value) {
    $this->data[$akey] = $value;
  }


  /**
    * Get values
    */
  public function __get($akey) {
    return isset($this->data[$akey]) ? $this->data[$akey] : null;
  }


  /**
    * Set flash values, to be remembered one page request
    */
  public function SetFlash($akey, $value) {
    $this->data['flash'][$akey] = $value;
  }


  /**
    * Get flash values, if any.
    */
  public function GetFlash($akey) {
    return isset($this->flash[$akey]) ? $this->flash[$akey] : null;
  }


  /**
    * Add message to be displayed to user on next pageload. Store in flash.
    *
    * @param $type string the type of message, for example: notice, info, success, warning, error.
    * @param $message string the message.
    */
  public function AddMessage($type, $message) {
    $this->data['flash']['messages'][] = array('type' => $type, 'message' => $message);
  }


  /**
    * Get messages, if any. Each message is composed of a key and value. Use the key for styling.
    *
    * @returns array of messages. Each array-item contains a key and value.
    */
  public function GetMessages() {
    return isset($this->flash['messages']) ? $this->flash['messages'] : null;
  }


  /**
    * Store values into session.
    */
  public function StoreInSession() {
    $_SESSION[$this->akey] = $this->data;
  }


  /**
    * Store values from this object into the session.
    */
  public function PopulateFromSession() {
    if(isset($_SESSION[$this->akey])) {
      $this->data = $_SESSION[$this->akey];
      if(isset($this->data['flash'])) {
        $this->flash = $this->data['flash'];
        unset($this->data['flash']);
      }
    }
  }

}