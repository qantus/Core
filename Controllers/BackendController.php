<?php

namespace Modules\Core\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\CoreModule;

class BackendController extends CoreController
{
    public function accessRules()
    {
        return [
            // allow only authorized users
            ['allow', 'users' => ['@']],
            // deny all users
            ['deny', 'users' => ['*']],
        ];
    }

    public function filters()
    {
        $filters = [];
        if(Mindy::app()->hasModule('User')) {
            $filters[] = [
                '\Modules\User\Components\PermissionControlFilter',
                'allowedActions' => $this->allowedActions()
            ];
        } else {
            $filters[] = ['accessControl'];
        }
        return $filters;
    }

    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);

        $this->pageTitle = CoreModule::t('Control panel');

        $user = Mindy::app()->user;
        if ($user === null || ($user && ($user->is_superuser === false || $user->is_staff === false))) {
            $this->redirect('admin.login');
        }
    }
}
