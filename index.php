<?php

/*
 * FUNCTIONS USED from functions/functions.php:
 * createTable()
 * createLinks()
 * createNavigation()
 * getAll()
 * getControllerName()
 * home()
 * innerPeace()
 * action()
 *
 * This site demonstrates a boilerplate website with admin backend that can...
 * ...be used to set up new sites.
 * 
 * The site should use all the functions in functions/functions.php...
 * ...Automated web testing software should be used to test the site's...
 * ...functionality. This tests the site and the functions used by it.
 *
 * The site uses the same HTML template.php output file for all pages.
 *
 * If any pages need a different template.php changes need to be made which...
 * ...are commented in the site where the changes are required
 */

// index-admin.php has code which is required by both index.php and admin.php.
include_once 'index-admin.php';


// MODEL

// An index array of names of the pages of the site.
$navigation_names = array ("Home", "Inner Peace", "Action");
// An associative array. Eg "Inner Peace" => "index.php?page=inner_peace"
// $navigation_links can be modified. If modified within controller...
// ...functions the changes will be page specific
$navigation_links = createLinks($navigation_names, 'index.php');
// Adding a link
$navigation_links['Admin'] = 'admin.php';
// Creating a variable containing an html formatted navigation menu
$navigation = createNavigation($navigation_links);


// VIEW (note that template has to be (included) at the end of the script)...
// ...because if it is here then variables used in it will result in...
// ...undefined variable errors. Those variables are declared later.

// PAGE FUNCTIONS

function home($pdo)
{
    $statement = getAll('quote', $pdo);
    $home_table = createTable($statement, 'home', false, false);
    
    $content = array ('', $home_table, '');
    
    // if any pages on the site need a different template.php file the next...
    // ...line of code will need to uncommented for every page function on...
    // ...the site and then $template (not $content) will need to be...
    // ...returned by the page functions.
    //$template = include_once 'template.php';
    return $content;
}


function innerPeace()
{
	$content = array ('<p>this page will help you attain inner peace</p>', '', '');
   return $content;
}

function action()
{
	$content = array ('<p>this page will help you to take action</p>', '', '');
   return $content;
}
	
$main_heading = 'Test Functions';

$controller = getControllerName($navigation_names);
$sub_heading = ucwords(str_replace('-', ' ', $controller));
$title = 'Today: '.$sub_heading;




// the values of $controller relate to the elements in $navigation
switch ($controller) {
    case "home":
        $content = home($pdo);
        break;
    case "inner-peace":
        $content = innerPeace();
        break;
    case "action":
        $content = action();
}

// If all pages use the same template.php file uncomment the next line of code.
// This template.php can utilise the $title, $navigation, $main_heading and ...
// ...$sub_heading variables.
// If any pages use a different template.php that file must be included from...
// ...within that page function. These page functions and template.php files...
// ...will need to set their title, navigation, main and sub headings.
$template = include_once 'template.php';

// If template.php files are being included from within page functions use:
//echo $content;

// If just one template.php file is used for the whole site use:
echo $template;
