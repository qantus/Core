<?php

namespace Modules\Core\Middleware;

use Mindy\Http\Request;
use Mindy\Middleware\Middleware;

class CorsMiddleware extends Middleware
{
    public function processRequest(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: X-Requested-With, X-CSRFToken');
    }
}
