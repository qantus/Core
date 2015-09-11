<?php

namespace Modules\Core\Controllers;

use Mindy\Base\Mindy;
use Mindy\Controller\BaseController;
use Mindy\Helper\Json;
use Mindy\Utils\RenderTrait;
use Modules\Meta\Components\MetaTrait;


/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 02/04/14.04.2014 16:47
 */
class Controller extends BaseController
{
    use RenderTrait, MetaTrait;

    public function render($view, array $data = [])
    {
        $site = null;
        if (Mindy::app()->hasModule('Sites')) {
            $site = Mindy::app()->getModule('Sites')->getSite();
        }
        return $this->renderTemplate($view, array_merge([
            'this' => $this,
            'site' => $site,
            'locale' => Mindy::app()->locale
        ], $data));
    }

    public function json(array $data = [])
    {
        header('Content-Type: application/json');
        return JSON::encode($data);
    }
}
