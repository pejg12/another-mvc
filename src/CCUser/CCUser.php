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
    if($form->Check() === false) {
      $this->AddMessage('error', 'Some fields did not validate and the form could not be processed.');
      $this->RedirectToController('login');
    }

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
    if($form->Check() === false) {
      $this->AddMessage('error', 'You must fill in acronym and password.');
      $this->RedirectToController('login');
    }

    $this->views->SetTitle('Log in')
                ->AddInclude(__DIR__ . '/login.tpl.php', array(
                  'login_form' => $form,
                  'allow_create_user' => CAmvc::Instance()->config['create_new_users'],
                  'create_user_url' => $this->request->CreateUrl('user', 'create')
                ));
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
   * Create a new user.
   */
  public function Create() {
    $form = new CFormUserCreate($this);
    if($form->Check() === false) {
      $this->AddMessage('error', 'You must include all the values.');
      $this->RedirectToController('Create');
    }
    $this->views->SetTitle('Create user')
                ->AddInclude(__DIR__ . '/create.tpl.php', array('form' => $form->GetHTML()));
  }


  /**
   * Perform a creation of a user as callback on a submitted form.
   *
   * @param $form CForm the form that was submitted
   */
  public function DoCreate($form) {
    if($form['password']['value'] != $form['password1']['value']) {
      $this->AddMessage('error', 'Passwords do not match.');
      $this->RedirectToController('create');
    } else if(empty($form['password']['value']) OR empty($form['password1']['value'])) {
      $this->AddMessage('error', 'Password is empty.');
      $this->RedirectToController('create');
    } else if($this->user->Create($form['acronym']['value'],
                           $form['password']['value'],
                           $form['name']['value'],
                           $form['email']['value']
                           )) {
      $this->AddMessage('success', "Welcome {$this->user['name']}. Your have successfully created a new account.");
      $this->user->Login($form['acronym']['value'], $form['password']['value']);
      $this->RedirectToController('profile');
    } else {
      $this->AddMessage('error', "Failed to create an account.");
      $this->RedirectToController('create');
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

} // end class
