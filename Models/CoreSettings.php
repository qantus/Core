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

use Mindy\Orm\Fields\CharField;

class CoreSettings extends SettingsModel
{
    public static function getFields()
    {
        return [
            'sitename' => [
                'class' => CharField::className()
            ]
        ];
    }
}
