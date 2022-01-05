<?php 

namespace App\Http\Middleware;

use Closure;

class IsTeacher
{
	public function handle($request, Closure $next)
    {
        $user = $request->user();
 
        if ($user->status == 1)
        {
            return $next($request);
        }
        return redirect()->route('home', ['popupError' => "teacher"]);
    }
}