<?php
require 'vendor/autoload.php';
const BASE_PATH = __DIR__;
$collection = glob(BASE_PATH.'/database/properties/*.json');
foreach ($collection as $jsonPath) {
    \PlatformXMLBuilder\XMLBuilder::fromJson($jsonPath);
}
echo 'solução finalizada!' . PHP_EOL;