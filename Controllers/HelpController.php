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
 * @date 03/09/14.09.2014 17:35
 */

namespace Modules\Core\Controllers;

use Mindy\Base\ApplicationList;

class HelpController extends BackendController
{
    public function actionIndex()
    {
        echo $this->render('core/help.html');
    }
}
