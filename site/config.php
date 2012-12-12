<?php
/**
* Site configuration, this file is changed by user per site.
*
*/

/*
* Set level of error reporting
*/
error_reporting(-1);
ini_set('display_errors', 1);

/*
* Define session name
*/
$amvc->config['session_name'] = "pejgmvckm5";
$amvc->config['session_key']  = "another-mvc";

/*
* Define server timezone
*/
$amvc->config['timezone'] = 'Europe/Stockholm';

/*
* Define internal character encoding
*/
$amvc->config['character_encoding'] = 'UTF-8';

/*
* Define language
*/
$amvc->config['language'] = 'en';

/**
* Define the controllers, their classname and enable/disable them.
*
* The array-key is matched against the url, for example:
* the url 'developer/dump' would instantiate the controller with the key "developer", that is
* CCDeveloper and call the method "dump" in that class. This process is managed in:
* $amvc->FrontControllerRoute();
* which is called in the frontcontroller phase from index.php.
*/
$amvc->config['controllers'] = array(
  'index'     => array('enabled' => true,'class' => 'CCIndex'),
  'developer' => array('enabled' => true,'class' => 'CCDeveloper'),
  'guestbook' => array('enabled' => true,'class' => 'CCGuestbook'),
  'user'      => array('enabled' => true,'class' => 'CCUser'),
  'acp'       => array('enabled' => true,'class' => 'CCAdminControlPanel'),
  'content'   => array('enabled' => true,'class' => 'CCContent'),
  'blog'      => array('enabled' => true,'class' => 'CCBlog'),
  'page'      => array('enabled' => true,'class' => 'CCPage'),
);

/**
* Settings for the theme.
*/
$amvc->config['theme'] = array(
  // The name of the theme in the theme directory
  'name'    => 'core',
);

/**
* Set a base_url to use another than the default calculated
*/
$amvc->config['base_url'] = null;

/**
* What type of urls should be used?
*
* default      = 0      => index.php/controller/method/arg1/arg2/arg3
* clean        = 1      => controller/method/arg1/arg2/arg3
* querystring  = 2      => index.php?q=controller/method/arg1/arg2/arg3
*/
$amvc->config['url_type'] = 1;

/**
* Determine debug settings
*/
$amvc->config['debug']['display-core'] = FALSE;
$amvc->config['debug']['db-num-queries'] = FALSE;
$amvc->config['debug']['db-queries'] = FALSE;
$amvc->config['debug']['session'] = FALSE;

/**
* Set database(s).
*/
$amvc->config['database'][0]['dsn'] = 'sqlite:' . AMVC_SITE_PATH . '/data/.ht.sqlite';


/**
* How to hash password of new users, choose from: plain, md5salt, md5, sha1salt, sha1.
*/
$amvc->config['hashing_algorithm'] = 'sha1salt';


/**
 * Allow or disallow creation of new user accounts.
 */
$amvc->config['create_new_users'] = true;
