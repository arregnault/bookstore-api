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
