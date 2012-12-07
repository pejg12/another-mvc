<?php
/**
* Bootstrapping, setting up and loading the core.
*
* @package AnotherMVCCore
*/

/**
* Enable auto-load of class declarations.
*/
function autoload($aClassName) {
  $classFile = "/src/{$aClassName}/{$aClassName}.php";
   $file1 = AMVC_INSTALL_PATH . $classFile;
   $file2 = AMVC_SITE_PATH . $classFile;
   if(is_file($file1)) {
      require_once($file1);
   } elseif(is_file($file2)) {
      require_once($file2);
   }
}
spl_autoload_register('autoload');

/**
* Helper, wrap html_entites with correct character encoding
*/
function htmlent($str, $flags = ENT_COMPAT) {
  return htmlentities($str, $flags, CAmvc::Instance()->config['character_encoding']);
}

/**
* Set a default exception handler and enable logging in it.
*/
function exception_handler($exception) {
  echo "Another MVC: Uncaught exception: <p>" . $e->getMessage() . "</p><pre>" . $e->getTraceAsString(), "</pre>";
}
set_exception_handler('exception_handler');