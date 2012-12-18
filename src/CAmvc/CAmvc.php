<?php
/**
 * Main class for Another MVC, holds everything.
 *
 * @package AnotherMVCCore
 */
class CAmvc implements ISingleton {

  /**
   * Members
   */
  private static $instance = null;
  public $config = array();
  public $request;
  public $data;
  public $db;
  public $views;
  public $session;
  public $timer = array();
  public $user;

  /**
   * Constructor
   */
  protected function __construct() {
    // time page generation
    $this->timer['first'] = microtime(true);

    // include the site specific config.php and create a ref to $amvc to be used by config.php
    $amvc = &$this;
    require(AMVC_SITE_PATH.'/config.php');

    // Start a named session
    session_name($this->config['session_name']);
    session_start();
    $this->session = new CSession($this->config['session_key']);
    $this->session->PopulateFromSession();

    // Set default charset
    ini_set('default_charset', strtolower($amvc->config['character_encoding']));

    // Set default date/time-zone
    date_default_timezone_set($this->config['timezone']);

    // Create a database object.
    if(isset($this->config['database'][0]['dsn'])) {
      $this->db = new CDatabase($this->config['database'][0]['dsn']);
    }

    // Create a container for all views and theme data
    $this->views = new CViewContainer();

    // Create a object for the user
    $this->user = new CMUser($this);
  }

  /**
   * Singleton pattern. Get the instance of the latest created object or create a new one.
   * @return CAmvc The instance of this class.
   */
  public static function Instance() {
    if(self::$instance == null) {
        self::$instance = new CAmvc();
    }
    return self::$instance;
  }

  /**
   * Frontcontroller, check url and route to controllers.
   */
  public function FrontControllerRoute() {
    // Take current url and divide it in controller, method and parameters
    $this->request = new CRequest($this->config['url_type']);
    $this->request->Init($this->config['base_url'], $this->config['routing']);
    $controller = $this->request->controller;
    $method     = $this->request->method;
    $arguments  = $this->request->arguments;

    // Is the controller enabled in config.php?
    $controllerExists    = isset($this->config['controllers'][$controller]);
    $controllerEnabled   = false;
    $className           = false;
    $classExists         = false;

    if($controllerExists) {
      $controllerEnabled    = ($this->config['controllers'][$controller]['enabled'] == true);
      $className            =  $this->config['controllers'][$controller]['class'];
      $classExists          = class_exists($className);
    }

    // Check if controller has a callable method in the controller class, if then call it
    if($controllerExists && $controllerEnabled && $classExists) {
      $rc = new ReflectionClass($className);
      if($rc->implementsInterface('IController')) {
         $formattedMethod = str_replace(array('_', '-'), '', $method);
        if($rc->hasMethod($formattedMethod)) {
          $controllerObj = $rc->newInstance();
          $methodObj = $rc->getMethod($formattedMethod);
          if($methodObj->isPublic()) {
            $methodObj->invokeArgs($controllerObj, $arguments);
          } else {
            die("404. " . get_class() . ' error: Controller method not public.');
          }
        } else {
          die("404. " . get_class() . ' error: Controller does not contain method.');
        }
      } else {
        die('404. ' . get_class() . ' error: Controller does not implement interface IController.');
      }
    }
    else {
      die('404. Page is not found.');
    }

  }

  /**
   * ThemeEngineRender, renders the reply of the request.
   */
  public function ThemeEngineRender() {
    // Save to session before output anything
    $this->session->StoreInSession();

    // Is theme enabled?
    if(!isset($this->config['theme'])) {
      return;
    }

    // Get the paths and settings for the theme, look in the site dir first
    $themePath    = AMVC_INSTALL_PATH  . '/' . $this->config['theme']['path'];
    $themeUrl     = $this->request->base_url . $this->config['theme']['path'];

    // Is there a parent theme?
    $parentPath = null;
    $parentUrl = null;
    if(isset($this->config['theme']['parent'])) {
      $parentPath = AMVC_INSTALL_PATH  . '/' . $this->config['theme']['parent'];
      $parentUrl  = $this->request->base_url . $this->config['theme']['parent'];
    }

    // Add stylesheet path to the $amvc->data array
    $this->data['stylesheet'] = $this->config['theme']['stylesheet'];

    // Make the theme urls available as part of $amvc
    $this->themeUrl = $themeUrl;
    $this->themeParentUrl = $parentUrl;

    // Map menu to region if defined
    if(is_array($this->config['theme']['menu_to_region'])) {
      foreach($this->config['theme']['menu_to_region'] as $key => $val) {
        $this->views->AddString($this->DrawMenu($key), null, $val);
      }
    }

    // Include the global functions.php and the functions.php that are part of the theme
    $amvc = &$this;
    // First the default Another MVC themes/functions.php
    include(AMVC_INSTALL_PATH . '/themes/functions.php');
    // Then the functions.php from the parent theme
    if($parentPath) {
      if(is_file("{$parentPath}/functions.php")) {
        include "{$parentPath}/functions.php";
      }
    }
    // And last the current theme functions.php
    if(is_file("{$themePath}/functions.php")) {
      include "{$themePath}/functions.php";
    }

    // Extract $amvc->data and $amvc->views->data to own variables and hand over to the template file
    extract($this->data);  // OBSOLETE, use $this->views->GetData() to set variables
    extract($this->views->GetData());
    if(isset($this->config['theme']['data'])) {
      extract($this->config['theme']['data']);
    }

    // Execute the template file
    $templateFile = (isset($this->config['theme']['template_file'])) ? $this->config['theme']['template_file'] : 'default.tpl.php';
    if(is_file("{$themePath}/{$templateFile}")) {
      include("{$themePath}/{$templateFile}");
    } else if(is_file("{$parentPath}/{$templateFile}")) {
      include("{$parentPath}/{$templateFile}");
    } else {
      throw new Exception('No such template file.');
    }
  }


  /**
   * Redirect to another url and store the session
   */
  public function RedirectTo($urlOrController=null, $method=null, $arguments=null) {
    $amvc = CAmvc::Instance();
    if(isset($amvc->config['debug']['db-num-queries']) && $amvc->config['debug']['db-num-queries'] && isset($amvc->db)) {
      $this->session->SetFlash('database_numQueries', $this->db->GetNumQueries());
    }
    if(isset($amvc->config['debug']['db-queries']) && $amvc->config['debug']['db-queries'] && isset($amvc->db)) {
      $this->session->SetFlash('database_queries', $this->db->GetQueries());
    }
    if(isset($amvc->config['debug']['timer']) && $amvc->config['debug']['timer']) {
      $this->session->SetFlash('timer', $amvc->timer);
    }
    $this->session->StoreInSession();
    header('Location: ' . $this->request->CreateUrl($urlOrController, $method, $arguments));
  }


  /**
   * Redirect to a method within the current controller. Defaults to index-method. Uses RedirectTo().
   *
   * @param string method name the method, default is index method.
   */
  public function RedirectToController($method=null, $arguments=null) {
    $this->RedirectTo($this->request->controller, $method, $arguments);
  }


  /**
   * Redirect to a controller and method. Uses RedirectTo().
   *
   * @param string controller name the controller or null for current controller.
   * @param string method name the method, default is current method.
   */
  public function RedirectToControllerMethod($controller=null, $method=null, $arguments=null) {
    $controller = is_null($controller) ? $this->request->controller : null;
    $method = is_null($method) ? $this->request->method : null;
    $this->RedirectTo($this->request->CreateUrl($controller, $method, $arguments));
  }


  /**
   * Save a message in the session. Uses $this->session->AddMessage()
   *
   * @param $type string the type of message, for example: notice, info, success, warning, error.
   * @param $message string the message.
   * @param $alternative string the message if the $type is set to false, defaults to null.
   */
  public function AddMessage($type, $message, $alternative=null) {
    if($type === false) {
      $type = 'error';
      $message = $alternative;
    } else if($type === true) {
      $type = 'success';
    }
    $this->session->AddMessage($type, $message);
  }


  /**
   * Create an url. Uses $this->request->CreateUrl()
   *
   * @param $urlOrController string the relative url or the controller
   * @param $method string the method to use, $url is then the controller or empty for current
   * @param $arguments string the extra arguments to send to the method
   */
  public function CreateUrl($urlOrController=null, $method=null, $arguments=null) {
    return $this->request->CreateUrl($urlOrController, $method, $arguments);
  }


  /**
   * Draw HTML for a menu defined in $amvc->config['menus'].
   *
   * @param $menu string then key to the menu in the config-array.
   * @returns string with the HTML representing the menu.
   */
  public function DrawMenu($menu) {
    $items = null;
    if(isset($this->config['menus'][$menu])) {
      foreach($this->config['menus'][$menu] as $val) {
        $selected = null;
        if($val['url'] == $this->request->request || $val['url'] == $this->request->routed_from) {
          $selected = " class='selected'";
        }
        $items .= "<li><a {$selected} href='" . $this->CreateUrl($val['url']) . "'>{$val['label']}</a></li>\n";
      }
    } else {
      throw new Exception('No such menu.');
    }
    return "<ul class='menu {$menu}'>\n{$items}</ul>\n";
  }

} // end of class
