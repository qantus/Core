<?php

namespace Modules\Core\Controllers;

use Mindy\Base\Mindy;
use Mindy\Form\ModelForm;
use Mindy\Helper\Alias;
use Modules\Core\CoreModule;

class SettingsController extends BackendController
{
    protected function getSettingsModels()
    {
        $modulesPath = Alias::get('Modules');
        $modules = Mindy::app()->modules;
        $modelsPath = [];
        foreach($modules as $name => $params) {
            $tmpPath = $modulesPath . '/' . $name . '/Models/';
            $paths = glob($tmpPath . '*Settings.php');
            if(!array_key_exists($name, $modelsPath)) {
                $modelsPath[$name] = [];
            }

            if (is_array($paths)) {
                $modelsPath[$name] = array_merge($modelsPath[$name], array_map(function($path) use ($name, $tmpPath) {
                    return 'Modules\\' . $name . '\\Models\\'. str_replace('.php', '', str_replace($tmpPath, '', $path));
                }, $paths));
            }
        }
        return $modelsPath;
    }

    protected function reformatModels(array $moduleModels)
    {
        $models = [];
        foreach($moduleModels as $tmpModels) {
            foreach($tmpModels as $modelClass) {
                $model = $modelClass::getInstance();
                $models[$modelClass] = [
                    'model' => $model,
                    'form' => new ModelForm(['instance' => $model])
                ];
            }
        }
        return $models;
    }

    public function actionIndex()
    {
        $this->addBreadcrumb('Центр настроек');

        $models = $this->reformatModels($this->getSettingsModels());
        if($this->r->isPost) {
            $success = true;
            foreach($models as $data) {
                $form = $data['form'];
                $complete = $form->setAttributes($_POST)->isValid() && $form->save();
                if(!$complete) {
                    $success = false;
                }
            }
            $this->r->flash->success(CoreModule::t($success ? 'Settings saved successfully' : 'Settings save fail'));
        }

        echo $this->render('core/settings.html', [
            'models' => $models,
        ]);
    }
}
