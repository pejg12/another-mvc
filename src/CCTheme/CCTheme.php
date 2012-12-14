<?php
/**
* A test controller for themes.
*
* @package AnotherMVCCore
*/
class CCTheme extends CObject implements IController {


  /**
    * Constructor
    */
  public function __construct() { parent::__construct(); }


  /**
    * Display what can be done with this controller.
    */
  public function Index() {
    $this->views->SetTitle('Theme')
                ->AddInclude(__DIR__ . '/index.tpl.php', array(
                  'theme_name' => $this->config['theme']['name'],
                ));
  }


  /**
    * Display in a verbose manner what can be done with this controller.
    */
  public function Verbose() {
    $this->config['theme']['template_file'] = 'verbose.tpl.php';
    $this->views->SetTitle('Theme')
                ->AddInclude(__DIR__ . '/verbose.tpl.php', array(
                  'theme_name' => $this->config['theme']['name'],
                ));
  }


}
