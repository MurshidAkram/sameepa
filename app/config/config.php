<?php



//database configuration

define('DB_HOST', 'localhost');
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

// Braintree Configuration
define('BRAINTREE_ENVIRONMENT', 'sandbox');
define('BRAINTREE_MERCHANT_ID', '8q8zbkh595vfzgqq');
define('BRAINTREE_PUBLIC_KEY', 'jsrdsxmpq8pg5m44');
define('BRAINTREE_PRIVATE_KEY', '5cda79eb03e45b9b4d2f8b5f8bf6f818');

