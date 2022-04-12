<?php declare(strict_types=1);

use Gotenberg\Gotenberg;
use Gotenberg\Stream;

require __DIR__ . '/../vendor/autoload.php';

$url = 'http://172.31.31.39:3000';
$request = Gotenberg::libreOffice($url)
    ->merge()
    ->outputFilename('merged')
    ->convert(
        Stream::path(__DIR__ . '/content.docx'),
        Stream::path(__DIR__ . '/sign.docx')
    );

$filename = Gotenberg::save($request, __DIR__);
echo $filename . PHP_EOL;