<?php

chdir(dirname(__DIR__));
$autoloader = require 'vendor/autoload.php';
$autoloader->setPsr4('mxreCaptchaTest\\', __DIR__ . '/../tests');
