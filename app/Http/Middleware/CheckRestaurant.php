<?php

namespace App\Http\Middleware;

use Closure;
use App\Restaurant;

class CheckRestaurant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(isset(\Route::current()->parameters()['restaurantSlug'])){
                    
          $restaurantSlug = \Route::current()->parameters()['restaurantSlug'];

          try {
            $tenant = Restaurant::whereSlug($restaurantSlug)->firstOrFail();
            
            $request->session()->put('restaurant', $tenant);
            
          } catch (\Exception $e) {
            
            return redirect('/errors')->withErrors($e->getMessage());
            //return back()->withError('Restaurante não Existe');
          }
          
        }else{
        
          return back()->withError('Especifique o Restaurante na Url. ex: admin/restaurante');
        }

        return $next($request);
    }
}