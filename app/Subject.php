<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];

    public static function createrules()
    {
        return [
            'name' => 'required|unique',
        ];
    }

    public static function updaterules($id)
    {
        return [
            'name' => 'required|unique:languages,name,'.$id
        ];
    }
}