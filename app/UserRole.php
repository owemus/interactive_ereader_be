<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_roles';
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];

    public static function createrules()
    {
        return [
            'name' => 'required|unique:user_roles',
        ];
    }

    public static function updaterules($id)
    {
        return [
            'name' => 'required|unique:user_roles,name,'.$id
        ];
    }
}
