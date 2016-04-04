<?php
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
 * @date 11/07/14.07.2014 16:04
 */

namespace Modules\Core\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\CoreModule;
use Modules\Core\Tables\ModuleTable;

class ModulesController extends BackendController
{
    public function actionIndex()
    {
        $modules = [];
        $modulesRaw = Mindy::app()->getModules();
        foreach (array_keys($modulesRaw) as $name) {
            $modules[] = Mindy::app()->getModule($name);
        }

        $this->addBreadcrumb(CoreModule::t('Core'));
        $this->addBreadcrumb(CoreModule::t('Modules'));

        echo $this->render('core/module_list.html', [
            'module' => $this->getModule(),
            'modules' => $modules,
            'table' => new ModuleTable($modules)
        ]);
    }

}
