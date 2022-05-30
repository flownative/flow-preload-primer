#!/usr/bin/env php
<?php
declare(strict_types=1);

$context = getenv('FLOW_CONTEXT');
$preloadingFilesPathAndFilename = __DIR__ . '/../../../../Configuration/' . $context . '/PreloadingFiles.json';
$logPathAndFilename = __DIR__ . '/../../../../Data/Logs/Preloading.log';

if (!file_exists($preloadingFilesPathAndFilename)) {
    file_put_contents($logPathAndFilename, sprintf('%s does not exist', $preloadingFilesPathAndFilename) . PHP_EOL, FILE_APPEND);
    return;
}

$files = json_decode(file_get_contents($preloadingFilesPathAndFilename), true, 512, JSON_THROW_ON_ERROR);
$maximum = max($files);

file_put_contents($logPathAndFilename, 'Preloading files ...' . PHP_EOL, FILE_APPEND);

foreach ($files as $file => $incidence) {
    if ($incidence === $maximum) {
        opcache_compile_file($file);
        file_put_contents($logPathAndFilename, sprintf('Compiled %s', $file) . PHP_EOL, FILE_APPEND);
    }
}

file_put_contents($logPathAndFilename, 'Preloading done.' . PHP_EOL . PHP_EOL, FILE_APPEND);
