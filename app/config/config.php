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


// Stripe API Keys (Test Mode)
define('STRIPE_PUBLIC_KEY', 'pk_test_51RF9PVPCGEt7iiUpUiGDX3HVHxngrFTG7nBhVQ21qNyR0dRF4FPT1pSX0MMIZwrmDeW8bpng1YgDiuYhXuvsox7l00FGOXvxvo');
define('STRIPE_SECRET_KEY', 'sk_test_51RF9PVPCGEt7iiUpgFaWRy8w90zmG9Jn9SwMUaooiHqL4h4fCx2j9mVTGiVrL6gLdIkYFHX2olIUU3yyKoF5URen00VJDj2f08');
define('STRIPE_WEBHOOK_SECRET', 'whsec_your_webhook_secret');

