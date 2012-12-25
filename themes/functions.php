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
  if(isset($amvc->config['debug']['timer']) && $amvc->config['debug']['timer']) {
    $html .= "<p>Page was loaded in " . round(microtime(true) - $amvc->timer['first'], 5)*1000 . " ms.</p>";
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
function base_url($url=null) {
  return CAmvc::Instance()->request->base_url . trim($url, '/');
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
  return trim(create_url(CAmvc::Instance()->themeUrl . "/{$url}"), '/');
}


/**
 * Prepend the theme_parent_url, which is the url to the parent theme directory.
 *
 * @param $url string the url-part to prepend.
 * @returns string the absolute url.
 */
function theme_parent_url($url) {
  if(isset(CAmvc::Instance()->config['theme']['parent']))
  {
    return trim(create_url(CAmvc::Instance()->themeParentUrl . "/{$url}"), '/');
  }
  return theme_url($url);
}


/**
 * Return the current url.
 */
function current_url() {
  return CAmvc::Instance()->request->current_url;
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


/**
 * Get list of tools.
 */
function get_tools() {
  global $amvc;
  return <<<EOD
<p>Tools:
<a href="http://validator.w3.org/check/referer">html5</a>
<a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">css3</a>
<a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css21">css21</a>
<a href="http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance">unicorn</a>
<a href="http://validator.w3.org/checklink?uri={$amvc->request->current_url}">links</a>
<a href="http://qa-dev.w3.org/i18n-checker/index?async=false&amp;docAddr={$amvc->request->current_url}">i18n</a>
<!-- <a href="link?">http-header</a> -->
<a href="http://csslint.net/">css-lint</a>
<a href="http://jslint.com/">js-lint</a>
<a href="http://jsperf.com/">js-perf</a>
<a href="http://www.workwithcolor.com/hsl-color-schemer-01.htm">colors</a>
<a href="http://dbwebb.se/style">style</a>
</p>

<p>Docs:
<a href="http://www.w3.org/2009/cheatsheet">cheatsheet</a>
<a href="http://dev.w3.org/html5/spec/spec.html">html5</a>
<a href="http://www.w3.org/TR/CSS2">css2</a>
<a href="http://www.w3.org/Style/CSS/current-work#CSS3">css3</a>
<a href="http://php.net/manual/en/index.php">php</a>
<a href="http://www.sqlite.org/lang.html">sqlite</a>
<a href="http://www.blueprintcss.org/">blueprint</a>
</p>
EOD;
}
