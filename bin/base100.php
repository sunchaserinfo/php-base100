<?php

use SunChaser\Base100\Base100;

const MODE_ENCODE = 1;
const MODE_DECODE = 2;

if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require(__DIR__ . '/../vendor/autoload.php');
} elseif (is_file(__DIR__ . '/../../../autoload.php')) {
    require(__DIR__ . '/../../../autoload.php');
} else {
    die(
        'You must set up base100 dependencies, run the following commands:' . PHP_EOL .
        'curl -s http://getcomposer.org/installer | php' . PHP_EOL .
        'php composer.phar install' . PHP_EOL
    );
}

switch (true) {
    case $argc === 1:
        $mode = MODE_ENCODE;
        break;

    case $argc === 2 && in_array($argv[1], ['-d', '--decode']);
        $mode = MODE_DECODE;
        break;

    default:
        echo <<<HELP
base100
    encode to base100

base100 (-d|--decode)
    decode from base100
HELP;
}

$in = fopen('php://stdin', 'r');
$out = fopen('php://stdout', 'w');

while (!feof($in)) {
    $data = fread($in, 1024); // length must be divisible by 4 for decoding

    $encoded = $mode === MODE_ENCODE ? Base100::encode($data) : Base100::decode(rtrim($data, "\n"));

    fwrite($out, $encoded);
}

fclose($in);
fclose($out);
