<?php



//database configuration

define('DB_HOST', 'localhost:3307');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'sameepa');


//APPROOT
define('APPROOT', dirname(dirname(__FILE__)));


//URLROOT
define('URLROOT', 'http://localhost/sameepa');


//WEBSITE name
define('SITENAME', 'sameepa');


require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
