<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $fillable = ['isbn', 'isbn-13', 'book_type_id', 'title', 'description', 'language_id', 'subject_id', 'publisher_id', 'published'];
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
