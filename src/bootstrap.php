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
* Set a default exception handler and enable logging in it.
*/
function exception_handler($e) {
  echo "Another MVC: Uncaught exception: <p>" . $e->getMessage() . "</p><pre>" . $e->getTraceAsString(), "</pre>";
}
set_exception_handler('exception_handler');


/**
 * Helper, include a file and store it in a string. Make $vars available to the included file.
 */
function getIncludeContents($filename, $vars=array()) {
  if (is_file($filename)) {
    ob_start();
    extract($vars);
    include $filename;
    return ob_get_clean();
  }
  return false;
}


/**
* Helper, wrap html_entites with correct character encoding
*/
function htmlent($str, $flags = ENT_COMPAT) {
  return htmlentities($str, $flags, CAmvc::Instance()->config['character_encoding']);
}


/**
  * Make clickable links from URLs in text.
  *
  * @param string text text to be converted.
  * @returns string the formatted text.
  */
function MakeClickable($text) {
  return preg_replace_callback(
    '#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
    create_function(
      '$matches',
      'return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";'
    ),
    $text
  );
}


/**
 * Helper, interval formatting of times. Needs PHP5.3. 
 *
 * All times in database is UTC so this function assumes the starttime to be in UTC, if not otherwise
 * stated.
 *
 * Copied from http://php.net/manual/en/dateinterval.format.php#96768
 * Modified (mos) to use timezones.
 * A sweet interval formatting, will use the two biggest interval parts.
 * On small intervals, you get minutes and seconds.
 * On big intervals, you get months and days.
 * Only the two biggest parts are used.
 *
 * @param DateTime|string $start
 * @param DateTimeZone|string|null $startTimeZone
 * @param DateTime|string|null $end
 * @param DateTimeZone|string|null $endTimeZone
 * @return string
 */
function formatDateTimeDiff($start, $startTimeZone=null, $end=null, $endTimeZone=null) {
  if(!($start instanceof DateTime)) {
    if($startTimeZone instanceof DateTimeZone) {
      $start = new DateTime($start, $startTimeZone);
    } else if(is_null($startTimeZone)) {
      $start = new DateTime($start);
    } else {
      $start = new DateTime($start, new DateTimeZone($startTimeZone));
    }
  }

  if($end === null) {
    $end = new DateTime();
  }

  if(!($end instanceof DateTime)) {
    if($endTimeZone instanceof DateTimeZone) {
      $end = new DateTime($end, $endTimeZone);
    } else if(is_null($endTimeZone)) {
      $end = new DateTime($end);
    } else {
      $end = new DateTime($end, new DateTimeZone($endTimeZone));
    }
  }

  $interval = $end->diff($start);
  $doPlural = function($nb,$str){return $nb>1?$str.'s':$str;}; // adds plurals
  //$doPlural = create_function('$nb,$str', 'return $nb>1?$str."s":$str;'); // adds plurals

  $format = array();
  if($interval->y !== 0) {
    $format[] = "%y ".$doPlural($interval->y, "year");
  }
  if($interval->m !== 0) {
    $format[] = "%m ".$doPlural($interval->m, "month");
  }
  if($interval->d !== 0) {
    $format[] = "%d ".$doPlural($interval->d, "day");
  }
  if($interval->h !== 0) {
    $format[] = "%h ".$doPlural($interval->h, "hour");
  }
  if($interval->i !== 0) {
    $format[] = "%i ".$doPlural($interval->i, "minute");
  }
  if(!count($format)) {
      return "less than a minute";
  }
  if($interval->s !== 0) {
    $format[] = "%s ".$doPlural($interval->s, "second");
  }

  if($interval->s !== 0) {
      if(!count($format)) {
          return "less than a minute";
      } else {
          $format[] = "%s ".$doPlural($interval->s, "second");
      }
  }

  // We use the two biggest parts
  if(count($format) > 1) {
      $format = array_shift($format)." and ".array_shift($format);
  } else {
      $format = array_pop($format);
  }

  // Prepend 'since ' or whatever you like
  return $interval->format($format);
}


/**
 * Helper, BBCode formatting converting to HTML.
 *
 * @param string text The text to be converted.
 * @returns string the formatted text.
 */
function bbcode2html($text) {
  $search = array( 
    '/\[b\](.*?)\[\/b\]/is', 
    '/\[i\](.*?)\[\/i\]/is', 
    '/\[u\](.*?)\[\/u\]/is', 
    '/\[img\](https?.*?)\[\/img\]/is', 
    '/\[url\](https?.*?)\[\/url\]/is', 
    '/\[url=(https?.*?)\](.*?)\[\/url\]/is' 
    );
  $replace = array( 
    '<strong>$1</strong>', 
    '<em>$1</em>', 
    '<u>$1</u>', 
    '<img src="$1" />', 
    '<a href="$1">$1</a>', 
    '<a href="$1">$2</a>' 
    );
  return preg_replace($search, $replace, $text);
}


/**
* Helper, selected mediawiki formatting converted to HTML.
*
* @param string text The text to be converted.
* @returns string the formatted text.
* @todo lines indented with 1 space converted to <pre> or <code> instead, multiline span
* @todo html tags <pre> and <nowiki> interpreted as plain text instead
* @todo improve image formatting. image size? image class? bootstrap css classes: img-rounded, img-circle, img-polaroid
* @todo improve nested list items. **:#*#* should be interpreted as 7 li items in nested ul/ul/dl/ol/ul/ol/ul lists
* @todo tables? advanced but powerful.
*/
function mediawiki2html($text) {
  $search = array(
    // Text formatting, inline
    '/\'\'\'(.+?)\'\'\'/',            // '''bold'''
    '/\'\'(.+?)\'\'/',                // ''italic''

    // Links, inline, case-insensitive
    '/\[File:(https?.+?)\|(.*?)\]/i', // [File:http://example.org/file.jpg|Alternative text]
    '/\[File:(https?.+?)\]/i',        // [File:http://example.org/file.jpg]
    '/\[(https?.+?) (.+?)\]/i',       // [http://example.org Example]
    '/\[(https?.+?)\]/i',             // [http://example.org]

    // Headings, h6 to h1, block
    '/^======(.+?)======$/m',         // ======Deepest heading======
    '/^=====(.+?)=====$/m',           // =====So deep=====
    '/^====(.+?)====$/m',             // ==== Probably the deepest you'll actually use ====
    '/^===(.+)===$/m',                // === First subheading within articles ===
    '/^==(.+?)==$/m',                 // == First heading within articles ==
    '/^=(.+?)=$/m',                   // = Top heading, reserved for page =

    // Horizontal rule, block
    '/^-{4,}$/m',                     // --------------

    /* WIKY: https://github.com/lahdekorpi/Wiky.php/blob/master/wiky.inc.php */
    // WIKY Indentations (what he really means is Definition list)
    "/[\n\r]: *.+([\n\r]:+.+)*/",                   // Indentation first pass
    "/^:(?!:) *(.+)$/m",                            // Indentation second pass
    "/([\n\r]:: *.+)+/",                            // Subindentation first pass
    "/^:: *(.+)$/m",                                // Subindentation second pass

    // WIKY Ordered list
    "/[\n\r]?#.+([\n|\r]#.+)+/",                    // First pass, finding all blocks
    "/[\n\r]#{3}(?!#) *(.+)(([\n\r]#{4,}.+)+)/",    // List item with sub items of 4 or more
    "/[\n\r]#{2}(?!#) *(.+)(([\n\r]#{3,}.+)+)/",    // List item with sub items of 3 or more
    "/[\n\r]#(?!#) *(.+)(([\n\r]#{2,}.+)+)/",       // List item with sub items of 2 or more

    // WIKY Unordered list
    "/[\n\r]?\*.+([\n|\r]\*.+)+/",                  // First pass, finding all blocks
    "/[\n\r]\*{3}(?!\*) *(.+)(([\n\r]\*{4,}.+)+)/", // List item with sub items of 4 or more
    "/[\n\r]\*{2}(?!\*) *(.+)(([\n\r]\*{3,}.+)+)/", // List item with sub items of 3 or more
    "/[\n\r]\*(?!\*) *(.+)(([\n\r]\*{2,}.+)+)/",    // List item with sub items of 2 or more

    // WIKY List items
    "/^[#\*]+ *(.+)$/m",                            // Wraps all list items to <li/>
    );
  $replace = array(
    '<strong>$1</strong>',
    '<em>$1</em>',
    '<img src="$1" alt="$2" />',
    '<img src="$1" alt="Oops, no alt text" />',
    '<a href="$1">$2</a>',
    '<a href="$1">$1</a>',
    '<h6>$1</h6>',
    '<h5>$1</h5>',
    '<h4>$1</h4>',
    '<h3>$1</h3>',
    '<h2>$1</h2>',
    '<h1>$1</h1>',
    '<hr />',
    // WIKY Lists
    "\n<dl>$0\n</dl>", // Newline is here to make the second pass easier
    "<dd>$1</dd>",
    "\n<dd><dl>$0\n</dl></dd>",
    "<dd>$1</dd>",
    "\n<ol>\n$0\n</ol>",
    "\n<li>$1\n<ol>$2\n</ol>\n</li>",
    "\n<li>$1\n<ol>$2\n</ol>\n</li>",
    "\n<li>$1\n<ol>$2\n</ol>\n</li>",
    "\n<ul>\n$0\n</ul>",
    "\n<li>$1\n<ul>$2\n</ul>\n</li>",
    "\n<li>$1\n<ul>$2\n</ul>\n</li>",
    "\n<li>$1\n<ul>$2\n</ul>\n</li>",
    "<li>$1</li>",
    );
  return preg_replace($search, $replace, $text);
}
