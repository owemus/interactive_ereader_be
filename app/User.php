<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['user_role_id', 'first_name', 'last_name', 'email', 'dob', 'gender'];
    protected $hidden = ['created_at', 'updated_at'];

    public static function createrules()
    {
        return [
            'user_role_id' => 'required|exists:user_roles,id',
            'email' => 'required|unique:users',
        ];
    }

    public static function updaterules($id)
    {
        return [
            'user_role_id' => 'required|exists:user_roles,id',
            'email' => 'required|unique:users,email,'.$id
        ];
    }

    public function role()
    {
        return $this->belongsTo('App\UserRole');
    }
}
