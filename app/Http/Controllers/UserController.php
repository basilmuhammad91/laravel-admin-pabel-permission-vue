<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('auth');
    }

    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     "name" => "required|string",
        //     "phone" => "required",
        //     "password" => "required|alpha_num|min:6",
        //     "role" => "required",
        //     "email" => "required|email|unique:users"
        // ]);

        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->assignRole($request->role);
        $user->getPermissionsViaRoles();
        // if($request->has("permissions"))
        // {
        //     $user->givePermissionTo($request->permissions);
        // }

        $user->save();

        return response()->json("User Created", 200);

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
        // $this->validate($request, [
        //     'name' => 'required|string',
        //     'phone' => 'required',
        //     'password' => 'nullable|alpha_num|min:6',
        //     'role' => 'required',
        //     'email' => 'required|email|unique:users,email,'.$id
        // ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if($request->has('password'))
        {
            $user->password = bcrypt($request->password);
        }

        if($request->has('role'))
        {
            $userRole = $user->getRoleNames();
            foreach($userRole as $role)
            {
                $user->removeRole($role);
            }

            $user->assignRole($request->role);
        }

        if($request->has('permissions'))
        {
            $userPermissions = $user->getPermissionNames();
            foreach ($userPermissions as $permission)
            {
                $user->revokePermissionTo($permission);
            }

            
        }
        // $user->givePermissionTo($request->permissions);
        $user->getPermissionsViaRoles();

        $user->save();
        return response()->json([
            "User Updated", 200
        ]);

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

    public function profile()
    {
        return view('profile.index');
    }

    public function post_profile(Request $req)
    {
        $user = Auth::User();
        // $req->validate([
        //     "name" => "required",
        //     "phone" => "required",
        //     "email" => "required|email|unique:users,email|"
        // ]);

     
        $user->update($req->all());

        if($user->update($req->all()))
        {
            return redirect()->back()
            ->with('success','Profile Successfully Updated !')
            ;
        }

    }

    public function getAllUsers()
    {
        // $this->authorize('view_roles');
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

    public function change_password()
    {
        return view('profile.password');
    }

    public function change_password_post(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
            'confirm' => 'required'
        ]);

        $user = Auth()->user();
        $user->update([
            'password' => bcrypt($request->password),
        ]);
        return response()->json([
            "Password Changed", 100
        ]);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(["User Deleted", 200]);
    }

    public function search(Request $req)
    {
        $searchWord = $req->search;

        $users = User::where(function($query) use ($searchWord){
            $query->where('name', 'LIKE', "%$searchWord%")
            ->orWhere('email', 'LIKE', "%$searchWord%");
        })->latest()->get();

        $users->transform(function($user){
            $user->role = $user->getRoleNames()->first();
            $user->userPermissions = $user->getPermissionNames();
            return $user;
        });

        return response()->json([
            "users" => $users
        ], 200);


    }

}
