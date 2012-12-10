<?php
/**
* A guestbook controller as an example to show off some basic controller and model-stuff.
*
* @package AnotherMVCCore
*/
class CCGuestbook extends CObject implements IController {

  private $model;


  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
    $this->model = new CMGuestbook();
  }
 

  /**
   * Implementing interface IController. All controllers must have an index action.
   * Show a standard frontpage for the guestbook.
   */
  public function Index() {
    $this->views->SetTitle('Another MVC Guestbook Example');
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
      'entries'    => $this->model->ReadAll(),
      'formAction' => $this->request->CreateUrl('', 'handler'),
    ));
  }


  /**
   * Handle posts from the form and take appropriate action.
   */
  public function Handler() {
    if(isset($_POST['doAdd'])) {
      $this->model->Add(strip_tags($_POST['newEntry']));
    }
    elseif(isset($_POST['doClear'])) {
      $this->model->DeleteAll();
    }           
    elseif(isset($_POST['doCreate'])) {
      $this->model->Init();
    }
    $this->RedirectTo($this->request->CreateUrl($this->request->controller));
  }

}