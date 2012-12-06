<?php
/**
* A guestbook controller as an example to show off some basic controller and model-stuff.
*
* @package AnotherMVCCore
*/
class CCGuestbook extends CObject implements IController {

  private $pageTitle = 'Another MVC Guestbook Example';
  private $pageHeader = '<h1>Guestbook Example</h1><p>Showing off how to implement a guestbook in Another MVC.</p>';
  private $pageForm = <<<EOD
    <form>
      <p>
        <label>Comment: <br/>
        <textarea name='newEntry'></textarea></label>
      </p>
      <p>
        <input type='submit' name='doIt' value='Add comment' />
      </p>
    </form>

EOD;
 

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
    $this->data['title'] = $this->pageTitle;
    $this->data['main'] = $this->pageHeader . $this->pageForm;
  }
 
}