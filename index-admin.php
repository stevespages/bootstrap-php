<?php
/*
 * Contains code which is required by both index.php and admin.php.
 */

// Put error reporting statements here (will come after session_start() in...
// ...admin.php).

include_once '../functions/functions.php';
include_once 'models.php';

// CONFIG

// Dev
$host = '127.0.0.1';
$db   = 'today';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$user = 'root';
$pass = '';
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];


// Prod
/*
$host = 'dbxxxxxxxxx.db.1and1.com';
$db   = 'dbxxxxxxxxx';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$user = 'root';
$pass = '????????';
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
*/

$pdo = new PDO($dsn, $user, $pass, $opt);
