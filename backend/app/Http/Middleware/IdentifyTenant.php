<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Organization;

class IdentifyTenant
{
    public function handle(Request $request, Closure $next)
    {

        if ($request->is('api/health')) {
            return $next($request);
        }
        $orgId = $request->header('X-Organization-ID');

        if (!$orgId) {
            return response()->json(['message' => 'Organization header missing'], 400);
        }

        $organization = Organization::find($orgId);

        if (!$organization) {
            return response()->json(['message' => 'Invalid organization'], 403);
        }

        // Save current organization globally for this request
        app()->instance('currentOrganization', $organization);

        return $next($request);
    }
}
