<?php

/*
 * The following functions, declared in functions/functions.php, are used in...
 * ...in this website:
 * createTable()
 * createLinks()
 * createNavigation()
 * getAll()
 * getControllerName()
 * home()
 * innerPeace()
 * action()
 *
 * This site is a boilerplate website with an admin backend that can...
 * ...be used to set up new sites.
 *
 * This site should use all the functions in functions/functions.php...
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
$navigation_links = createLinks2($navigation_names, 'index.php');
// Adding a link
$navigation_links['Admin'] = 'admin';
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

$controller = getControllerName2($navigation_links);
$main_heading = 'Test Functions';
$sub_heading = ucwords(str_replace('-', ' ', $controller));
$title = 'Today: '.$sub_heading;

// the values of $controller relate to the elements in $navigation
switch ($controller) {
    case "home":
        $content = home($pdo);
        // If a page needs its own template.php file uncomment the next...
        // ...statement. Also make the assignment of $template after this...
        // ...switch statement conditional on (!isset($template)).
        // $template = include_once 'template-home.php';
        break;
    case "inner-peace":
        $content = innerPeace();
        break;
    case "action":
        $content = action();
        break;
    case "admin":
        header('Location: admin.php');
}

// If all pages use the same template.php file the next statement does not...
// ...need to be inside conditional on (!isset($template))
// If all pages use their own template.php the next statement is not needed.
// If some but not all pages use their own template.php file then the next...
// ...statement needs to be conditional on (!isset($template))
if(!isset($template)) {
$template = include_once 'template.php';
}

// If template.php files are being included from within page functions use:
//echo $content;

// If just one template.php file is used for the whole site use:
echo $template;
