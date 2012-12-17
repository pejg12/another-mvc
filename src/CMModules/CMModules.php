<?php
/**
 * A model for managing Another MVC modules.
 *
 * @package AnotherMVCCore
 */
class CMModules extends CObject {


  /**
   * Constructor
   */
  public function __construct() { parent::__construct(); }


  /**
   * A list of all available controllers/methods
   *
   * @returns array list of controllers (key) and an array of methods
   */
  public function AvailableControllers() { 
    $controllers = array();
    foreach($this->config['controllers'] as $key => $val) {
      if($val['enabled']) {
        $rc = new ReflectionClass($val['class']);
        $controllers[$key] = array();
        $methods = $rc->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach($methods as $method) {
          if($method->name != '__construct' && $method->name != '__destruct' && $method->name != 'Index') {
            $methodName = mb_strtolower($method->name);
            $controllers[$key][] = $methodName;
          }
        }
        sort($controllers[$key], SORT_LOCALE_STRING);
      }
    }
    ksort($controllers, SORT_LOCALE_STRING);
    return $controllers;
  }


  /**
    * Read and analyse all modules.
    *
    * @returns array with a entry for each module with the module name as the
    *                key. Returns boolean false if $src can not be opened.
    */
  public function ReadAndAnalyse() {
    $src = AMVC_INSTALL_PATH.'/src';
    if(!$dir = dir($src)) throw new Exception('Could not open the directory.');
    $modules = array();
    while (($module = $dir->read()) !== false) {
      if(is_dir("$src/$module")) {
        if(class_exists($module)) {
          $rc = new ReflectionClass($module);
          $modules[$module]['name']          = $rc->name;
          $modules[$module]['interface']     = $rc->getInterfaceNames();
          $modules[$module]['isController']  = $rc->implementsInterface('IController');
          $modules[$module]['isModel']       = preg_match('/^CM[A-Z]/', $rc->name);
          $modules[$module]['hasSQL']        = $rc->implementsInterface('IHasSQL');
          $modules[$module]['isManageable']  = $rc->implementsInterface('IModule');
          $modules[$module]['isAmvcCore']   = in_array($rc->name, array('CAmvc', 'CDatabase', 'CRequest', 'CViewContainer', 'CSession', 'CObject'));
          $modules[$module]['isAmvcCMF']    = in_array($rc->name, array('CForm', 'CCPage', 'CCBlog', 'CMUser', 'CCUser', 'CMContent', 'CCContent', 'CFormUserLogin', 'CFormUserProfile', 'CFormUserCreate', 'CFormContent', 'CHTMLPurifier'));
        }
      }
    }
    $dir->close();
    ksort($modules, SORT_LOCALE_STRING);
    return $modules;
  }


  /**
    * Install all modules.
    *
    * @returns array with a entry for each module and the result from installing it.
    */
  public function Install() {
    $allModules = $this->ReadAndAnalyse();
    $installed = array();
    foreach($allModules as $module) {
      if($module['isManageable']) {
        $classname = $module['name'];
        $rc = new ReflectionClass($classname);
        $obj = $rc->newInstance();
        $method = $rc->getMethod('Manage');
        $installed[$classname]['name']    = $classname;
        $installed[$classname]['result']  = $method->invoke($obj, 'install');
      }
    }
    ksort($installed, SORT_LOCALE_STRING);
    return $installed;
  }

} // end class
