<?php

namespace App\Http\Middleware;

use App\Exceptions\CreateApiException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $user_type = $user->user_type;
        if ($user_type !== 'student') throw new CreateApiException('Forbidden', 403);
        return $next($request);
    }
}
