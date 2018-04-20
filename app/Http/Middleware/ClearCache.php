<?php
/**
 * Created by PhpStorm.
 * User: josephmontanez
 * Date: 7/10/17
 * Time: 12:40 PM
 */

namespace App\Http\Middleware;


use Closure;
use Illuminate\Foundation\Application;

class ClearCache
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle($request, Closure $next)
    {
        if (env('APP_ENV') === 'local') {
            $cachedViewsDirectory = config('view.compiled');
            $files = glob($cachedViewsDirectory . DIRECTORY_SEPARATOR . '*');
            if($files){
                foreach ($files as $file) {
                    if (is_file($file)) {
                        @unlink($file);
                    }
                }
            }
        }

        return $next($request);
    }
}