<?php

namespace Modules\Core\Controllers;

use Mindy\Base\Mindy;
use Mindy\Exception\HttpException;

/**
 *
 * CoreController class file.
 *
 * @author Falaleev Maxim <max@studio107.com>
 * @link http://studio107.ru/
 * @copyright Copyright &copy; 2010-2012 Studio107
 * @license http://www.cms107.com/license/
 * @package modules.core.components
 * @since 1.1.1
 * @version 1.0
 *
 */
class CoreController extends Controller
{
    public $menu = [];

    public function accessRules()
    {
        return [
            // Запрещаем все для всех пользователей по умолчанию
            ['deny', 'users' => ['*']],
        ];
    }

    public function filters()
    {
        $filters = [];

//        if(Yii::app()->hasModule('user')) {
//            $filters[] = array(
//                'user.components.MPermissionControlFilter',
//                'allowedActions' => $this->allowedActions()
//            );
//        } else
//            $filters[] = array('accessControl');

        return $filters;
    }

    /**
     * @DEPRECATED
     * @param $url
     * @param null $data
     * @param int $statusCode
     */
    public function redirect($url, $data = null, $statusCode = 302)
    {
        $this->r->redirect($url, $data, $statusCode);
    }

    /**
     * @TODO: раскомментировать если {@link CoreController:filters()} MPermissionControlFilter не будет отрабатывать
     *
     * Проверяем права доступа
     * @param $filterChain
     */
//    public function filterPermissionControl($filterChain)
//    {
//        $filter = new MPermissionControlFilter();
//        $filter->allowedActions = $this->allowedActions();
//        $filter->filter($filterChain);
//    }

    /**
     * @return array разрешенные действия (actions) по умолчанию
     */
    public function allowedActions()
    {
        return [];
    }

    public function init()
    {
        // Рендрим представление на ajax запрос после loginRequired
//        Yii::app()->user->loginRequiredAjaxResponse = CJSON::encode(array(
//            'content' => $this->renderPartial('user.views.login.login_required', array(), true)
//        ));
    }

    public function behaviors()
    {
        $behaviors = [];
        if (Mindy::app()->hasModule('meta')) {
            $behaviors['Meta'] = 'meta.behaviors.MAutoMetaControllerBehavior';
        }
        return $behaviors;
    }

    /**
     * Denies the access of the user.
     * @param string $message the message to display to the user.
     * This method may be invoked when access check fails.
     * @throws HttpException when called unless login is required.
     */
    public function accessDenied($message = null)
    {
        $user = Mindy::app()->auth->getModel();
        if ($user === null) {
            $this->loginRequired();
        } else {
            $this->error(403, $message);
        }
    }

    public function loginRequired()
    {
        $app = Mindy::app();
        $route = $app->getModule('user')->getLoginUrl();
        $app->request->redirect($route);
    }

    /**
     * Запрет логирования при ajax запросах
     * @param string $id
     * @param null $module
     */
    /*
    public function beforeAction(CAction $action)
    {
        if (Mindy::app()->request->isAjaxRequest) {
            if (isset(Mindy::app()->log->routes['profile'])) {
                Mindy::app()->log->routes['profile']->enabled = false;
            }
            if (isset(Mindy::app()->log->routes['web'])) {
                Mindy::app()->log->routes['web']->enabled = false;
            }
        }
        return parent::beforeAction($action);
    }
    */

    public function actionError()
    {
        if ($error = Mindy::app()->errorHandler->error) {
            $this->render('error', array('error' => $error));
        }
    }

    public function getNextUrl()
    {
        if (isset($_POST['_next']) || isset($_GET['_next'])) {
            if (isset($_POST['_next']) && !empty($_POST['_next'])) {
                return $_POST['_next'];
            } else if (isset($_GET['_next']) && !empty($_GET['_next'])) {
                return $_GET['_next'];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * If isset next attribute in $_POST or $_GET - redirect
     * @void
     */
    protected function redirectNext()
    {
        if ($url = $this->getNextUrl()) {
            $this->redirect($url);
        }
    }
}
