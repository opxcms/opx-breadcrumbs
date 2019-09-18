<?php

namespace Modules\Opx\Breadcrumbs;

use Illuminate\Support\Facades\Facade;

/**
 * @method  static string  name()
 * @method  static string  make($model, $currentAsH1 = false, $classPrefix = 'breadcrumbs'): ?string
 * @method  static string  path($path = '')
 * @method  static array|string|null  config($key = null)
 * @method  static mixed  view($view)
 */
class OpxBreadcrumbs extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'opx_breadcrumbs';
    }
}
