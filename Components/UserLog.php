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

use Modules\Core\Components\Humanize;
use Mindy\Base\Mindy;
use Mindy\Helper\Alias;
use Modules\User\UserModule;

class UserLog
{
    public static $key = 'users';

    public static function log($message)
    {
        $app = Mindy::app();
        $user_pk = 0;
        if ($app->user->pk) {
            $user_pk = $app->user->pk;
        }

        $username = UserModule::t('Guest');
        if ($app->user->username) {
            $username = $app->user->username;
        }

        return $app->logger->info($user_pk . ' ' . $username . ' ' . $message, self::$key);
    }

    public static function replaceLinks($line)
    {
        return preg_replace('/\[\[(.*)\|(.*)\]\]/', '<a href="${1}">${2}</a>', $line);
    }

    public static function read($count)
    {
        $path = Alias::get('application.runtime.users') . '-' .date('Y-m-d') . '.log';
        if(file_exists($path) === false) {
            file_put_contents($path, '');
            return [];
        }
        $lines = explode("\n", file_get_contents($path));
        unset($lines[count($lines) - 1]);
        $lines = array_reverse($lines);
        $lines = array_map(function (&$line) {

            $tmp = self::replaceLinks($line);

            $tmp = explode(' ', $tmp);
            $date = array_shift($tmp);
            $time = array_shift($tmp);
            $user_id = array_shift($tmp);
            $username = array_shift($tmp);
            $humanized = Humanize::humanizeDateTime($date . ' ' . $time);

            return [
                'date' => $date,
                'time' => $time,
                'user_id' => $user_id,
                'username' => $username,
                'message' => implode(' ', $tmp),
                'humanized_date' => $humanized
            ];
        }, $lines);
        return array_slice($lines, 0, $count);
    }
}
