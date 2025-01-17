<?php
require_once 'classes/class.match.php';
require_once 'lib/requests/Requests.php';
require_once 'helpers.php';

define('BASE_URL',"http://www.espncricinfo.com/ci/engine/match/1075472.json");
define('SLEEP_INTERVAL', 5);
define('BASE_PATH', dirname(__FILE__));

Requests::register_autoloader();

/*
 * 1 = Wickets Only
 * 2 = Wickets, 4 & 6
 * 3 = Everything except dot deliveries
 * 4 = Everything, including dot balls
 */
define('VERBOSE', 4);

define('DEBUG', true);
