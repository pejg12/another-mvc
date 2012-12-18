 <?php
/**
 * Admin Control Panel to manage admin stuff.
 *
 * @package AnotherMVCCore
 */
class CCAdminControlPanel extends CObject implements IController {


  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
  }


  /**
   * Show profile information of the user.
   */
  public function Index() {
    $this->views->SetTitle('Admin Control Panel');
    $this->views->AddInclude(__DIR__ . '/index.tpl.php');
  }

}
