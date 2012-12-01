<?php
/**
* Standard controller layout.
*
* @package LydiaCore
*/
class CCIndex implements IController {

	/**
	* Implementing interface IController. All controllers must have an index action.
	*/
	public function Index() {   
		global $ly;
		$ly->data['title'] = "The Index Controller";
		$ly->data['main'] = <<<EOD
<h1>The Index Controller</h1>
<p>Welcome to Another MVC.</p>
EOD;
	}

} 