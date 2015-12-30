<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $table = 'publishers';
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];

    public static function createrules()
    {
        return [
            'name' => 'required|unique:publishers',
        ];
    }

    public static function updaterules($id)
    {
        return [
            'name' => 'required|unique:publishers,name,'.$id
        ];
    }
}
