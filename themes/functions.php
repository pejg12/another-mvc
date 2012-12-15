<?php
/**
* Helpers for theming, available for all themes in their template files and functions.php.
* This file is included right before the themes own functions.php
*/


/**
* Render all views.
*
* @param $region string the region to draw the content in.
*/
function render_views($region='default') {
  return CAmvc::Instance()->views->Render($region);
}


/**
* Check if region has views. Accepts variable amount of arguments as regions.
*
* @param $region string the region to draw the content in.
*/
function region_has_content($region='default' /*...*/) {
  return CAmvc::Instance()->views->RegionHasView(func_get_args());
}


/**
* Print debuginformation from the framework.
*/
function get_debug() {
  $amvc = CAmvc::Instance(); 
  $html = null;
  if(isset($amvc->config['debug']['db-num-queries']) && $amvc->config['debug']['db-num-queries'] && isset($amvc->db)) {
    $html .= "<p>Database made " . $amvc->db->GetNumQueries() . " queries.</p>";
  }   
  if(isset($amvc->config['debug']['db-queries']) && $amvc->config['debug']['db-queries'] && isset($amvc->db)) {
    $html .= "<p>Database made the following queries.</p><pre>" . implode('<br/><br/>', $amvc->db->GetQueries()) . "</pre>";
  }   
  if(isset($amvc->config['debug']['display-core']) && $amvc->config['debug']['display-core']) {
    $html .= "<hr><h3>Debuginformation</h3><p>The content of CAmvc:</p><pre>" . htmlent(print_r($amvc, true)) . "</pre>";
  }   
  if(isset($amvc->config['debug']['session']) && $amvc->config['debug']['session']) {
    $html .= "<hr><h3>SESSION</h3><p>The content of CAmvc->session:</p><pre>" . htmlent(print_r($amvc->session, true)) . "</pre>";
    $html .= "<p>The content of \$_SESSION:</p><pre>" . htmlent(print_r($_SESSION, true)) . "</pre>";
  }   
  return $html;
}


/**
* Prepend the base_url.
*/
function base_url($url) {
	return $amvc->request->base_url . trim($url, '/');
}


/**
 * Create a url to an internal resource.
 *
 * @param string the whole url or the controller. Leave empty for current controller.
 * @param string the method when specifying controller as first argument, else leave empty.
 * @param string the extra arguments to the method, leave empty if not using method.
 */
function create_url($urlOrController=null, $method=null, $arguments=null) {
  return CAmvc::Instance()->request->CreateUrl($urlOrController, $method, $arguments);
}


/**
 * Prepend the theme_url, which is the url to the current theme directory.
 */
function theme_url($url) {
  $amvc = CAmvc::Instance();
  return "{$amvc->request->base_url}themes/{$amvc->config['theme']['name']}/{$url}";
}


/**
* Return the current url.
*/
function current_url() {
	return $amvc->request->current_url;
}


/**
* Get messages stored in flash-session.
*/
function get_messages_from_session() {
  $messages = CAmvc::Instance()->session->GetMessages();
  $html = null;
  if(!empty($messages)) {
    foreach($messages as $val) {
      $valid = array('block', 'error', 'success', 'info');
      $class = (in_array($val['type'], $valid) ? $val['type'] : 'info');
      $html .= "<div class='alert alert-$class'>{$val['message']}</div>\n";
    }
  }
  return $html;
}


/**
* Login menu. Creates a menu which reflects if user is logged in or not.
*/
function login_menu() {
  $amvc = CAmvc::Instance();
  if($amvc->user['isAuthenticated']) {
    $gravatarsize = 18;
    $items = "<li><a href='" . create_url('user', 'profile') . "'><img src='" . get_gravatar($gravatarsize) . "' alt='Your gravatar' class='img-rounded' width='{$gravatarsize}' height='{$gravatarsize}' /> {$amvc->user['acronym']}'s profile</a></li>\n";
    if($amvc->user['hasRoleAdmin']) {
      $items .= "<li><a href='" . create_url('acp') . "'>Control Panel</a></li>\n";
    }
    $items .= "<li><a href='" . create_url('user', 'logout') . "'>Log out</a></li>\n";
  } else {
    $items = "<li><a href='" . create_url('user', 'login') . "'>Log in</a></li>\n";
  }
  return $items;
}


/**
* Get a gravatar based on the user's email.
*/
function get_gravatar($size=null) {
  $email = CAmvc::Instance()->user['email']; // user email
  $email = md5(strtolower(trim($email)));    // hash for gravatar
  $size  = ($size ? "?s=$size" : null);      // size defined?
  return "http://www.gravatar.com/avatar/{$email}.jpg{$size}";
}


/**
 * Escape data to make it safe to write in the browser.
 */
function esc($str) {
  return htmlEnt($str);
}


/**
 * Filter data according to a filter. Uses CMContent::Filter()
 *
 * @param $data string the data-string to filter.
 * @param $filter string the filter to use.
 * @returns string the filtered string.
 */
function filter_data($data, $filter) {
  return CMContent::Filter($data, $filter);
}
