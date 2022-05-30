<?php
declare(strict_types=1);

namespace Flownative\PreloadPrimer;

/*
 * This file is part of the Flownative.PreloadPrimer package.
 *
 * (c) Robert Lemke, Flownative GmbH - www.flownative.com
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Flow\Core\Bootstrap;
use Neos\Flow\Package\Package as BasePackage;

class Package extends BasePackage
{
    /**
     * @param Bootstrap $bootstrap
     */
    public function boot(Bootstrap $bootstrap)
    {
        $dispatcher = $bootstrap->getSignalSlotDispatcher();
        $dispatcher->connect(Bootstrap::class, 'finishedRuntimeRun', function () use ($bootstrap) {
            if (!file_exists(FLOW_PATH_CONFIGURATION . $bootstrap->getContext() . '/PreloadingFiles.on')) {
                return;
            }

            $preloadingFilesPathAndFilename = FLOW_PATH_CONFIGURATION . $bootstrap->getContext() . '/PreloadingFiles.json';
            if (file_exists($preloadingFilesPathAndFilename)) {
                $files = json_decode(file_get_contents($preloadingFilesPathAndFilename), true, 512, JSON_THROW_ON_ERROR);
            } else {
                $files = [];
            }
            foreach (get_included_files() as $newFile) {
                if (!isset($files[$newFile])) {
                    $files[$newFile] = 1;
                } else {
                    $files[$newFile]++;
                }
            }
            file_put_contents($preloadingFilesPathAndFilename, json_encode($files, JSON_THROW_ON_ERROR));
        });
    }
}
