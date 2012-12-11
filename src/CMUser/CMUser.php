<?php
/**
* A model for an authenticated user.
*
* @package AnotherMVCCore
*/
class CMUser extends CObject implements IHasSQL, ArrayAccess {


  /**
   * Properties
   */
  public $profile = array();


  /**
    * Constructor
    */
  public function __construct($amvc=null) {
    parent::__construct($amvc);
    $profile = $this->session->GetAuthenticatedUser();
    $this->profile = (is_null($profile) ? array() : $profile);
    $this['isAuthenticated'] = (is_null($profile) ? false : true);
  }


  /**
   * Implementing ArrayAccess for $this->profile
   */
  public function offsetSet($offset, $value) { if (is_null($offset)) { $this->profile[] = $value; } else { $this->profile[$offset] = $value; }}
  public function offsetExists($offset) { return isset($this->profile[$offset]); }
  public function offsetUnset($offset) { unset($this->profile[$offset]); }
  public function offsetGet($offset) { return isset($this->profile[$offset]) ? $this->profile[$offset] : null; }


  /**
    * Implementing interface IHasSQL. Encapsulate all SQL used by this class.
    *
    * @param string $key the string that is the key of the wanted SQL-entry in the array.
    */
  public static function SQL($key=null) {
    $tableprefix = "mvckm4_";
    $queries = array(
      // drop tables
      'drop table user'         => "DROP TABLE IF EXISTS {$tableprefix}User;",
      'drop table group'        => "DROP TABLE IF EXISTS {$tableprefix}Groups;",
      'drop table user2group'   => "DROP TABLE IF EXISTS {$tableprefix}User2Groups;",
      // create tables
      'create table user'       => "CREATE TABLE IF NOT EXISTS {$tableprefix}User (
        id INTEGER PRIMARY KEY, 
        acronym TEXT KEY, 
        name TEXT, 
        email TEXT, 
        algorithm TEXT, 
        salt TEXT,
        password TEXT, 
        created DATETIME default (datetime('now')), 
        updated DATETIME default NULL
      );",
      'create table group'      => "CREATE TABLE IF NOT EXISTS {$tableprefix}Groups (
        id INTEGER PRIMARY KEY, 
        acronym TEXT KEY, 
        name TEXT, 
        created DATETIME default (datetime('now')), 
        updated DATETIME default NULL
      );",
      'create table user2group' => "CREATE TABLE IF NOT EXISTS {$tableprefix}User2Groups (
        idUser INTEGER, 
        idGroups INTEGER, 
        created DATETIME default (datetime('now')), 
        PRIMARY KEY(idUser, idGroups)
      );",
      // insert queries
      'insert into user'        => "INSERT INTO {$tableprefix}User (acronym,name,email,algorithm,salt,password) VALUES (?,?,?,?,?,?);",
      'insert into group'       => "INSERT INTO {$tableprefix}Groups (acronym,name) VALUES (?,?);",
      'insert into user2group'  => "INSERT INTO {$tableprefix}User2Groups (idUser,idGroups) VALUES (?,?);",
      // select queries
      'get user'                => "SELECT * FROM {$tableprefix}User WHERE (acronym=? OR email=?);",
      'get group memberships'   => "SELECT * FROM {$tableprefix}Groups AS g INNER JOIN {$tableprefix}User2Groups AS ug ON g.id=ug.idGroups WHERE ug.idUser=?;",
      // update queries
      'update profile'          => "UPDATE {$tableprefix}User SET name=?, email=?, updated=datetime('now') WHERE id=?;",
      'update password'         => "UPDATE {$tableprefix}User SET password=?, updated=datetime('now') WHERE id=?;",
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
      // drop the old tables
      $this->db->ExecuteQuery(self::SQL('drop table user'));
      $this->db->ExecuteQuery(self::SQL('drop table group'));
      $this->db->ExecuteQuery(self::SQL('drop table user2group'));

      // create new tables
      $this->db->ExecuteQuery(self::SQL('create table user'));
      $this->db->ExecuteQuery(self::SQL('create table group'));
      $this->db->ExecuteQuery(self::SQL('create table user2group'));

      // create initial users;
      $password = $this->CreatePassword('root');
      $this->db->ExecuteQuery(self::SQL('insert into user'), array(
        'root', 
        'The Administrator', 
        'root@dbwebb.se', 
        $password['algorithm'], 
        $password['salt'], 
        $password['password']
      ));
      $idRootUser = $this->db->LastInsertId();;
      $password = $this->CreatePassword('doe');
      $this->db->ExecuteQuery(self::SQL('insert into user'), array(
        'doe', 
        'John/Jane Doe', 
        'doe@dbwebb.se', 
        $password['algorithm'], 
        $password['salt'], 
        $password['password']
      ));
      $idDoeUser = $this->db->LastInsertId();

      // create initial groups
      $this->db->ExecuteQuery(self::SQL('insert into group'), array('admin', 'The Administrator Group'));
      $idAdminGroup = $this->db->LastInsertId();
      $this->db->ExecuteQuery(self::SQL('insert into group'), array('user', 'The User Group'));
      $idUserGroup = $this->db->LastInsertId();

      // link initial users to groups
      $this->db->ExecuteQuery(self::SQL('insert into user2group'), array($idRootUser, $idAdminGroup));
      $this->db->ExecuteQuery(self::SQL('insert into user2group'), array($idRootUser, $idUserGroup));
      $this->db->ExecuteQuery(self::SQL('insert into user2group'), array($idDoeUser,  $idUserGroup));

      $this->session->AddMessage('success', 'Successfully created the database tables and created a default admin user as root:root and an ordinary user as doe:doe.');
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
    $user = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('get user'), array($acronymOrEmail, $acronymOrEmail));
    $user = (isset($user[0])) ? $user[0] : null;
    if(!$user) {
      return false;
    } else if(!$this->CheckPassword($password, $user['salt'], $user['password'])) {
      return false;
    }
    unset($user['algorithm']);
    unset($user['salt']);
    unset($user['password']);
    if($user) {
      $user['isAuthenticated'] = true;
      $user['groups'] = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('get group memberships'), array($user['id']));
      foreach($user['groups'] as $val) {
        if($val['id'] == 1) {
          $user['hasRoleAdmin'] = true;
        }
        if($val['id'] == 2) {
          $user['hasRoleUser'] = true;
        }
      }
      $this->profile = $user;
      $this->session->SetAuthenticatedUser($this->profile);
    }
    return ($user != null);
  }


  /**
    * Logout.
    */
  public function Logout() {
    $this->session->UnsetAuthenticatedUser();
    $this->profile = array();
    $this->AddMessage('success', "You have logged out.");
  }


  /**
   * Save user profile to database and update user profile in session.
   *
   * @returns boolean true if success else false.
   */
  public function Save() {
    $this->db->ExecuteQuery(self::SQL('update profile'), array($this['name'], $this['email'], $this['id']));
    $this->session->SetAuthenticatedUser($this->profile);
    return ($this->db->RowCount() === 1);
  }


  /**
   * Create password.
   *
   * @param $plain string the password plain text to use as base.
   * @param $salt boolean should  we use salt or not when creating the password? default is true.
   * @returns array with 'salt' and 'password'.
   */
  public function CreatePassword($plain, $salt=true) {
    if($salt) {
      $salt = md5(microtime());
      $password = md5($salt . $plain);
    } else {
      $salt = null;
      $password = md5($plain);
    }
    return array('salt'=>$salt, 'password'=>$password);
  }


  /**
   * Check if password matches.
   *
   * @param $plain string the password plain text to use as base.
   * @param $salt string the user salted string to use to hash the password.
   * @param $password string the hashed user password that should match.
   * @returns boolean true if match, else false.
   */
  public function CheckPassword($plain, $salt=null, $password) {
    if($salt) {
      return $password === md5($salt . $plain);
    } else {
      return $password === md5($plain);
    }
  }


  /**
   * Change user password.
   *
   * @param $password string the new password
   * @returns boolean true if success else false.
   */
  public function ChangePassword($password) {
    $this->db->ExecuteQuery(self::SQL('update password'), array($password, $this['id']));
    return ($this->db->RowCount() === 1);
  }

}