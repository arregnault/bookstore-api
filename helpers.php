<?php
/*
|--------------------------------------------------------------------------
| Librería de Funciones Globales
|--------------------------------------------------------------------------
| Configuración base.
|
*/

/*
*   Puente para mantener/respetar funciones por defecto de Laravel
*/
if (!function_exists('artisan')) {
    function artisan()
    {
        return app()->make('Illuminate\Contracts\Console\Kernel');
    }
}


/*
|--------------------------------------------------------------------------
| Funciones
|--------------------------------------------------------------------------
|
|
*/


function days_pass($date)
{
    $now = time();
    $your_date = strtotime($date);
    $datediff = $now - $your_date;

    return round($datediff / (60 * 60 * 24));
}
