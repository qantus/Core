<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 13/08/14
 * Time: 07:46
 */
namespace Modules\Core\Fields\Orm;

use Mindy\Orm\Fields\IntField;

class TimeStampField extends IntField
{
    public function setValue($value)
    {
        if (is_string($value)) {
            return $this->value = strtotime($value);
        }else{
            return parent::setValue($value);
        }
    }
}