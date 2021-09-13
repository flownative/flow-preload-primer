#!/usr/bin/env php
<?php
$files = json_decode(file_get_contents(__DIR__ . '/../../../Configuration/Persistent/preloading-files.json'), true);
$maximum = max($files);

file_put_contents('../../../Data/Logs/Preloading.log', 'Preloading files ...', FILE_APPEND);


foreach($files as $file => $incidence) {
    if ($incidence === $maximum) {
        opcache_compile_file($file);
        file_put_contents('../../../Data/Logs/Preloading.log', sprintf('Compiled %s', $file), FILE_APPEND);
    }
}
