<?php
/**
* A guestbook controller as an example to show off some basic controller and model-stuff.
*
* @package AnotherMVCCore
*/
class CCGuestbook extends CObject implements IController, IHasSQL {

  private $pageTitle  = 'Another MVC Guestbook Example';
  private $pageHeader = '<h1>Guestbook Example</h1><p>Showing off how to implement a guestbook in Another MVC.</p>';
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
    $formAction = $this->request->CreateUrl('guestbook/handler');
    $this->pageForm = <<<EOD
      <form action='{$formAction}' method='post'>
        <p>
          <label>Message: <br/>
          <textarea name='newEntry'></textarea></label>
        </p>
        <p>
          <input type='submit' name='doAdd' value='Add message' />
          <input type='submit' name='doClear' value='Clear all messages' />
          <input type='submit' name='doCreate' value='Init database' />
        </p>
      </form>

EOD;
    $this->data['title'] = $this->pageTitle;
    $this->data['main']  = $this->pageHeader . $this->pageForm;
   
    foreach($this->ReadAllFromDatabase() AS $val) {
      $this->data['main'] .= "<div style='background-color:#f6f6f6;border:1px solid #ccc;margin-bottom:1em;padding:1em;'><p>At: {$val['created']}</p><p>{$val['entry']}</p></div>\n";
    }
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