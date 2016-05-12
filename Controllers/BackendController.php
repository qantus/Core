<?php

namespace Modules\Core\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\CoreModule;
use Modules\Core\Components\MetaTrait;

class BackendController extends Controller
{
    use MetaTrait;

    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);

        $this->pageTitle = CoreModule::t('Control panel');

        $user = Mindy::app()->getUser();
        if ($user === null) {
            $this->getRequest()->redirect('admin:login');
        } else if ($user->is_superuser) {

        } else if ($user->is_staff == false) {
            $this->getRequest()->redirect('admin:login');
        }
    }

    public function accessRules()
    {
        return [
            // allow only authorized users
            ['allow' => true, 'users' => ['@']],
            // deny all users
            ['allow' => false, 'users' => ['*']],
        ];
    }
}
