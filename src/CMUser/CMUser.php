<?php
/**
* A model for an authenticated user.
*
* @package AnotherMVCCore
*/
class CMUser extends CObject implements IHasSQL {


  /**
    * Constructor
    */
  public function __construct() {
    parent::__construct();
  }


  /**
    * Implementing interface IHasSQL. Encapsulate all SQL used by this class.
    *
    * @param string $key the string that is the key of the wanted SQL-entry in the array.
    */
  public static function SQL($key=null) {
    $tableprefix = "mvckm4_";
    $queries = array(
      'drop table user'    => "DROP TABLE IF EXISTS {$tableprefix}User;",
      'create table user'  => "CREATE TABLE IF NOT EXISTS {$tableprefix}User (
        id INTEGER PRIMARY KEY, 
        acronym TEXT KEY, 
        name TEXT, 
        email TEXT, 
        password TEXT, 
        created DATETIME default (datetime('now'))
      );",
      'insert into user'   => "INSERT INTO {$tableprefix}User (acronym,name,email,password) VALUES (?,?,?,?);",
      'check user password' => "SELECT * FROM {$tableprefix}User WHERE password=? AND (acronym=? OR email=?);",
      );
    if(!isset($queries[$key])) {
      throw new Exception("No such SQL query, key '$key' was not found.");
    }
    return $queries[$key];
  }


  /**
    * Init the database and create appropriate tables.
    */
  public function Init() {
    try {
      $this->db->ExecuteQuery(self::SQL('drop table user'));
      $this->db->ExecuteQuery(self::SQL('create table user'));
      $this->db->ExecuteQuery(self::SQL('insert into user'), array('root', 'The Administrator', 'root@dbwebb.se', 'root'));
      $this->session->AddMessage('success', 'Successfully created the database tables and created a default admin user as root:root.');
    } catch(Exception$e) {
      die("$e<br/>Failed to open database: " . $this->config['database'][0]['dsn']);
    }
  }
  

  /**
    * Login by autenticate the user and password. Store user information in session if success.
    *
    * @param string $acronymOrEmail the emailadress or user acronym.
    * @param string $password the password that should match the acronym or emailadress.
    * @returns booelan true if match else false.
    */
  public function Login($acronymOrEmail, $password) {
    $user = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('check user password'), array($password, $acronymOrEmail, $acronymOrEmail));
    $user = (isset($user[0])) ? $user[0] : null;
    unset($user['password']);
    if($user) {
      $this->session->SetAuthenticatedUser($user);
      $this->session->AddMessage('success', "Welcome '{$user['name']}'.");
    } else {
      $this->session->AddMessage('error', "Could not login, user does not exists or password did not match.");
    }
    return ($user != null);
  }
  

  /**
    * Logout.
    */
  public function Logout() {
    $this->session->UnsetAuthenticatedUser();
    $this->session->AddMessage('success', "You have logged out.");
  }
  

  /**
    * Does the session contain an authenticated user?
    *
    * @returns boolen true or false.
    */
  public function IsAuthenticated() {
    return ($this->session->GetAuthenticatedUser() != false);
  }
  
  
  /**
    * Get profile information on user.
    *
    * @returns array with user profile or null if anonymous user.
    */
  public function GetUserProfile() {
    return $this->session->GetAuthenticatedUser();
  }
  
  
}