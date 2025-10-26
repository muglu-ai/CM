<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // If the request expects JSON, return a 403 JSON response for unauthorized access
        if ($request->expectsJson() && (! $user || ! ($user->is_admin ?? false))) {
            Log::warning('Admin access denied (AJAX)', [
                'user_id' => $user->id ?? null,
                'user_email' => $user->email ?? null,
                'path' => $request->fullUrl(),
            ]);

            return response()->json(['message' => 'Unauthorized. Admin access only.'], 403);
        }

        // Record intended admin URL so we can optionally redirect after login/role change
        session(['admin.intended' => $request->fullUrl()]);

        // If user isn't authenticated, let the auth middleware handle it (redirect to login).
        // But if this middleware is reached and there's no user, redirect to public sessions page.
        if (! $user) {
            Log::info('Admin access attempt by guest - redirecting to public sessions', ['path' => $request->fullUrl()]);

            return redirect()->route('sessions.index');
        }

        // If the user is not an admin, redirect them to the public sessions listing and log the attempt.
        if (! ($user->is_admin ?? false)) {
            Log::warning('Admin access denied', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'path' => $request->fullUrl(),
            ]);

            // Optionally add a flash message to explain the redirect
            session()->flash('error', 'You do not have access to the admin area.');

            return redirect()->route('sessions.index');
        }

        return $next($request);
    }
}
