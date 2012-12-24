<?php
/**
 * Site configuration, this file is changed by user per site.
 *
 */

/**
 * Set level of error reporting
 */
error_reporting(-1);            // recommended settings are -1 for development and 0 for production
ini_set('display_errors', 1);   // recommended settings are  1 for development and 0 for production

/**
 * Define session name
 * This makes a difference if you run several sites on the same server;
 * each site should have unique names
 */
$amvc->config['km'] = "mvckm8"; // a prefix/suffix used to make sure database tables and session names are unique for this installation
$amvc->config['session_name'] = "pejg" . $amvc->config['km'];
$amvc->config['session_key']  = "another-mvc";

/**
 * Define server timezone
 */
$amvc->config['timezone'] = 'Europe/Stockholm';

/**
 * Define internal character encoding
 */
$amvc->config['character_encoding'] = 'UTF-8';

/**
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
  'theme'     => array('enabled' => true,'class' => 'CCTheme'),
  'modules'   => array('enabled' => true,'class' => 'CCModules'),
);

/**
 * Define a routing table for urls.
 *
 * Route custom urls to a defined controller/method/arguments
 */
$amvc->config['routing'] = array(
  'home' => array('enabled' => true, 'url' => 'index/index'),
);

/**
 * Settings for the theme. The theme may have a parent theme.
 *
 * When a parent theme is used the parent's functions.php will be included
 * before the current theme's functions.php. The parent stylesheet can be
 * included in the current stylesheet by an @import clause. See
 * site/themes/mytheme for an example of a child/parent theme. Template files
 * can reside in the parent or current theme, the CAmvc::ThemeEngineRender()
 * looks for the template-file in the current theme first, then it looks in the
 * parent theme.
 *
 * There are two useful theme helpers defined in themes/functions.php.
 *   theme_url($url): Prepends the current theme url to $url to make an absolute url.
 *   theme_parent_url($url): Prepends the parent theme url to $url to make an absolute url.
 *
 * path: Path to current theme, relativly AMVC_INSTALL_PATH, for example themes/grid or site/themes/mytheme.
 * parent: Path to parent theme, same structure as 'path'. Can be left out or set to null.
 * stylesheet: The stylesheet to include, always part of the current theme, use @import to include the parent stylesheet.
 * template_file: Set the default template file, defaults to default.tpl.php.
 * regions: Array with all regions that the theme supports.
 * data: Array with data that is made available to the template file as variables.
 *
 * The name of the stylesheet is also appended to the data-array, as
 * 'stylesheet' and made available to the template files.
 */
$amvc->config['theme'] = array(
  'path'            => 'themes/grid',
  //'parent'          => 'themes/grid',
  'stylesheet'      => 'style.css',
  'template_file'   => 'default.tpl.php',
  // A list of valid theme regions
  'regions' => array(
    'flash',            // optional
    'featured-left',    // optional
    'featured-middle',  // optional
    'featured-right',   // optional
    'primary',
    'navbar',           // optional
    'sidebar',
    'triptych-left',    // optional
    'triptych-middle',  // optional
    'triptych-right',   // optional
    'footer',
  ),
  // 'menu_to_region' => array('name of menu' => 'name of region')
  'menu_to_region' => array('navbar'=>'navbar'),
  // Add static entries for use in the template file.
  'data' => array(
    'site_title' => 'Another MVC',
    'slogan'     => 'A PHP-based MVC-inspired CMF',
    'footer'     => '<p>Another MVC &copy; pejg12 (pejg12@student.bth.se) <br /> Fork of Lydia &copy; Mikael Roos (mos@dbwebb.se)</p>',
  ),
);

/**
 * Define menus.
 *
 * Create hardcoded menus and map them to a theme region through $amvc->config['theme'].
 */
$amvc->config['menus'] = array(
  'navbar' => array(
    'home'      => array('label'=>'Home', 'url'=>'home'),
    'modules'   => array('label'=>'Modules', 'url'=>'modules'),
    'guestbook' => array('label'=>'Guestbook', 'url'=>'guestbook'),
    'content'   => array('label'=>'Content', 'url'=>'content'),
    'blog'      => array('label'=>'Blog', 'url'=>'blog'),
  ),
  'my-navbar' => array(
    'name'      => array('label'=>'Example', 'url'=>'controller/method'),
  ),
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
 * These may be a serious security threat and should always be set to FALSE once development is completed.
 */
$amvc->config['debug']['display-core'] = FALSE;
$amvc->config['debug']['db-num-queries'] = FALSE;
$amvc->config['debug']['db-queries'] = FALSE;
$amvc->config['debug']['session'] = FALSE;
$amvc->config['debug']['timer'] = TRUE;

/**
 * Set database(s).
 * The 'dsn' should not be set unless the database is writable.
 */
$filepath = AMVC_SITE_PATH . '/data/.ht.sqlite';
if(is_writable(dirname($filepath))) {
  $amvc->config['database'][0]['dsn'] = 'sqlite:' . $filepath;
}


/**
 * How to hash password of new users, choose from: plain, md5salt, md5, sha1salt, sha1.
 */
$amvc->config['hashing_algorithm'] = 'sha1salt';


/**
 * Allow or disallow creation of new user accounts.
 */
$amvc->config['create_new_users'] = true;
