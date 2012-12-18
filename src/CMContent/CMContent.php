<?php
/**
 * A model for content stored in database.
 *
 * @package AnotherMVCCore
 */
class CMContent extends CObject implements IHasSQL, IModule, ArrayAccess {

  /**
   * Properties
   */
  public $data;


  /**
   * Constructor
   */
  public function __construct($id=null) {
    parent::__construct();
    if($id) {
      $this->LoadById($id);
    } else {
      $this->data = array();
    }
  }


  /**
   * Implementing ArrayAccess for $this->data
   */
  public function offsetSet($offset, $value) { if (is_null($offset)) { $this->data[] = $value; } else { $this->data[$offset] = $value; }}
  public function offsetExists($offset) { return isset($this->data[$offset]); }
  public function offsetUnset($offset) { unset($this->data[$offset]); }
  public function offsetGet($offset) { return isset($this->data[$offset]) ? $this->data[$offset] : null; }


  /**
   * Implementing interface IHasSQL. Encapsulate all SQL used by this class.
   *
   * @param string $key the string that is the key of the wanted SQL-entry in the array.
   */
  public static function SQL($key=null, $args=null) {
    $order_order  = isset($args['order-order']) ? $args['order-order'] : 'ASC';
    $order_by     = isset($args['order-by'])    ? $args['order-by'] : 'id';

    $amvc = CAmvc::Instance();
    $tableprefix = $amvc->config['km'] . "_";
    $queries = array(
      'drop table content'      => "DROP TABLE IF EXISTS {$tableprefix}Content;",
      'create table content'    => "CREATE TABLE IF NOT EXISTS {$tableprefix}Content (
        id INTEGER PRIMARY KEY,
        slug TEXT KEY,
        type TEXT,
        title TEXT,
        data TEXT,
        filter TEXT,
        idUser INT,
        created DATETIME default (datetime('now')),
        updated DATETIME default NULL,
        deleted DATETIME default NULL,
        FOREIGN KEY(idUser) REFERENCES User(id)
      );",
      'insert content'          => "INSERT INTO {$tableprefix}Content (slug,type,title,data,filter,idUser) VALUES (?,?,?,?,?,?);",
      'select * by id'          => "SELECT c.*, u.acronym as owner FROM {$tableprefix}Content AS c INNER JOIN {$tableprefix}User as u ON c.idUser=u.id WHERE c.id=? AND deleted IS NULL;",
      'select * by slug'        => "SELECT c.*, u.acronym as owner FROM {$tableprefix}Content AS c INNER JOIN {$tableprefix}User as u ON c.idUser=u.id WHERE c.slug=? AND deleted IS NULL;",
      'select * by type'        => "SELECT c.*, u.acronym as owner FROM {$tableprefix}Content AS c INNER JOIN {$tableprefix}User as u ON c.idUser=u.id WHERE type=? AND deleted IS NULL ORDER BY {$order_by} {$order_order};",
      'select *'                => "SELECT c.*, u.acronym as owner FROM {$tableprefix}Content AS c INNER JOIN {$tableprefix}User as u ON c.idUser=u.id WHERE deleted IS NULL;",
      'update content'          => "UPDATE {$tableprefix}Content SET slug=?, type=?, title=?, data=?, filter=?, updated=datetime('now') WHERE id=?;",
      'update content as deleted' => "UPDATE {$tableprefix}Content SET deleted=datetime('now') WHERE id=?;",
      );
    if(!isset($queries[$key])) {
      throw new Exception("No such SQL query, key '$key' was not found.");
    }
    return $queries[$key];
  }


  /**
   * Init the database and create appropriate tables.
   */
  public function Manage($action=null) {
    switch($action) {
      case 'install':
        try {
          if(!$this->user['id'])
          {
            $this->user['id'] = 1;
          }
          $this->db->ExecuteQuery(self::SQL('drop table content'));
          $this->db->ExecuteQuery(self::SQL('create table content'));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world', 'post', 'Hello World', "This is a demo post.\n\nThis is another row in this demo post.", 'plain', $this->user['id']));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world-again', 'post', 'Hello World Again', "This is another demo post.\n\nThis is another row in this demo post.", 'plain', $this->user['id']));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world-once-more', 'post', 'Hello World Once More', "This is one more demo post.\n\nThis is another row in this demo post.", 'plain', $this->user['id']));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('home', 'page', 'Home page', "This is a demo page, this could be your personal home-page.\n\nAnother MVC is a PHP-based MVC-inspired Content management Framework (based on Lydia), make your own version of Lydia at: http://dbwebb.se/lydia/tutorial.", 'plain', $this->user['id']));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('about', 'page', 'About page', "This is a demo page, this could be your personal about-page.\n\nAnother MVC is the product of a tutorial showing how to build MVC frameworks.", 'plain', $this->user['id']));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('download', 'page', 'Download page', "This is a demo page, this could be your personal download-page.\n\nYou can download your own copy of lydia from https://github.com/mosbth/lydia.", 'plain', $this->user['id']));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('bbcode', 'page', 'Page with BBCode', "This is a demo page with some BBCode-formatting.\n\n[b]Text in bold[/b] and [i]text in italic[/i] and [url=http://dbwebb.se]a link to dbwebb.se[/url]. You can also include images using bbcode, such as the lydia logo: [img]http://dbwebb.se/lydia/current/themes/core/logo_80x80.png[/img]", 'bbcode', $this->user['id']));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('mediawiki', 'page', 'Page with Mediawiki Syntax', "This is a demo page with some mediawiki formatting.\n\n'''Text in bold''' and ''text in italic'' and '''''text in italic bold'''''.\n\n----\nHere's [http://dbwebb.se a link to dbwebb.se].\n\n==Header==\nYou can also include images using mediawiki, such as the Lydia logo: [File:http://dbwebb.se/lydia/current/themes/core/logo_80x80.png]", 'mediawiki', $this->user['id']));
          $this->db->ExecuteQuery(self::SQL('insert content'), array('htmlpurify', 'page', 'Page with HTMLPurifier', "This is a demo page with some HTML code intended to run through <a href='http://htmlpurifier.org/'>HTMLPurify</a>. Edit the source and insert HTML code and see if it works.\n\n<b>Text in bold</b> and <i>text in italic</i> and <a href='http://dbwebb.se'>a link to dbwebb.se</a>. JavaScript, like this: <javascript>alert('hej');</javascript> should however be removed.", 'htmlpurify', $this->user['id']));
          return array('success', 'Successfully created the database tables and created a few default entries owned by you.');
        } catch(Exception$e) {
          die("$e<br/>Failed to open database: " . $this->config['database'][0]['dsn']);
        }
      break;

      default:
        throw new Exception('Unsupported action for this module.');
      break;
    }
  }


  /**
   * Save content. If it has a id, use it to update current entry or else insert new entry.
   *
   * @returns boolean true if success else false.
   */
  public function Save() {
    $msg = null;
    if($this['id']) {
      $this->db->ExecuteQuery(self::SQL('update content'), array($this['slug'], $this['type'], $this['title'], $this['data'], $this['filter'], $this['id']));
      $msg = 'updating';
    } else {
      $this->db->ExecuteQuery(self::SQL('insert content'), array($this['slug'], $this['type'], $this['title'], $this['data'], $this['filter'], $this->user['id']));
      $this['id'] = $this->db->LastInsertId();
      $msg = 'creating';
    }
    $rowcount = $this->db->RowCount();
    if($rowcount) {
      $this->AddMessage('success', "Successful with {$msg} content '" . htmlEnt($this['slug']) . "'.");
    } else {
      $this->AddMessage('error', "Failed with {$msg} content '" . htmlEnt($this['slug']) . "'.");
    }
    return $rowcount === 1;
  }


  /**
  * Delete content. Set its deletion date to enable trashbin functionality.
  *
  * @returns boolean true if success else false.
  */
  public function Delete() {
    if($this['id']) {
      $this->db->ExecuteQuery(self::SQL('update content as deleted'), array($this['id']));
    }
    $rowcount = $this->db->RowCount();
    if($rowcount) {
      $this->AddMessage('success', "Successfully set content '" . htmlEnt($this['slug']) . "' as deleted.");
    } else {
      $this->AddMessage('error', "Failed to set content '" . htmlEnt($this['slug']) . "' as deleted.");
    }
    return ($rowcount === 1);
  }


  /**
   * Load content by id.
   *
   * @param id integer the id of the content.
   * @returns boolean true if success else false.
   */
  public function LoadById($id) {
    $res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by id'), array($id));
    if(empty($res)) {
      $this->AddMessage('error', "Failed to load content with id '$id'.");
      return false;
    } else {
      $this->data = $res[0];
    }
    return true;
  }


  /**
   * List all content.
   *
   * @returns array with listing or null if empty.
   */
  public function ListAll($args=null) {
    try {
      if(isset($args) && isset($args['type'])) {
        return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by type', $args), array($args['type']));
      } else {
        return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select *', $args));
      }
    } catch(Exception $e) {
      echo $e;
      return null;
    }
  }


  /**
   * Filter content according to a filter.
   *
   * @param $data string of text to filter and format according its filter settings.
   * @returns string with the filtered data.
   */
  public static function Filter($data, $filter) {
    switch($filter) {
      /*case 'php': $data = nl2br(makeClickable(eval('?>'.$data))); break;
      case 'html': $data = nl2br(makeClickable($data)); break;*/
      case 'htmlpurify': $data = nl2br(CHTMLPurifier::Purify($data)); break;
      case 'bbcode': $data = nl2br(bbcode2html(htmlEnt($data))); break;
      case 'mediawiki': $data = nl2br(mediawiki2html(htmlEnt($data))); break;
      case 'plain': // fall through
      default: $data = nl2br(makeClickable(htmlEnt($data))); break;
    }
    return $data;
  }


  /**
   * Get the filtered content.
   *
   * @returns string with the filtered data.
   */
  public function GetFilteredData() {
    return $this->Filter($this['data'], $this['filter']);
  }

} // end class
