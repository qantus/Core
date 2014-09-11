<?php

namespace Modules\Core\Commands;

use Mindy\Base\ConsoleCommand;
use Mindy\Base\Mindy;
use Mindy\Helper\Alias;
use Mindy\Orm\Model;
use Mindy\Orm\Sync;
use ReflectionClass;

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

class DbCommand extends ConsoleCommand
{
    public function actionIndex()
    {
        echo $this->color("TODO documentation", 'light_red') . PHP_EOL;
    }

    protected function getModels($module = null)
    {
        $checkModule = $module !== null;

        $models = [];

        $modelFiles = glob(Alias::get('Modules') . '/*/Models/*.php');

        foreach(Alias::find('Contrib.*') as $alias) {
            $contribModels = glob($alias . '/*/Models/*.php');
            if($contribModels) {
                $modelFiles = array_merge($modelFiles, $contribModels);
            }
        }

        $modules = [];
        foreach($modelFiles as $file) {
            $moduleName = basename(dirname(dirname($file)));
            if(($checkModule && $module == $moduleName && Mindy::app()->hasModule($moduleName)) || (!$checkModule && Mindy::app()->hasModule($moduleName))) {
                $modules[] = $moduleName;
                $class = str_replace('.php', '', substr($file, strpos($file, 'Modules')));
                $class = str_replace('/', '\\', $class);
                if(is_subclass_of($class, Model::className())) {
                    $reflectClass = new ReflectionClass($class);
                    if($reflectClass->isAbstract()) {
                        continue;
                    }
                    $models[$class] = new $class;
                }
            }
        }
        echo "Modules:" . PHP_EOL;
        echo implode(PHP_EOL, array_unique($modules)) . PHP_EOL;
        return $models;
    }

    public function actionDrop($module = null)
    {
        $models = $this->getModels($module);
        $sync = new Sync(array_values($models));
        $sync->delete();
    }

    public function actionSync($module = null)
    {
        $models = $this->getModels($module);
        $sync = new Sync(array_values($models));
        $sync->create();
    }
}
