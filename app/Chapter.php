<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $table = 'chapters';
    protected $fillable = ['book_id', 'name', 'order'];
    protected $hidden = ['created_at', 'updated_at'];

    public static function createrules()
    {
        return [];
    }

    public static function updaterules($id)
    {
        return [];
    }
}
