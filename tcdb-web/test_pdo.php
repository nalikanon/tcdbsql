<?php
$envPath = __DIR__ . '/.env';
$env = @parse_ini_file($envPath);
print_r($env);
if ($env === false) {
    echo "parse_ini_file failed!";
}
