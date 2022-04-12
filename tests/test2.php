<?php declare(strict_types=1);

use Gotenberg\Gotenberg;
use Gotenberg\Stream;

require __DIR__ . '/../vendor/autoload.php';

$url = 'http://172.31.31.39:3000';

$html = <<<HTML
<style>
table {
    border: 3px solid #4472c4;
    font-weight: bold;
    color: #2e74b5;
    width: 100%;
}
table td {
    border: 1px solid #4472c4;
    padding: 3px 6px;
}
</style>
<table>
<tr>
  <td>Организация, подписант</td>
  <td>Сертификат, серийный номер, владелец</td>
  <td>Дата подписания</td>
</tr>
<tr>
  <td>ООО «МВМ»<br>Байден Джо Обамович</td>
  <td>D46464G665R876292f321<br>Байден Джо Джэкович</td>
  <td>25.03.2022 14:15 GMT+</td>
</tr>
<tr>
  <td>ООО «АПИ»<br>Путин Владимир Владимирович</td>
  <td>S7319T8213W313662W52<br>Путин Владимир Владимирович</td>
  <td>26.03.2022 14:15 GMT+</td>
</tr>
</table>
HTML;

Gotenberg::save(
    Gotenberg::chromium($url)
        ->outputFilename('sign')
        ->html(Stream::string('sign.html', $html)),
    __DIR__
);


Gotenberg::save(
    Gotenberg::libreOffice($url)
        ->outputFilename('content')
        ->convert(Stream::path(__DIR__ . '/content.docx')),
    __DIR__
);

$filename = Gotenberg::save(
    Gotenberg::pdfEngines($url)
        ->outputFilename('merged')
        ->merge(
            Stream::path(__DIR__ . '/content.pdf'),
            Stream::path(__DIR__ . '/sign.pdf')
        ),
    __DIR__
);

unlink(__DIR__ . '/content.pdf');
unlink(__DIR__ . '/sign.pdf');

echo $filename . PHP_EOL;