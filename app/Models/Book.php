<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'description','image',
    ];

    protected $dates = ['deleted_at'];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function lendings()
    {
        return $this->belongsToMany(Lending::class);
    }
}
