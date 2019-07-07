<?php

use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$settings = require_once __DIR__ . '/../app/Settings.php';

$app = new App($settings);

// containers
require_once __DIR__ . '/../app/Containers.php';

// routes
require_once __DIR__ . '/../app/Routes.php';

$app->run();
