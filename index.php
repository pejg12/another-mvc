<?php
//
// PHASE: BOOTSTRAP
//
define('AMVC_INSTALL_PATH', dirname(__FILE__));
define('AMVC_SITE_PATH', AMVC_INSTALL_PATH . '/site');

require(AMVC_INSTALL_PATH.'/src/bootstrap.php');

$amvc = CAmvc::Instance();

//
// PHASE: FRONTCONTROLLER ROUTE
//
$amvc->FrontControllerRoute();

//
// PHASE: THEME ENGINE RENDER
//
$amvc->ThemeEngineRender();
