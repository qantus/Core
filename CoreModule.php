<?php

namespace Modules\Core;

use Mindy\Base\Mindy;
use Mindy\Base\Module;
use Mindy\Update\Update;

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
        $tpl = Mindy::app()->template;
        $tpl->addHelper('t', ['\Mindy\Base\YiiUtils', 't']);
        $tpl->addHelper('convert_base64', ['\Modules\Mail\Helper\MailHelper', 'convertToBase64']);
        $tpl->addHelper('ucfirst', ['\Mindy\Helper\Text', 'mbUcfirst']);
        $tpl->addHelper('debug_panel', ['\Modules\Core\Components\DebugPanel', 'render']);
        $tpl->addHelper('param', ['\Modules\Core\Components\ParamsHelper', 'get']);
        $tpl->addHelper('humanizeDateTime', ['\Modules\Core\Components\Humanize', 'humanizeDateTime']);
        $tpl->addHelper('humanizePrice', ['\Modules\Core\Components\Humanize', 'numToStr']);
        $tpl->addHelper('limit', ['\Mindy\Helper\Text', 'limit']);
        $tpl->addHelper('strtotime', 'strtotime');
        $tpl->addHelper('time', 'time');
        $tpl->addHelper('is_file', 'is_file');
        $tpl->addHelper('d', 'd');
        $tpl->addHelper('method_exists', function ($obj, $name) {
            return method_exists($obj, $name);
        });
        $tpl->addHelper('user_actions', function ($by = 10) {
            return \Modules\Core\Components\UserLog::read($by);
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
                // [
                //     'name' => self::t('Modules'),
                //     'url' => 'core.module_list'
                // ],
                [
                    'name' => self::t('Settings'),
                    'url' => 'core.settings'
                ],
                [
                    'name' => self::t('Help'),
                    'url' => 'core.help-online'
                ]
            ]
        ];
    }

    public function getVersion()
    {
        return '0.4';
    }
}
