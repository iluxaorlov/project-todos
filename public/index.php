<?php

use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

session_name('TODOS');
session_set_cookie_params(time() + 365 * 24 * 60 * 60);
session_start();

$settings = require_once __DIR__ . '/../app/Settings.php';

$app = new App($settings);

// containers
require_once __DIR__ . '/../app/Containers.php';

// routes
require_once __DIR__ . '/../app/Routes.php';

$app->run();
