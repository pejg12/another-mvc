<?php
/**
* A user controller  to manage login and view edit the user profile.
*
* @package AnotherMVCCore
*/
class CCUser extends CObject implements IController {


  /**
    * Constructor
    */
  public function __construct() {
    parent::__construct();
  }


  /**
    * Show profile information of the user.
    */
  public function Index() {
    $this->views->SetTitle('User Controller');
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
      'is_authenticated'=>$this->user['isAuthenticated'],
      'user'=>$this->user,
    ));
  }
  

  /**
   * View and edit user profile.
   */
  public function Profile() {
    $form = new CFormUserProfile($this, $this->user);
    $form->CheckIfSubmitted();

    $this->views->SetTitle('User Profile')
                ->AddInclude(__DIR__ . '/profile.tpl.php', array(
                  'is_authenticated'=>$this->user['isAuthenticated'],
                  'user'=>$this->user,
                  'profile_form'=>$form->GetHTML(),
                ));
  }


  /**
   * Change the password.
   */
  public function DoChangePassword($form) {
    if( $form['password']['value'] != $form['password1']['value'] ) {
      $this->AddMessage('error', 'Passwords do not match.');
    } elseif( empty($form['password']['value']) OR empty($form['password1']['value']) ) {
      $this->AddMessage('error', 'Password is empty.');
    } else {
      $ret = $this->user->ChangePassword($form['password']['value']);
      $this->AddMessage($ret, 'Saved new password.', 'Failed updating password.');
    }
    $this->RedirectToController('profile');
  }


  /**
   * Save updates to profile information.
   */
  public function DoProfileSave($form) {
    $this->user['name'] = $form['name']['value'];
    $this->user['email'] = $form['email']['value'];
    $ret = $this->user->Save();
    $this->AddMessage($ret, 'Saved profile.', 'Failed saving profile.');
    $this->RedirectToController('profile');
  }


  /**
    * Authenticate and login a user.
    */
  public function Login() {
    $form = new CFormUserLogin($this);
    $form->CheckIfSubmitted();

    $this->views->SetTitle('Log in');
    $this->views->AddInclude(__DIR__ . '/login.tpl.php', array('login_form'=>$form->GetHTML()));
  }


  /**
   * Perform a login of the user as callback on a submitted form.
   */
  public function DoLogin($form) {
    if($this->user->Login($form['acronym']['value'], $form['password']['value'])) {
      $this->AddMessage('success', "Welcome {$this->user['name']}.");
      $this->RedirectToController('profile');
    } else {
      $this->AddMessage('error', "Failed to login, user does not exist or passwords do not match.");
      $this->RedirectToController('login');
    }
  }


  /**
    * Logout a user.
    */
  public function Logout() {
    $this->user->Logout();
    $this->RedirectToController();
  }
  

  /**
    * Init the user database.
    */
  public function Init() {
    $this->user->Init();
    $this->RedirectToController();
  }
  

} 