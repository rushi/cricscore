<?php
require_once 'classes/class.match.php';
require_once 'lib/requests/Requests.php';
require_once 'helpers.php';

define('BASE_URL',"http://www.espncricinfo.com/ci/engine/match/companion/data/main.json");
define('SLEEP_INTERVAL', 5);
define('BASE_PATH', dirname(__FILE__));

Requests::register_autoloader();

/*
 * 1 = Wickets Only
 * 2 = Wickets, 4 & 6
 * 3 = Everything except dot deliveries
 * 4 = Everything, including dot balls
 */
define('VERBOSE', 3);

define('DEBUG', true);
