<?php
/**
* Standard controller layout.
*
* @package AnotherMVCCore
*/
class CCIndex implements IController {

	/**
	* Implementing interface IController. All controllers must have an index action.
	*/
	public function Index() {   
		global $amvc;
		$amvc->data['title'] = "The Index Controller";
		$amvc->data['main'] = <<<EOD
<h1>The Index Controller</h1>
<p>Welcome to Another MVC.</p>
EOD;
	}

} 