<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

// use Spatie\Permission\PermissionRegistrar;

class Organization extends Model
{
    use HasFactory;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'organization_has_permissions');
    }

    public function can($permissionName)
    {
        foreach($this->permissions as $index => $permission)
        {
            if($permission->name == $permissionName)
            {
                return 1;
            }
        }
    }
}
