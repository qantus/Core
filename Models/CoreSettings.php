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
 * @date 12/09/14.09.2014 16:15
 */

namespace Modules\Core\Models;

use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Fields\CharField;
use Modules\Core\CoreModule;

class CoreSettings extends SettingsModel
{
    public function __toString()
    {
        return (string) $this->t('Core settings');
    }

    public static function getFields()
    {
        return [
            'sitename' => [
                'class' => CharField::className(),
                'verboseName' => CoreModule::t('Sitename', [], 'settings')
            ],
            'email_owner' => [
                'class' => EmailField::className(),
                'verboseName' => CoreModule::t('Email site owner', [], 'settings')
            ]
        ];
    }
}
