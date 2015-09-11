<?php

namespace Modules\Core\Middleware;

use Mindy\Helper\Console;
use Mindy\Http\Request;
use Mindy\Middleware\Middleware;

class CorsMiddleware extends Middleware
{
    /**
     * @var array
     */
    public $methods = [];
    /**
     * @var array
     */
    public $headers = [];

    public function processRequest(Request $request)
    {
        if (Console::isCli() == false) {
            $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '*';
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Access-Control-Allow-Methods: ' . (is_string($this->methods) ? $this->methods : implode($this->methods, ', ')));
            header('Access-Control-Allow-Headers: ' . (is_string($this->headers) ? $this->headers : implode($this->headers, ', ')));

            // respond to preflights
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
                exit;
            }
        }
    }
}
