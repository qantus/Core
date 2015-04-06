<?php

namespace Modules\Core\Controllers;

use Mindy\Base\Mindy;
use Mindy\Helper\Json;

class ApiBaseController extends CoreController
{
    protected function formatReactRoute(array $data)
    {
        list($routeData, $paramsData) = $data;
        $tmp = explode('\\', array_shift($routeData));
        $reactRoute = $tmp[2] . ucfirst(array_shift($routeData));
        return [
            'route' => $reactRoute,
            'data' => $paramsData
        ];
    }

    protected function getReactRoute($httpMethod, $uri)
    {
        $router = Mindy::app()->urlManager;
        $uri = strtok($uri, '?');
        $uri = ltrim($uri, '/');
        $data = $router->dispatchRoute($httpMethod, $uri);
        if ($data === false) {
            if ($router->trailingSlash && substr($uri, -1) !== '/') {
                $data = $router->dispatchRoute($httpMethod, $uri . '/');
                if ($data === false) {
                    return false;
                }
                return $this->formatReactRoute($data);
            } else {
                return false;
            }
        }

        return $this->formatReactRoute($data);
    }
}