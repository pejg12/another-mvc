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