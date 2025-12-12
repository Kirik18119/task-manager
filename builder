#!/usr/bin/env php
<?php

if ($argv[1] == 'run') {
    exec('composer install');
    exec('composer dump-autoload');
    exec('php -S localhost:8000 index.php');
} else if ($argv[1] == 'test') {
    exec('./vendor/bin/phpunit', $output);
    foreach ($output as $line) {
        echo $line.PHP_EOL;
    }
} else {
    echo "Command is not supported".PHP_EOL;
    exit;
}