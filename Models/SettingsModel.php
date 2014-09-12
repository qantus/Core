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
 * @date 12/09/14.09.2014 16:27
 */

namespace Modules\Core\Models;

use Exception;
use Mindy\Orm\Manager;
use Mindy\Orm\Model;

abstract class SettingsModel extends Model
{
    public static function __callStatic($method, $args)
    {
        $manager = $method . 'Manager';
        $className = get_called_class();
        if (method_exists($className, $manager) && is_callable([$className, $manager])) {
            throw new Exception("You can't use managers in Settings model");
        } elseif (method_exists($className, $manager) && is_callable([$className, $method])) {
            return call_user_func_array([$className, $method], $args);
        } else {
            throw new Exception("Call unknown method {$method}");
        }
    }

    public function __call($method, $args)
    {
        $manager = $method . 'Manager';
        if (method_exists($this, $manager)) {
            throw new Exception("You can't use managers in Settings model");
        } elseif (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $args);
        } else {
            throw new Exception("Call unknown method {$method}");
        }
    }

    /**
     * @param bool $asArray
     * @return \Mindy\Orm\Orm
     */
    public static function getInstance($asArray = false)
    {
        $className = get_called_class();
        $manager = new Manager(new $className);
        return $manager->asArray($asArray)->getOrCreate(['id' => 1]);
    }

    public static function objectsManager($instance = null)
    {
        throw new Exception("You can't use managers in Settings model");
    }

    public static function treeManager($instance = null)
    {
        throw new Exception("You can't use managers in Settings model");
    }
}