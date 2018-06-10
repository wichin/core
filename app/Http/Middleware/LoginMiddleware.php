<?php namespace App\Http\Middleware;

use App\Http\Controllers\LoginController;
use Closure;

class LoginMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$Login = new LoginController();
		
		if ($Login->CheckSession())
		{
			return $next($request);	
		}
		else
		{
			return redirect(url('/login'));
		}
		
	}

}
