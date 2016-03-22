<?php

namespace Modules\Core\Controllers;

use Mindy\Base\ApplicationList;
use Mindy\Base\Mindy;
use Mindy\Http\Request;
use Modules\Core\CoreModule;
use Modules\Meta\Components\MetaTrait;
use Modules\User\Permissions\PermissionControlFilter;

class BackendController extends Controller
{
    use MetaTrait;

    public function __construct($id, $module = null, Request $request)
    {
        parent::__construct($id, $module, $request);

        $this->pageTitle = CoreModule::t('Control panel');

        $user = Mindy::app()->getUser();
        if (
            $user === null ||
            ($user && ($user->is_superuser == false || $user->is_staff == false))
        ) {
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
