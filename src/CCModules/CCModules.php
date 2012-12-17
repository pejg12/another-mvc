<?php
/**
 * To manage and analyse all modules of Another MVC.
 *
 * @package AnotherMVCCore
 */
class CCModules extends CObject implements IController {


  /**
   * Constructor
   */
  public function __construct() { parent::__construct(); }


  /**
   * Show an index page and display what can be done through this controller.
   */
  public function Index() {
    $modules = new CMModules();
    $controllers = $modules->AvailableControllers();
    $allModules = $modules->ReadAndAnalyse();
    $this->views->SetTitle('Manage Modules')
                ->AddInclude(__DIR__ . '/index.tpl.php', array('controllers'=>$controllers), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('modules'=>$allModules), 'sidebar');
  }


  /**
    * Install modules
    */
  public function Install() {
    $modules = new CMModules();
    $results = $modules->Install();
    $allModules = $modules->ReadAndAnalyse();
    $this->views->SetTitle('Install Modules')
                ->AddInclude(__DIR__ . '/install.tpl.php', array('modules'=>$results), 'primary')
                ->AddInclude(__DIR__ . '/sidebar.tpl.php', array('modules'=>$allModules), 'sidebar');
  }

} // end class
