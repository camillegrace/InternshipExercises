<?php

require __DIR__ . '/../vendor/autoload.php';

session_start();

$settings = require __DIR__ . '/../src/Configuration/settings.php';
$app = new \Slim\App($settings);

require __DIR__ . '/../src/Configuration/dependencies.php';
require __DIR__ . '/../src/Configuration/routes.php';

$app->run();