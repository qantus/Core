<?php

namespace Modules\Core;

use Mindy\Base\Mindy;
use Mindy\Base\Module;
use Mindy\Helper\Alias;
use Mindy\Helper\Json;
use Mindy\Locale\Translate;
use Modules\Core\Models\UserLog;
use Modules\User\Models\Session;

class CoreModule extends Module
{
    /**
     * @var string
     */
    public $repositoryUrl = 'http://store.mindy-cms.com/api/v1/package';
    /**
     * @var \Mindy\Update\Update
     */
    public $update;

    public static function preConfigure()
    {
        $app = Mindy::app();

        $tpl = $app->template;
        $tpl->addHelper('get_static_version', function () {
            $filePath = Alias::get('www.static') . '/package.json';
            $content = file_get_contents($filePath);
            $data = JSON::decode($content);
            return $data['version'];
        });
        $tpl->addHelper('t', function ($text, $category, $params = []) {
            if ($category !== 'app' && !strpos($category, '.')) {
                $category .= '.main';
            }
            $findCategory = explode('.', $category);
            $moduleNameRaw = ucfirst($findCategory[0]);
            if (Mindy::app()->hasModule($moduleNameRaw)) {
                $module = Mindy::app()->getModule($moduleNameRaw);
                $moduleName = get_class($module) . '.' . $findCategory[1];
                return Mindy::t($moduleName, $text, $params);
            } else {
                return $text;
            }
        });
        $tpl->addHelper('convert_base64', ['\Modules\Mail\Helper\MailHelper', 'convertToBase64']);
        $tpl->addHelper('ucfirst', ['\Mindy\Helper\Text', 'mbUcfirst']);
        $tpl->addHelper('debug_panel', ['\Modules\Core\Components\DebugPanel', 'render']);
        $tpl->addHelper('param', ['\Modules\Core\Components\ParamsHelper', 'get']);
        $tpl->addHelper('humanizeDateTime', ['\Modules\Core\Components\Humanize', 'humanizeDateTime']);
        $tpl->addHelper('locale', function() use ($app) {
            return $app->locale;
        });
        $tpl->addHelper('humanizeSize', ['\Modules\Core\Components\Humanize', 'humanizeSize']);
        $tpl->addHelper('humanizePrice', ['\Modules\Core\Components\Humanize', 'numToStr']);
        $tpl->addHelper('limit', ['\Mindy\Helper\Text', 'limit']);
        $tpl->addHelper('strtotime', 'strtotime');
        $tpl->addHelper('time', 'time');
        $tpl->addHelper('is_file', 'is_file');
        $tpl->addHelper('d', 'd');
        $tpl->addHelper('locale_date', function ($timestamp, $format = 'd MMMM yyyy') {
            return Translate::getInstance()->getDateFormatter()->format($format, $timestamp);
        });
        $tpl->addHelper('method_exists', function ($obj, $name) {
            return method_exists($obj, $name);
        });
    }

    public function init()
    {
        // $this->update = new Update([
        //     'repoUrl' => $this->repositoryUrl,
        //     'installDir' => Alias::get('application.Modules'),
        //     'downloadDir' => Alias::get('application.runtime'),
        // ]);
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
//                 [
//                     'name' => self::t('Modules'),
//                     'url' => 'core:module_list'
//                 ],
//                [
//                    'name' => self::t('Help'),
//                    'url' => 'core:help-online'
//                ]
            ]
        ];
    }

    public function getVersion()
    {
        return '0.4';
    }
}
