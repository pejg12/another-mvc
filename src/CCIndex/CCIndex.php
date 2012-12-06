<?php
/**
* Standard controller layout.
*
* @package AnotherMVCCore
*/
class CCIndex extends CObject implements IController {

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
		$this->data['title'] = "The Index Controller";
		$this->data['main'] = <<<EOD
		<h1>The Index Controller</h1>
		<p>Welcome to Another MVC.</p>
EOD;
	}

} 