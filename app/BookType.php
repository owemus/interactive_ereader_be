<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookType extends Model
{
    protected $table = 'book_types';
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];

    public static function createrules()
    {
        return [
            'name' => 'required|unique:book_types',
        ];
    }

    public static function updaterules($id)
    {
        return [
            'name' => 'required|unique:book_types,name,'.$id
        ];
    }
}
