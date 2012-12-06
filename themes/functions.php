<?php
/**
* Helpers for theming, available for all themes in their template files and functions.php.
* This file is included right before the themes own functions.php
*/


/**
* Print debuginformation from the framework.
*/
function get_debug() {
	$amvc = CAmvc::Instance();

	if( TRUE === $amvc->config['debug']['display-core'] )
	{
		$html  = "<h2>Debuginformation</h2>";
		$html .= "<p>The content of CAmvc:</p>";
		$html .= "<pre>" . htmlent(print_r($amvc, true)) . "</pre>";
		return $html;
	}
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