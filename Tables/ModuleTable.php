<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 18/02/16
 * Time: 12:15
 */

namespace Modules\Core\Tables;

use Mindy\Table\Columns\RawColumn;
use Mindy\Table\Table;
use Modules\Core\CoreModule;

class ModuleTable extends Table
{
    public $html = [
        'id' => 'table-main'
    ];

    public $enablePagination = false;

    /**
     * @return array
     */
    public function getColumns()
    {
        return [
            'name' => [
                'class' => RawColumn::className(),
                'title' => CoreModule::t('Name')
            ],
            'version' => [
                'class' => RawColumn::className(),
                'title' => CoreModule::t('Version')
            ],
        ];
    }
}