<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];

    public static function createrules()
    {
        return [
            'name' => 'required|unique:languages',
        ];
    }

    public static function updaterules($id)
    {
        return [
            'name' => 'required|unique:languages,name,'.$id
        ];
    }
}
