<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';
    protected $fillable = ['chapter_id', 'page_no', 'value'];
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
