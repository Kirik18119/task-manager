#!/usr/bin/env php
<?php

if ($argv[1] == 'run') {
    exec('composer install');
    exec('composer dump-autoload');
    exec('php -S localhost:8000 index.php');
} else {
    echo "Command is not supported".PHP_EOL;
    exit;
}