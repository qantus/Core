<?php

namespace Modules\Core\Commands;

use Mindy\Base\ConsoleCommand;
use Mindy\Base\Mindy;
use Modules\Core\Components\ModuleManager;

/**
 *
 *
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 28/04/14.04.2014 17:53
 */
class ModulesCommand extends ConsoleCommand
{
    public function actionIndex()
    {
        echo $this->color("TODO documentation", 'light_red') . PHP_EOL;
    }

    public function actionInstall($module)
    {
        if($version = ModuleManager::install($module)) {
            echo $this->color("Success. Installed version: " . $version, 'green') . PHP_EOL;
        } else {
            echo $this->color("Failed to install version: " . $version, 'red') . PHP_EOL;
        }
    }

    public function actionUpdate($module, $updateToVersion = null)
    {
        if($version = ModuleManager::update($module, $updateToVersion)) {
            echo $this->color("Success. Installed version: " . $version, 'green') . PHP_EOL;
        } else {
            echo $this->color("Failed to install version: " . $version, 'red') . PHP_EOL;
        }
    }

    public function actionDelete($module)
    {
        if(ModuleManager::delete($module)) {
            echo $this->color("Success.", 'green') . PHP_EOL;
        } else {
            echo $this->color("Failed.", 'red') . PHP_EOL;
        }
    }
}
