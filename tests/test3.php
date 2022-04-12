<?php declare(strict_types=1);

use Gotenberg\Gotenberg;
use Gotenberg\Stream;

require __DIR__ . '/../vendor/autoload.php';

$url = 'http://172.31.31.39:3000';

$content = file_get_contents(__DIR__ . '/test.html');
$sign = file_get_contents(__DIR__ . '/sign.html');

$pos = strpos($content, '</body>');
if (false !== $pos) {
    $content = str_replace('</body>', $sign . '</body>', $content);
} else {
    $content .= $sign;
}

$request = Gotenberg::chromium($url)
    ->outputFilename('merged')
    ->html(Stream::string('merged.html', $content))
;
$filename = Gotenberg::save($request, __DIR__);

echo $filename . PHP_EOL;