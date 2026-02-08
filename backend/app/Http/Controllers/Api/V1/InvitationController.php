<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\Role;

class InvitationController extends Controller
{

    // SEND INVITE
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|string'
        ]);

        $role = Role::where('name', $request->role)->firstOrFail();

        $invite = Invitation::create([
            'email' => $request->email,
            'role_id' => $role->id,
        ]);

        return response()->json([
            'success' => true,
            'invite_token' => $invite->token,
            'expires_at' => $invite->expires_at
        ]);
    }

    // ✅ ACCEPT INVITATION (Important Fix goes here)
    public function accept(Request $request, $token)
    {
        $invite = Invitation::withoutGlobalScopes()
            ->where('token', $token)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $user = $request->user();

        if ($user->email !== $invite->email) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user->organizations()->syncWithoutDetaching([
            $invite->organization_id => ['role_id' => $invite->role_id]
        ]);

        $invite->delete();

        return response()->json(['success' => true]);
    }
}
