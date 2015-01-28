<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 27/01/15 18:16
 */

namespace Modules\Core\Tables;

use Mindy\Table\Table;

class UserLogTable extends Table
{
    public function getColumns()
    {
        return [
            'created_at',
            'message',
            'ip'
        ];
    }
}
