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
 * @date 16/07/14.07.2014 12:19
 */

namespace Modules\Core\Components;

use DateTime;
use DateInterval;
use Modules\Core\CoreModule;

class Humanize
{
    /**
     * Функция возвращает окончание для множественного числа слова на основании числа и массива окончаний
     * @param  $number Integer Число на основе которого нужно сформировать окончание
     * @param $endingArray Array Массив слов или окончаний для чисел (1, 4, 5),
     *         например array('яблоко', 'яблока', 'яблок')
     * @return String
     */
    public static function getNumEnding($number, $endingArray)
    {
        $number = $number % 100;
        if ($number >= 11 && $number <= 19)
            $ending = $endingArray[2];
        else
        {
            $i = $number % 10;
            switch ($i)
            {
                case 1: $ending = $endingArray[0]; break;
                case 2:
                case 3:
                case 4: $ending = $endingArray[1]; break;
                default: $ending = $endingArray[2];
            }
        }
        return $ending;
    }

    public static function humanizeDate(DateInterval $diff, DateTime $date, $dateFormat = 'd.m.Y')
    {
        if ($diff->days == 0) {
            return CoreModule::t('Today', [], 'time');
        }elseif($diff->days == 1){
            return CoreModule::t('Yesterday', [], 'time');
        }

        return $date->format($dateFormat);
    }

    public static function humanizeTime(DateInterval $diff, DateTime $date, $timeFormat = 'H:i')
    {
        if ($diff->days == 0 && $diff->h == 0 && $diff->i < 31) {
            $minutes = $diff->i;

            if ($minutes != 0) {
                $ending = [
                    CoreModule::t('minutes1', [], 'time'),
                    CoreModule::t('minutes4', [], 'time'),
                    CoreModule::t('minutes5', [], 'time')
                ];

                $ending = self::getNumEnding($minutes, $ending);

                return [false, CoreModule::t('{minutes} {ending} ago', [
                    '{minutes}' => $minutes,
                    '{ending}' => $ending
                ], 'time')];
            }else{
                return [false, CoreModule::t('Just now', [], 'time')];
            }
        }

        return [true, $date->format($timeFormat)];
    }

    public static function humanizeDateTime($dateRaw, $dateFormat = 'd.m.Y', $timeFormat = 'H:i', $delimiter = ', ')
    {

        $date = new DateTime($dateRaw);
        $now = new DateTime();
        $diff = $date->diff($now);

        $humanizeDate = self::humanizeDate($diff, $date, $dateFormat);
        list($showDate, $humanizeTime) = self::humanizeTime($diff, $date, $timeFormat);

        $humanized = [];
        if ($showDate) {
            $humanized[] = $humanizeDate;
        }
        $humanized[] = $humanizeTime;

        return implode($delimiter, $humanized);
    }
}
