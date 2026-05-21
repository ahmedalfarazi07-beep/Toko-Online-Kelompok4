<?php

$file = 'vendor/composer/autoload_psr4.php';
$content = file_get_contents($file);
$insert = "    'Laravel\\\\Breeze\\\\' => array(\$vendorDir . '/laravel/breeze/src'),\n";
$content = str_replace('return $vendorDir;', $insert.'return $vendorDir;', $content);
file_put_contents($file, $content);
echo "Fixed autoload_psr4.php\n";
