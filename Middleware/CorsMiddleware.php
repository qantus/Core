<?php

namespace Modules\Core\Middleware;

use Mindy\Helper\Console;
use Mindy\Http\Request;
use Mindy\Middleware\Middleware;

class CorsMiddleware extends Middleware
{
    public function processRequest(Request $request)
    {
        if (Console::isCli() == false) {
            $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '*';
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Access-Control-Allow-Methods: GET, PUT, PATCH, POST, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: X-Auth-Key, X-Requested-With, X-CSRFToken, Content-Type');

            // respond to preflights
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
                exit;
            }
        }
    }
}
