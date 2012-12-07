<?php
/**
* A guestbook controller as an example to show off some basic controller and model-stuff.
*
* @package AnotherMVCCore
*/
class CCGuestbook extends CObject implements IController, IHasSQL {

  private $pageTitle  = 'Another MVC Guestbook Example';
  private $pageHeader = 'Showing off how to implement a guestbook in Another MVC.';
  private $pageForm; 

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
    $this->views->SetTitle($this->pageTitle);
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
      'entries'=>$this->ReadAllFromDatabase(),
      'formAction'=>$this->request->CreateUrl('guestbook/handler'),
      'header'=>$this->pageHeader
    ));
  }

   /**
    * Implementing interface IHasSQL. Encapsulate all SQL used by this class.
    *
    * @param string $key the string that is the key of the wanted SQL-entry in the array.
    */
  public static function SQL($key=null) {
     $table_gb = 'mvckm3_Guestbook';
     $queries = array(
        'create table guestbook'  => "
          CREATE TABLE IF NOT EXISTS {$table_gb} (
            id INTEGER PRIMARY KEY, 
            entry TEXT, 
            created DATETIME default (datetime('now'))
          );",
        'insert into guestbook'   => "INSERT INTO {$table_gb} (entry) VALUES (?);",
        'select * from guestbook' => "SELECT * FROM {$table_gb} ORDER BY created DESC;",
        'delete from guestbook'   => "DELETE FROM {$table_gb};",
     );
     if(!isset($queries[$key])) {
        throw new Exception("No such SQL query, key '$key' was not found.");
      }
      return $queries[$key];
   }

  /**
   * Read all entries from the database.
   */
  private function ReadAllFromDatabase() {
    try {
      return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * from guestbook'));
    } catch(Exception $e) {
      return array();
    }
  }

  /**
   * Handle posts from the form and take appropriate action.
   */
  public function Handler() {
    if(isset($_POST['doAdd'])) {
      $this->SaveNewToDatabase(strip_tags($_POST['newEntry']));
    }
    elseif(isset($_POST['doClear'])) {
      $this->DeleteAllFromDatabase();
    }           
    elseif(isset($_POST['doCreate'])) {
      $this->CreateTableInDatabase();
    }           
    header('Location: ' . $this->request->CreateUrl('guestbook'));
  }

  /**
   * Save a new entry to database.
   */
  private function SaveNewToDatabase($entry) {
    $this->db->ExecuteQuery(self::SQL('insert into guestbook'), array($entry));
    if($this->db->rowCount() != 1) {
      die('Failed to insert new guestbook item into database.');
    }
  }

  /**
   * Delete all entries from the database.
   */
  private function DeleteAllFromDatabase() {
    $this->db->ExecuteQuery(self::SQL('delete from guestbook'));
  }

  /**
    * Create a new database table.
    */
  private function CreateTableInDatabase() {
    try {
      $this->db->ExecuteQuery(self::SQL('create table guestbook'));
    } catch(Exception$e) {
      die("Failed to open database: " . $this->config['database'][0]['dsn'] . "</br>" . $e);
    }
  }

}