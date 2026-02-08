<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $org = app('currentOrganization');

        $perPage = min($request->get('per_page', 10), 100);

        // If user can manage projects → show all org projects
        if ($user->hasPermission('manage_projects')) {
            $query = Project::where('organization_id', $org->id);
        } else {
            // Otherwise show only projects the user belongs to
            $query = Project::withoutGlobalScopes()
                ->where('organization_id', $org->id)
                ->whereHas('users', function ($q) use ($user) {
                    $q->where('users.id', $user->id);
                });
        }

        $projects = $query->paginate($perPage);

        return ApiResponse::paginated($projects, 'Projects fetched successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
