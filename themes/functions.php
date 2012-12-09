<?php
/**
* Helpers for theming, available for all themes in their template files and functions.php.
* This file is included right before the themes own functions.php
*/


/**
* Render all views.
*/
function render_views() {
  return CAmvc::Instance()->views->Render();
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
      $valid = array('info', 'notice', 'success', 'warning', 'error', 'alert');
      $class = (in_array($val['type'], $valid)) ? $val['type'] : 'info';
      $html .= "<div class='$class'>{$val['message']}</div>\n";
    }
  }
  return $html;
}