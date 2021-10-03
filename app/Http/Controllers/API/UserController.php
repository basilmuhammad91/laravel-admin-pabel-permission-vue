<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
$this->authorize('view_roles');
        $users = User::latest()->get();
        
        $users->transform(function($user){
            $user->role = $user->getRoleNames()->first();
            $user->userPermissions = $user->getPermissionNames();
            return $user;
        });

        return response()->json([
            'users' => $users
        ], 200);
    }
}
