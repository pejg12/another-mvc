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
  public function __construct() {
    parent::__construct();
    $this->views->AddStyle("body:hover { background: url('" . $this->request->base_url . "themes/grid/img/grid_12_60_20.png') left top repeat-y #fff; }\n");
  }


  /**
    * Display what can be done with this controller.
    */
  public function Index() {
    $this->views->SetTitle('Theme explained')
                ->AddInclude(__DIR__ . '/quiet/primary.tpl.php', array(
                  'theme_name' => $this->config['theme']['name'],
                ), 'primary')
                ->AddInclude(__DIR__ . '/quiet/sidebar.tpl.php', array(), 'sidebar')
                ->AddInclude(__DIR__ . '/quiet/footer.tpl.php', array(), 'footer')
                ->AddInclude(__DIR__ . '/quiet/flash.tpl.php', array(), 'flash')
                ->AddInclude(__DIR__ . '/quiet/featured-left.tpl.php', array(), 'featured-left')
                ->AddInclude(__DIR__ . '/quiet/featured-middle.tpl.php', array(), 'featured-middle')
                ->AddInclude(__DIR__ . '/quiet/featured-right.tpl.php', array(), 'featured-right')
                ->AddInclude(__DIR__ . '/quiet/triptych-left.tpl.php', array(), 'triptych-left')
                ->AddInclude(__DIR__ . '/quiet/triptych-middle.tpl.php', array(), 'triptych-middle')
                ->AddInclude(__DIR__ . '/quiet/triptych-right.tpl.php', array(), 'triptych-right');

    $this->views->AddStyle("nav,\narticle,\nfooter,\nheader,\nsection,\naside { background-color:rgba(0, 0, 0, 0.1); }\n");

  }


  /**
    * Display in a verbose manner what can be done with this controller.
    */
  public function Verbose() {
    $this->config['theme']['template_file'] = 'verbose.tpl.php';
    $this->views->SetTitle('Theme explained (verbosely)')
                ->AddInclude(__DIR__ . '/verbose/primary.tpl.php', array(
                  'theme_name' => $this->config['theme']['name'],
                ), 'primary')
                ->AddInclude(__DIR__ . '/verbose/sidebar.tpl.php', array(), 'sidebar')
                ->AddInclude(__DIR__ . '/verbose/footer.tpl.php', array(), 'footer')
                ->AddInclude(__DIR__ . '/verbose/flash.tpl.php', array(), 'flash')
                ->AddInclude(__DIR__ . '/verbose/featured-left.tpl.php', array(), 'featured-left')
                ->AddInclude(__DIR__ . '/verbose/featured-middle.tpl.php', array(), 'featured-middle')
                ->AddInclude(__DIR__ . '/verbose/featured-right.tpl.php', array(), 'featured-right')
                ->AddInclude(__DIR__ . '/verbose/triptych-left.tpl.php', array(), 'triptych-left')
                ->AddInclude(__DIR__ . '/verbose/triptych-middle.tpl.php', array(), 'triptych-middle')
                ->AddInclude(__DIR__ . '/verbose/triptych-right.tpl.php', array(), 'triptych-right');

    $this->views->AddStyle("nav,\narticle,\nfooter,\nheader,\nsection,\naside { background-color:rgba(0, 0, 0, 0.1); }\n");
  }


  /**
   * Put content in some regions.
   */
  public function SomeRegions() {
    $this->views->SetTitle('Theme displaying some regions')
                ->AddString('This is the primary region', array(), 'primary')
                ->AddString('This is the sidebar region', array(), 'sidebar');

    if(func_num_args()) {
      foreach(func_get_args() as $val) {
        $this->views->AddString("[\$region] => {$val}", array(), $val);
      }
    }

    $this->views->AddStyle("nav,\narticle,\nfooter,\nheader,\nsection,\naside { background-color:rgba(0, 0, 0, 0.1); }\n");
  }


  /**
    * Display lots of various HTML elements to verify the CSS
    */
  public function Typography() {
    $this->views->SetTitle('Theme displaying typographical elements')
                ->AddInclude(__DIR__ . '/typography.tpl.php', array(
                ), 'primary');

    $this->views->AddStyle("nav,\narticle,\nfooter,\nheader,\nsection,\naside { background-color:rgba(0, 0, 0, 0.1); }\n");
  }


  /**
   * Put content in all regions.
   */
  public function AllRegions() {
    $this->views->SetTitle('Theme displaying all regions');
    foreach($this->config['theme']['regions'] as $val) {
      $this->views->AddString("[\$region] => {$val}", array(), $val);
    }
    $this->views->AddStyle("nav,\narticle,\nfooter,\nheader,\nsection,\naside { background-color:rgba(0, 0, 0, 0.1); }\n");
  }


}
