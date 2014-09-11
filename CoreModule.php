<?php

namespace Modules\Core;

use Mindy\Base\Mindy;
use Mindy\Base\Module;
use Mindy\Helper\Alias;
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

    public function init()
    {
        $this->update = new Update([
            'repoUrl' => $this->repositoryUrl,
            'installDir' => Alias::get('application.Modules'),
            'downloadDir' => Alias::get('application.runtime'),
        ]);
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Modules'),
                    'url' => 'core.module_list'
                ]
            ]
        ];
    }

    public function getVersion()
    {
        return '0.4';
    }
}
