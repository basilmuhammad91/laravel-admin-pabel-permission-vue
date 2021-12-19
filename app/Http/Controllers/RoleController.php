<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Organization;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(Role $role)
    {
        $this->role = $role;
        $this->middleware('auth');
        // $this->middleware('can: view_roles');
    }

    public function index()
    {
        // $this->authorize('view_roles');
        $roles = $this->role::all();
        return view('role.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->permissions;
        // $this->validate($request, [
        //     "name" =>"required"
        // ]);

        // $role = $this->role->create([
        //     "name" =>$request->name
        // ]);

        // if($request->has('permissions'))
        // {
        //     // $role->givePermissionTo($request->permissions);
        //     $permissionIds = [];
        //     // foreach($request->permissions as $permission)
        //     // {
        //     //     $permissionIds = $permission->id;
        //     // }

        //     $role->permissions()->sync([1,2,3]);
        // }

        $org = Organization::first();
        $org->permissions()->sync([3,2,5]);

        return $org->permissions;

        return response()->json("Role Created", 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAllRoles()
    {
        $roles = Role::latest()->get();
        return response()->json([
            'roles' => $roles
        ], 200);
    }
}
