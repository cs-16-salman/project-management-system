<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Role;

class OrganizationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $user = $request->user();

        $org = Organization::create([
            'name' => $request->name,
            'owner_id' => $user->id,
        ]);

        // Attach user as Organization Admin
        $adminRole = Role::where('name', 'Organization Admin')->first();

        $user->organizations()->attach($org->id, [
            'role_id' => $adminRole->id
        ]);

        return response()->json([
            'success' => true,
            'organization' => $org
        ], 201);
    }
}
