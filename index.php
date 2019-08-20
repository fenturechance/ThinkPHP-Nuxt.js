    <?php

header('Access-Control-Allow-Origin: *');
if (version_compare(PHP_VERSION, '5.3.0', '<'))
    die('require PHP > 5.3.0 !');

define('APP_DEBUG', true);

define('APP_PATH', './Application/');


include 'config.php';

require (CONF_THINKPHP_PATH) ? CONF_THINKPHP_PATH . './ThinkPHP.php' : '/opt/lampp/ThinkPHP/ThinkPHP.php';
