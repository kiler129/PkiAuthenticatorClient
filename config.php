<?php
define('APP_DIR', dirname(__FILE__));
define('SERVICE_NAME', 'demoservice');
define('SERVICE_PRV_KEY', APP_DIR . '/keys/demo_service_prv.pem');
define('SERVER_PUB_KEY', APP_DIR . '/keys/server_demo_pub.pem');
define('SERVICE', 'demoservice');
define('SERVER_ADDR', 'http://demoserver.local/authenticate.php?svc=' . SERVICE_NAME . '&data=%s');
define('REQUEST_TIMEOUT', 120); //Time between request generation and response generation, keep it long enough to login
define('RESPONSE_TIMEOUT', 20); //Time between server response generation and arrival, keep it short