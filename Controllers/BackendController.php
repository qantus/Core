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
    use ApplicationList, MetaTrait;

    public function __construct($id, $module = null, Request $request)
    {
        parent::__construct($id, $module, $request);

        $this->pageTitle = CoreModule::t('Control panel');

        $user = Mindy::app()->getUser();
        if (
            $user === null ||
            ($user && ($user->is_superuser === false || $user->is_staff === false))
        ) {
            $this->getRequest()->redirect('admin:login');
        }
    }

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
        if (Mindy::app()->hasModule('User')) {
            $filters[] = [
                'class' => PermissionControlFilter::class,
                'allowedActions' => $this->allowedActions()
            ];
        } else {
            $filters[] = ['accessControl'];
        }
        return $filters;
    }

    public function render($view, array $data = [])
    {
        return parent::render($view, array_merge($data, [
            'apps' => $this->getApplications()
        ]));
    }
}
