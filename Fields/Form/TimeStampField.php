<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 13/08/14
 * Time: 10:29
 */

namespace Modules\Core\Fields\Form;


use Mindy\Form\Fields\TextField;

class TimeStampField extends TextField
{
    public $format = 'd.m.Y';
    public $autoNow = false;

    public function getValue(){
        $value = parent::getValue();

        if (!$value && $this->autoNow) {
            $this->value = $value = time();
        }

        if(is_numeric($value) === false) {
            $value = strtotime($value);
        }

        return date($this->format, $value ? $value : time());
    }
} 