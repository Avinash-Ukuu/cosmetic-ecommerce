<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('authorization');

        if (empty($token)) {
            return response()->json(['message' => 'Token missing'], 401);
        }

        $user = User::with(['customer.addresses', 'roles'])->where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (!$user->customer) {
            return response()->json(['message' => 'Unauthorized: Customer profile missing'], 403);
        }

        // Check if the user has the required roles (example: checking if any roles exist)
        if ($user->roles->isEmpty()) {
            return response()->json(['message' => 'Unauthorized: Role missing'], 403);
        }
        // Log in the user for this request
        Auth::login($user);

        return $next($request);
    }
}
